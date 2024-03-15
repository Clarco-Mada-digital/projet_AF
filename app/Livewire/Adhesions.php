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

#[Layout('layouts.mainLayout')]
class Adhesions extends Component
{
    use WithFileUploads;

    public string $search = "";
    public $memberResult = [];
    public $newAdhesion = ['profil' => '', 'categorie_id' => ""];
    public $photo;
    public int $bsSteepActive = 1;
    public $montantAdhesion;
    public $montantPayer;
    public float $montantExam = 0;
    public float $montantPaye = 0;
    public float $montantRestant;

    public $categories;
    public $moyenPaiement;
    public $statue;
    public $paiement_id;
    

    function __construct() 
    {
        $this->categories = Categorie::all();
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
                        $this->dispatch("showModalSimpleMsg", ['message' => "Le montant de la paiement doit être supérieur à 10000", 'type' => 'warning']);
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
        if($this->newAdhesion['categorie_id'] != 4)
        {
            $this->montantAdhesion = Price::where('id', $this->newAdhesion['categorie_id'])->first()->montant;
            $this->montantPayer = $this->montantAdhesion;
        }
        elseif($this->newAdhesion['categorie_id'] == 4)
        {
            $this->montantAdhesion = "+ 10000 ";
        }
        
    }

    public function montantPayeChange()
    {
        if ($this->newAdhesion['categorie_id'] == 4 && (int) $this->montantPayer < 10000) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Le montant de la paiement doit être supérieur à 10000", 'type' => 'warning']);
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
            'newAdhesion.nationalite' => ['required'],
            'newAdhesion.dateNaissance' => ['required'],
            'newAdhesion.profession' => ['nullable'],
            'newAdhesion.email' => ['email'],
            'newAdhesion.telephone1' => ['min:10', 'max:10', 'nullable'],
            'newAdhesion.telephone2' => ['min:10', 'max:10', 'nullable'],
            'newAdhesion.adresse' => ['required'],
            'newAdhesion.categorie_id' => ['required'],
            'newAdhesion.user_id' => ['integer'],

        ];

        return $rule;
    }

    // Enregistrement un nouveau membre
    public function submitNewMembre()
    {
        $categorie_indication = [
            1 => "AD",
            2 => "ET",
            3 => "ENF",
            4 => "ME",
        ];
        
        $this->newAdhesion['user_id'] = Auth::user()->id;
        $this->newAdhesion['numCarte'] = "AF-" .  $categorie_indication[$this->newAdhesion['categorie_id']] . '.' . random_int(100, 9000);
        
        $this->validate();

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newAdhesion['profil'] = $photoName;
        }        

        // dd($this->newAdhesion);
        $newMember = Adhesion::create($this->newAdhesion);
        // $montant = $this->sessionSelected->montant;

        
        $inscrOuReinscr = "Inscription";
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
            'type' => "Inscription pour devenir membre",
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


        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant enregistrer avec success!', 'type' => 'success']);
        $this->photo = '';
        $this->newAdhesion = ['profil' => '', 'categorie_id' => ""];
    }

    public function render()
    {
        return view('livewire.adhesions.index');
    }
}
