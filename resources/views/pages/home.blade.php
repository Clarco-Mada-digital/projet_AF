@extends('layouts.mainLayout')

@section('title', 'Accueil')

@section('titlePage', 'TABLEAU DE BORD')

@section('content')


    {{-- <h3 class="mb-5 pt-3">Bienvenue {{ Auth::user()->prenom." ".Auth::user()->nom }} !</h3> --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <div class="row">
                <div class="d-flex flex-column col-md-11 col-sm-12">
                    <h4>{{ session()->get('message') }}</h4>                
                    <p style="font-size: .9rem;">Votre page d'accueil est votre alliée; elle vous indique les tâches à accomplir pour gérer vos étudiants.</p>
                </div>
                <img class="my-auto mx-auto rotateAnim" src="{{asset('images/Robot.png')}}" alt="robot image" style="width: 75px; height:75px;">
                

            </div>
        </div>
        {{-- <h3 class="mb-5 pt-3"></h3> --}}
    @endif

    <div class="row mt-2">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-graduation-cap"
                        aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Étudiants</span>
                    <span class="info-box-number">
                        @if ($etudiants != null)
                            {{ count($etudiants) }}
                        @else
                            Aucune donnée trouvée
                        @endif
                    </span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-primary"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nouveaux étudiants</span>
                    <span class="info-box-number">
                        @if ($etudiants != null)
                            {{ count($etudiants) }}
                        @else
                            Aucune donnée trouvée
                        @endif
                    </span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cours existants</span>
                    <span class="info-box-number">
                        @if ($etudiants != null)
                            {{ count($cours) }}
                        @else
                            Aucune donnée trouvée
                        @endif
                    </span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-primary"><i class="fa fa-address-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nouveaux cours</span>
                    <span class="info-box-number">
                        @if ($etudiants != null)
                            {{ count($cours) }}
                        @else
                            Aucune donnée trouvée
                        @endif
                    </span>
                </div>

            </div>
        </div>
    </div>
    
    <h3 class="mt-2">Vos actions</h3>
    <span>Que souhaiteriez-vous faire ?</span>

    <div class="row mt-2">

        <div class="col-md-4 col-sm-6 col-12">
            <a href="{{ route('etudiants-nouveau') }}" class="info-box text-secondary">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-edit" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire de nouvel étudiant </span>
                    <span class="info-box-number">Inscrire un nouvel étudiant</span>
                </div>

            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box text-secondary">
                <span class="info-box-icon bg-gradient-primary"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire de nouveau membre</span>
                    <span class="info-box-number">Inscrire un nouveau membre</span>
                </div>

            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <a href="{{ route('cours-nouveau') }}" class="info-box text-secondary">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire des nouveaux cours</span>
                    <span class="info-box-number">Inscrire un nouveau cours</span>
                </div>

            </a>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card ">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Calendrier
                    </h3>

                    <div class="card-tools">

                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                data-offset="-52">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a href="#" class="dropdown-item">Ajouter un nouvel événement </a>
                                <a href="#" class="dropdown-item">Effacer les événements</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">Voir le calendrier</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body pt-0 pb-0">

                    <div id="calendar" style="width: 100%"></div>
                </div>

            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4>Aides & Astuces</h4>
            <span>Toutes nos ressources pour vous aider dans votre gestion de cours</span>
            <div class="info-box text-secondary">
                <span class="info-box-icon bg-gradient-primary"><i class="fa fa-info" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> Info </span>
                    <span class="info-box-number">Besoin d'aide</span>
                </div>

            </div>
            <a class="info-box text-secondary" href="{{ route('mada-contact') }}">
                <span class="info-box-icon bg-gradient-primary"><i class="fa fa-comments" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> Contact </span>
                    <span class="info-box-number">Contactez MADA-Digital</span>
                </div>
            </a>
        </div>
        
    </div>



    {{-- Initilaisation du calendar JS --}}
    <script>
        const options = {
            settings: {
                lang: 'define',
                visibility: {
                    theme: 'light'
                },
                selection: {
                    time: true,
                    day: 'multiple-ranged',
                }
            },
            locale: {
                months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mais', 'Juin', 'Juellet', 'Août', 'Septembre',
                    'Octobre', 'Novembre', 'Decembre'
                ],
                weekday: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            },
            actions: {
                clickDay(event, dates) {
                    console.log(dates);
                },
                changeTime(event, time, hours, minutes, keeping) {
                    console.log(time);
                },
            },
        };

        document.addEventListener('DOMContentLoaded', () => {
            const calendar = new VanillaCalendar('#calendar', options);
            calendar.init();
        });
    </script>

@endsection
