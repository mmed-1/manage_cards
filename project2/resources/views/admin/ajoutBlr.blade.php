<!DOCTYPE html>
<html lang="en">
<x-head title="Ajout d'une carte BLR">
    <link rel="stylesheet" href="{{ asset('css/ajout-blr.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-head>
<body>
    <div class="dashboard-container">
        <!-- Left Sidebar -->
        <aside class="sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-icon">A</span>
                    <span class="logo-text">AdminPanel</span>
                </div>
                <button class="close-sidebar-btn" id="closeSidebarBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-user"></i> 
                            <span>Gestion de Compte</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.addAcc') }}"><i class="fas fa-plus-circle"></i>Ajout de Compte</a></li>
                            <li><a href="{{ route('compte.details') }}"><i class="fas fa-list"></i>Consulter les Comptes</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-server"></i> 
                            <span>Gestion des Equipements</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('ajout') }}"><i class="fas fa-plus-circle"></i> Ajout Equipement</a></li>
                            <li><a href="{{ route('consultation') }}"><i class="fas fa-list"></i> Consulter Equipement</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu active">
                        <div class="submenu-toggle">
                            <i class="fas fa-sim-card"></i> 
                            <span>Cartes BLR</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li class="active"><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <button id="sidebarToggleBtn" class="sidebar-toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">
                    <h1>Ajout d'une carte BLR</h1>
                </div>
                <div class="user-info">
                    <span>Admin</span>
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </div>

            <div class="content-container">
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a> / 
                    <a href="{{ route('details.blr') }}">Cartes BLR</a> / 
                    <span>Ajout</span>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Informations de la carte</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin-blr.ajout') }}" method="post" class="form-container">
                            @csrf
                            
                            <div class="form-group">
                                <label for="l0">ICE</label>
                                <input type="text" name="ice" id="l0" required autofocus class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="l1">Numéro de la carte:</label>
                                <input type="text" name="num_carte" id="l1" required class="form-control"/>
                            </div>
                    
                            <div class="form-group">
                                <label for="l4">Opérateur:</label>
                                <select name="operateur" id="l4" class="form-control">
                                    <option value="" selected disabled>Choisir un opérateur</option>
                                    <option value="Maroc Telecom">Maroc Telecom</option>
                                    <option value="Orange">Orange</option>
                                    <option value="Inwi">Inwi</option>
                                    <option value="M2M">M2M</option>
                                    <option value="Autres">Autres</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="l87">Compte:</label>
                                <select name="liee_par" id="l87" class="form-control">
                                    <option value="" selected disabled>Choisir Compte</option>
                                    @foreach ($comptes as $compte)
                                        <option value="{{$compte->user_principale_id}}">{{ $compte->prenom }} {{ $compte->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="l3">Équipement:</label>
                                <select name="equipement_id" id="l3" class="form-control">
                                    <option value="" selected disabled>Choisir un équipement</option>
                                    @foreach ($equipements as $equipement)
                                        <option value="{{ $equipement->equipement_id }}">{{ $equipement->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="l2">Numéro de port:</label>
                                <input type="text" name="num_port" id="l2" required class="form-control"/>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajouter la carte
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Annuler
                                </button>
                            </div>
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if (session('create'))
                            <div class="alert {{ session('status') === 'success' ? 'alert-success' : 'alert-danger' }}">
                                <i class="fas {{ session('status') === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                                @if (session('status') === 'success')
                                    La carte est bien ajoutée
                                @elseif (session('status') === 'error')
                                    La carte est déjà enregistrée dans notre système
                                @else
                                    Il y a un problème
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/ajout-blr.js') }}"></script>
</body>
</html>