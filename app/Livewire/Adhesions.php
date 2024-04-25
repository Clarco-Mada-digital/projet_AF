<?php

namespace App\Livewire;

use App\Models\Adhesion;
use App\Models\Categorie;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use PDO;
use PDOException;

#[Layout('layouts.mainLayout')]
class Adhesions extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public string $search_membre = "";
    public $filterByCat = "";
    public $memberResult = [];
    public $newAdhesion = ['profil' => '', 'categorie_id' => "", 'CB' => null, "numCarte" => null];
    public $photo;
    public int $bsSteepActive = 1;
    public $montantAdhesion;
    public $montantPayer;
    public float $montantExam = 0;
    public float $montantPaye = 0;
    public float $montantRestant;
    public $stapes = "new";

    public $categories;
    public $prices;
    public $catPaiement;
    public $moyenPaiement;
    public $statue = 'Totalement';
    public $paiement_id;

    public $inscritBible =  false;
    // public $pmb;

    protected $listeners = ["code_barre_update" => 'defineCB'];

    function connectToDb()
    {
        $serverName = 'localhost:3306';
        $username = "root";
        $password = "";
        

        try{
            $bdd = new PDO("mysql:host=$serverName;dbname=pmb", $username, $password);	
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bdd;
        }
        catch(PDOException $e){
            echo "Échec de la connexion : " . $e->getMessage();
        }
    }
    

    function __construct() 
    {
        $this->categories = Categorie::all();
        $this->prices = Price::all();

        // $this->newAdhesion = Adhesion::find(1)->toArray();
    }

    public function insertToPmb()
    {
        $pmb = $this->connectToDb();
        $req = $pmb->prepare("INSERT INTO empr(empr_cb,empr_nom,empr_prenom,empr_sexe,empr_pays,empr_year,empr_ville,empr_prof,empr_mail,empr_tel1,empr_adr1,empr_categ,empr_creation,empr_modif,empr_date_adhesion,empr_date_expiration,empr_codestat,empr_lang,empr_statut) VALUES(:empr_cb,:empr_nom,:empr_prenom,:empr_sexe,:empr_pays,:empr_year,:empr_ville,:empr_prof,:empr_mail,:empr_tel1,:empr_adr1,:empr_categ,:empr_creation,:empr_modif,:empr_date_adhesion,:empr_date_expiration,:empr_codestat,:empr_lang,:empr_statut)");

        $req->execute(array(
            'empr_cb' => $this->newAdhesion['numCarte'],
            'empr_nom' => $this->newAdhesion['nom'],
            'empr_prenom' => $this->newAdhesion['prenom'],
            'empr_sexe' => $this->newAdhesion['sexe'] == 'M' ? 1 : 2,
            'empr_pays' =>  isset($this->newAdhesion['pays'])? $this->newAdhesion['pays'] : "",
            'empr_year' => isset($this->newAdhesion['dateNaissance']) ? $this->newAdhesion['dateNaissance'] : "",
            'empr_ville' => isset($this->newAdhesion['ville']) ?  $this->newAdhesion['ville'] : "",
            'empr_prof' => isset($this->newAdhesion['profession']) ? $this->newAdhesion['profession'] : "",
            'empr_mail' => isset($this->newAdhesion['email']) ? $this->newAdhesion['email'] : "",
            'empr_tel1' => isset($this->newAdhesion['telephone1']) ? $this->newAdhesion['telephone1'] : "",
            'empr_adr1' => isset($this->newAdhesion['adresse']) ?  $this->newAdhesion['adresse'] : "",
            'empr_categ' => $this->newAdhesion['categorie_id'],
            'empr_creation' => $this->newAdhesion['created_at'],
            'empr_modif' => $this->newAdhesion['updated_at'],
            'empr_date_adhesion' => $this->newAdhesion['created_at'],
            'empr_date_expiration' => Carbon::today()->addYear(),
            'empr_codestat' => 2,
            'empr_lang' => 'Fr',
            'empr_statut' => 1,
            ));              
        
        $this->dispatch("ShowSuccessMsg", ['message' => 'Synchronisation avec success!', 'type' => 'success']);
        $req->closeCursor();
    }

    public function updateToPmb()
    {
        $pmb = $this->connectToDb();
        $req = $pmb->prepare('UPDATE empr SET empr_nom = :empr_nom,empr_prenom = :empr_prenom, empr_sexe = :empr_sexe,empr_pays = :empr_pays,empr_year = :empr_year,empr_ville = :empr_ville,empr_prof = :empr_prof,empr_mail = :empr_mail,empr_tel1 = :empr_tel1,empr_adr1 = :empr_adr1,empr_categ = :empr_categ,empr_creation = :empr_creation,empr_modif = :empr_modif,empr_date_adhesion = :empr_date_adhesion,empr_date_expiration = :empr_date_expiration,empr_codestat = :empr_codestat,empr_lang = :empr_lang,empr_statut = :empr_statut WHERE empr_cb = :empr_cb');

        $req->execute(array(
            'empr_cb' => $this->newAdhesion['CB'],
            'empr_nom' => $this->newAdhesion['nom'],
            'empr_prenom' => $this->newAdhesion['prenom'],
            'empr_sexe' => $this->newAdhesion['sexe'] == 'M' ? 1 : 2,
            'empr_pays' =>  $this->newAdhesion['pays'],
            'empr_year' => $this->newAdhesion['dateNaissance'],
            'empr_ville' => $this->newAdhesion['ville'],
            'empr_prof' => $this->newAdhesion['profession'],
            'empr_mail' => $this->newAdhesion['email'],
            'empr_tel1' => $this->newAdhesion['telephone1'],
            'empr_adr1' => $this->newAdhesion['adresse'],
            'empr_categ' => $this->newAdhesion['categorie_id'],
            'empr_creation' => $this->newAdhesion['created_at'],
            'empr_modif' => $this->newAdhesion['updated_at'],
            'empr_date_adhesion' => $this->newAdhesion['created_at'],
            'empr_date_expiration' => $this->newAdhesion['finAdhesion'],
            'empr_codestat' => 2,
            'empr_lang' => 'Fr',
            'empr_statut' => 1,
            ));              
        
        $this->dispatch("ShowSuccessMsg", ['message' => 'Synchronisation avec success!', 'type' => 'success']);
        $req->closeCursor();
    }

    public function getDataPmb()
    {
        $pmb = $this->connectToDb();
        $sql = 'SELECT * FROM empr';
        $r = $pmb->query( $sql );

        $adhesion_id = [];
        $allAdhesion =  Adhesion::all();
        foreach ($allAdhesion as $adhesion)
        {
            if ($adhesion->CB != null)
            {
                array_push($adhesion_id, $adhesion->id);
            }
        }
        // On affiche chaque entrée une à une
        while ($donnees = $r->fetch())
        {

            $this->newAdhesion['numCarte'] = $donnees['empr_cb'];
            $this->newAdhesion['CB'] = $donnees['empr_cb'];
            $this->newAdhesion['nom'] = $donnees['empr_nom'];
            $this->newAdhesion['prenom'] = $donnees['empr_prenom'];
            $this->newAdhesion['sexe'] = $donnees['empr_sexe'];
            $this->newAdhesion['nationalite'] = $donnees['empr_pays'];
            $this->newAdhesion['dateNaissance'] = $donnees['empr_year'];
            $this->newAdhesion['profession'] = $donnees['empr_prof'];
            $this->newAdhesion['email'] = $donnees['empr_mail'];
            $this->newAdhesion['telephone1'] = $donnees['empr_tel1'];
            $this->newAdhesion['telephone2'] = $donnees['empr_tel2'];
            $this->newAdhesion['adresse'] = $donnees['empr_adr1'];
            $this->newAdhesion['categorie_id'] = 2;
            $this->newAdhesion['user_id'] = 1;
            $this->newAdhesion['created_at'] = $donnees['empr_date_adhesion'];
            $this->newAdhesion['finAdhesion'] = $donnees['empr_date_expiration'];

            if (!in_array($this->newAdhesion['CB'], $adhesion_id))
            {
               Adhesion::create($this->newAdhesion);
            }            
        }               
        
        $this->dispatch("ShowSuccessMsg", ['message' => 'Synchronisation avec success!', 'type' => 'success']);
        $r->closeCursor(); // Termine le traitement de la requête
    }

    public function bsSteepPrevNext($crèment)
    {
        if ($crèment == 'next') {
            if ($this->bsSteepActive == 1) {
                $this->validate();
                $this->defineMontant();
                $this->bsSteepActive += 1;
                return null;
            } elseif ($this->bsSteepActive == 2) {
                if ($this->statue == "" || $this->moyenPaiement == "") {
                    $this->dispatch("showModalSimpleMsg", ['message' => "Veuillez sélectionner le statut et le moyen de paiement", 'type' => 'warning']);
                } else {
                    if ((int) $this->montantPayer < 1) {
                        $this->dispatch("showModalSimpleMsg", ['message' => "Le montant de la paiement doit être supérieur à 20000", 'type' => 'warning']);
                    }
                    $this->submitNewMembre();
                    $this->bsSteepActive += 1;
                }
                return null;
            } elseif ($this->bsSteepActive == 3) {
                return null;
            } else {
                $this->bsSteepActive += 1;
            }
        } else {
            $this->bsSteepActive -= 1;
        }
    }

    public function initData()
    {
        $this->newAdhesion = ['profil' => '', 'categorie_id' => "", 'CB' => null, 'numCarte' => null];
        $this->stapes = "new";
        $this->inscritBible =  false;
    }

    public function initUpdate(Adhesion $adhesion, $stapes)
    {
        $this->newAdhesion = [];
        $this->newAdhesion = $adhesion->toArray();
        $this->stapes = $stapes;
        // dd($this->stapes);
    }

    public function defineStatue($nomStatue)
    {
        $this->statue = $nomStatue;
    }

    public function defineMoyenPai($nomMoyenPai)
    {
        $this->moyenPaiement = $nomMoyenPai;
    }

    public function defineMontant()
    {
        $this->montantPayer = 0;

        if($this->newAdhesion['categorie_id'] == 4)
        {
            $this->montantAdhesion = "+ 20000 ";
        }
        else
        {
            $price = Price::with("categories")->whereHas("categories", function ($qr) { 
                $qr->where("id", "LIKE", $this->newAdhesion['categorie_id']);
            })->first();
            $this->montantAdhesion = $price->montant;
            $this->catPaiement = $price->id;

            $this->montantPayer = $this->montantAdhesion;
            // dd($this->montantAdhesion);
        }
        
    }

    public function montantPayeChange()
    {
        if ($this->newAdhesion['categorie_id'] == 4 && (int) $this->montantPayer < 20000) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Le montant de la paiement doit être supérieur à 20000", 'type' => 'warning']);
            $this->montantPayer = 0;
        }
        else
        {
            $this->montantAdhesion = (int) $this->montantPayer;
        }
    }

    // Nos fonction de validation
    protected function rules()
    {
        $rule = [
            'photo' => ['image', 'max:1024', 'nullable'],
            'newAdhesion.nom' => ['required'],
            'newAdhesion.prenom' => 'required',
            'newAdhesion.sexe' => ['required'],
            'newAdhesion.ville' => ['required'],
            'newAdhesion.pays' => ['required'],
            'newAdhesion.dateNaissance' => ['required'],
            'newAdhesion.profession' => ['required'],
            'newAdhesion.email' => ['email'],
            'newAdhesion.telephone1' => ['min:10', 'max:10', 'nullable'],
            'newAdhesion.telephone2' => ['min:10', 'max:10', 'nullable'],
            'newAdhesion.adresse' => ['required'],
            'newAdhesion.categorie_id' => ['required'],
            'newAdhesion.user_id' => ['integer'],

        ];

        return $rule;
    }

    public function generateCB()
    {
        $this->newAdhesion['CB'] = null;
        $categorie_indication = [
            1 => "JN",
            2 => "PR",
            3 => "PR",
            4 => "ME",
            5 => "ET",
            6 => "CL",
            7 => "AD",
            8 => "VL",
        ];

        $this->newAdhesion['numCarte'] = "AF-" .  $categorie_indication[$this->newAdhesion['categorie_id']] . '.' . random_int(100, 9000);
    }

    public function cancelCB()
    {
        $this->newAdhesion['CB'] = null;
    }

    // Enregistrement un nouveau membre
    public function submitNewMembre()
    {        
        // dd($this->newAdhesion);
        
        $this->newAdhesion['user_id'] = Auth::user()->id;
        
        
        $this->validate([
            "montantPayer" => ['required'],
        ]);

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newAdhesion['profil'] = $photoName;
        }        

        // dd($this->newAdhesion);
        if ($this->stapes == "new")
        {
            $newMember = Adhesion::create($this->newAdhesion);
        }
        elseif($this->stapes == "reInscription")
        {
            $this->newAdhesion['finAdhesion'] = Carbon::today()->addYear();
            Adhesion::find($this->newAdhesion['id'])->update($this->newAdhesion);
            $newMember = Adhesion::find($this->newAdhesion['id']);
        }
        // $montant = $this->sessionSelected->montant;

        if($this->stapes = "new"){
            $inscrOuReinscr = "Inscription pour devenier membre";

        }else{$inscrOuReinscr = "Réinscription au membre de l’alliance française";}
        // if ($this->newAdhesion['categorie_id'] == 4) {
        //     $this->montantAdhesion = (int) $this->montantPaye;
        // }

        // Pour la base donné de paiement
        $paiementData = [
            'montant' => $this->montantAdhesion,
            'montantRestant' => 0,
            'statue' => $this->statue,
            'motif' => "Adhésion au membre de l’alliance française",
            'moyenPaiement' => $this->moyenPaiement,
            'type' => 'Inscription pour devenir membre',
            'numRecue' => "AFPN°" . random_int(50, 9000),
            'user_id' => Auth::user()->id
        ];
        $paiement = Paiement::create($paiementData);
        $this->paiement_id = $paiement->id;

        // Pour la base donné de inscription
        $inscriValue = [
            'adhesion_id' => $newMember->id,
            'statut' => true,
            'type' => "Adhésion membre",
            // 'idCourOrExam' => "0",
        ];

        $inscription = Inscription::create($inscriValue);
        $inscription->paiements()->attach($paiement->id);

        if($this->newAdhesion['CB'] != null)
        {
            $this->newAdhesion = $newMember->toArray();
            $this->insertToPmb();
        }


        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant enregistré avec success!', 'type' => 'success']);
        $this->photo = '';
        $this->initData();
    }

    public function updateAdhesion()
    {
        $this->validate();

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newAdhesion['profil'] = $photoName;
        }

        $myNewAdhesion = Adhesion::find($this->newAdhesion['id']);

        if ($myNewAdhesion['CB'] != null)
        {
            $this->updateToPmb();
        }
        else
        {
            if ($this->newAdhesion['CB'] != null)
            {
                $pmb = $this->connectToDb();
                $req = $pmb->prepare('INSERT INTO empr(empr_cb, empr_nom,empr_prenom, empr_sexe,empr_pays,empr_year,empr_ville,empr_prof,empr_mail,empr_tel1,empr_adr1,empr_categ,empr_creation,empr_modif,empr_date_adhesion,empr_date_expiration,empr_codestat,empr_lang,empr_statut) VALUES(:empr_cb,:empr_nom,:empr_prenom,:empr_sexe,:empr_pays,:empr_year,:empr_ville,:empr_prof,:empr_mail,:empr_tel1,:empr_adr1,:empr_categ,:empr_creation,:empr_modif,:empr_date_adhesion,:empr_date_expiration,:empr_codestat,:empr_lang,:empr_statut)');
        
                $req->execute(array(
                    'empr_cb' => $this->newAdhesion['CB'],
                    'empr_nom' => $this->newAdhesion['nom'],
                    'empr_prenom' => $this->newAdhesion['prenom'],
                    'empr_sexe' => $this->newAdhesion['sexe'] == 'M' ? 1 : 2,
                    'empr_pays' =>  $this->newAdhesion['pays'],
                    'empr_year' => $this->newAdhesion['dateNaissance'],
                    'empr_ville' => $this->newAdhesion['ville'],
                    'empr_prof' => $this->newAdhesion['profession'],
                    'empr_mail' => $this->newAdhesion['email'],
                    'empr_tel1' => $this->newAdhesion['telephone1'],
                    'empr_adr1' => $this->newAdhesion['adresse'],
                    'empr_categ' => $this->newAdhesion['categorie_id'],
                    'empr_creation' => $this->newAdhesion['created_at'],
                    'empr_modif' => $this->newAdhesion['updated_at'],
                    'empr_date_adhesion' => $this->newAdhesion['created_at'],
                    'empr_date_expiration' => $this->newAdhesion['finAdhesion'],
                    'empr_codestat' => 2,
                    'empr_lang' => 'Fr',
                    'empr_statut' => 1,
                    ));    
            }
        }

        Adhesion::find($this->newAdhesion['id'])->update($this->newAdhesion);


        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant modifier avec success!', 'type' => 'success']);
        $this->photo = '';
        
        $this->initData();
    }

    public function defineCB($codeBarre)
    {
        $this->newAdhesion['CB'] = $codeBarre;
    }

    public function render()
    {
        Carbon::setLocale('fr');
        $this->newAdhesion;

        $membres = Adhesion::where("categorie_id", "LIKE", "%{$this->filterByCat}%")
                            ->where(function ($query) {
                                $query->where("nom", "LIKE", "%{$this->search_membre}%")
                                    ->orWhere("prenom", "LIKE", "%{$this->search_membre}%")
                                    ->orWhere("numCarte", "LIKE", "%{$this->search_membre}%");
                            })
                            ->paginate(5);

        $data = [
            'membres' => $membres,
        ];

        return view('livewire.adhesions.index', $data);
    }
}
