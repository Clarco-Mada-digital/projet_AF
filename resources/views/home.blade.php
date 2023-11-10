@extends('layouts.mainLayout')

@section('title', 'Accueil')

@section('titlePage', 'TABLEAU DE BORD')

@section('content')


    <h3 class="mb-5 pt-3">Bienvenue {{ userFullName() }} !</h3>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-graduation-cap"
                        aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Étudiants</span>
                    <span class="info-box-number">1500</span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-info"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nouveaux étudiants</span>
                    <span class="info-box-number">500</span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cours existants</span>
                    <span class="info-box-number">25</span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-info"><i class="fa fa-address-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nouveaux cours</span>
                    <span class="info-box-number">3</span>
                </div>

            </div>

        </div>
    </div>
    <h3 class="mt-5">Vos actions</h3>
    <span>Que souhaiteriez-vous faire ?</span>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-edit" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire de nouveau étudient</span>
                    <span class="info-box-number">Inscrits nouveaux étudiants</span>
                </div>

            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-info"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire de nouveau membre</span>
                    <span class="info-box-number">Inscrit nouvel membre</span>
                </div>

            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Allez au formulaire des nouveaux cours</span>
                    <span class="info-box-number">Inscrit nouveaux cours</span>
                </div>

            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="card ">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Calendar
                    </h3>

                    <div class="card-tools">

                        {{-- <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                data-offset="-52">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a href="#" class="dropdown-item">Add new event</a>
                                <a href="#" class="dropdown-item">Clear events</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">View calendar</a>
                            </div>
                        </div> --}}
                        <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body pt-0">

                    <div id="calendar" style="width: 100%"></div>
                </div>

            </div>
        </div>
        <div class="col-md-6 mt-4">
            <h4>Aides & Astuces</h4>
            <span>Toutes nos ressources pour vous aider dans votre gestion de cours</span>
            <div class="info-box">
                <span class="info-box-icon bg-gradient-info"><i class="fa fa-info" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> Info </span>
                    <span class="info-box-number">Besoins d'aide</span>
                </div>

            </div>
            <div class="info-box">
                <span class="info-box-icon bg-gradient-info"><i class="fa fa-comments" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> Contact </span>
                    <span class="info-box-number">Contactez MADA-Digital</span>
                </div>

            </div>
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
