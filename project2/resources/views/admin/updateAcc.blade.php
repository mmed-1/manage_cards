<!DOCTYPE html>
<html lang="en">
<x-head title="Modifier le compte">
    <link rel="stylesheet" href="{{ asset('css/update-acc.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-head>
<body>
    <div class="app-container">
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
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-sim-card"></i> 
                            <span>Cartes BLR</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="page-title">
                    <h1>Modifier le compte</h1>
                    <p>Modifier les informations du compte</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <div class="card form-card">
                    <div class="card-header">
                        <h2>Modifier le compte de {{ $compte->prenom }} {{ $compte->nom }}</h2>
                    </div>
                    
                    <div class="card-body">
                        <!-- Status Messages -->
                        <div id="status-container">
                            @if ($errors->any())
                                <div class="status-message error animate-in">
                                    <div class="status-icon">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="status-content">
                                        <h3>Erreur</h3>
                                        <ul class="error-list">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            
                            @if (session('create'))
                                @switch(session('status'))
                                    @case('emailError')
                                        <div class="status-message error animate-in">
                                            <div class="status-icon">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div class="status-content">
                                                <h3>Erreur!</h3>
                                                <p>Un problème d'envoi d'email</p>
                                            </div>
                                        </div>
                                        @break
                                    @case('unique')
                                        <div class="status-message warning animate-in">
                                            <div class="status-icon">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="status-content">
                                                <h3>Attention!</h3>
                                                <p>Cette adresse email existe déjà</p>
                                            </div>
                                        </div>
                                        @break
                                    @default
                                        <div class="status-message error animate-in">
                                            <div class="status-icon">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div class="status-content">
                                                <h3>Erreur!</h3>
                                                <p>Il y a un problème</p>
                                            </div>
                                        </div>
                                @endswitch    
                            @endif
                        </div>

                        <form action="{{ route('compte.edit', ['id' => $compte->user_principale_id ]) }}" method="post" class="form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nom" class="form-label">Nom</label>
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nom" name="nom" required value="{{ $compte->nom }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="prenom" name="prenom" required value="{{ $compte->prenom}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required value="{{ $compte->email}}"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" />
                                        <button type="button" class="password-toggle" data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="form-text">Laissez vide pour conserver le mot de passe actuel</small>
                                </div>

                                <div class="form-group">
                                    <label for="password2" class="form-label">Confirmer mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password2" name="password_confirmation" />
                                        <button type="button" class="password-toggle" data-target="password2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Modifier compte
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar (User Menu) -->
        <aside class="user-sidebar" id="userSidebar">
            <div class="user-sidebar-header">
                <h3>Menu Utilisateur</h3>
                <button class="close-sidebar-btn" id="closeUserSidebarBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="user-profile">
                <div class="profile-image">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-info">
                    <h3>Admin: {{ session('name') }}</h3>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ route('admin.info') }}"><i class="fas fa-user-cog"></i> Paramètres du profil</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </li>
                </ul>
            </div>
        </aside>
        
        <!-- Overlay for mobile and sidebar backdrop -->
        <div class="overlay" id="overlay"></div>
    </div>

    <script src="{{ asset('js/update-acc.js') }}"></script>
</body>
</html>
