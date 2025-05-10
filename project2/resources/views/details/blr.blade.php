<!DOCTYPE html>
<html lang="en">
<x-head title="Liste des cartes BLR">
    <link rel="stylesheet" href="{{ asset('css/blr-det.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
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
                            <li><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li class="active"><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggleBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-title">
                        <h1>Annuaire des cartes BLR</h1>
                    </div>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
            
            <div class="content-container">
                <div class="page-subtitle">
                    Gérer les cartes BLR
                </div>

                <div class="card">
                    <div class="search-container">
                        <form action="{{ route('blr.search') }}" method="post" class="search-form">
                            @csrf
                            <div class="search-input-group">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="search-input"
                                    value="{{ request('search') }}" 
                                    placeholder="Rechercher une carte par numéro"
                                />
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('delete'))
                        @if (session('status') == 'success')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <span>La carte est supprime</span>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Il y a un probleme</span>
                            </div>
                        @endif
                    @endif

                    @if(session('update'))
                        @if(session('status') === 'success')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <span>La carte est bien modifie</span>
                            </div>
                        @endif
                    @endif

                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Numéro de carte</th>
                                    <th>Equipement</th>
                                    <th>Port</th>
                                    <th>Opérateur</th>
                                    <th>Ajouté par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cartes as $carte)
                                    <tr>
                                        <td>{{ $carte->num_carte }}</td>
                                        <td>{{ $carte->equipement->name ?? '---' }}</td>
                                        <td>{{ $carte->num_port }}</td>
                                        <td>{{ $carte->operateur }}</td>
                                        @php
                                            if(auth()->guard('admin')->id() == $carte->ajoutee_par)
                                                $name = 'Vous';
                                            elseif(auth()->guard('admin')->id() != $carte->ajoutee_par)
                                                $name = $carte->admin->prenom . ' ' . $carte->admin->nom;
                                            else
                                                $name = '---';
                                        @endphp
                                        <td>{{ $name }}</td>
                                        <td class="actions-cell">
                                            <a href="{{ route('blr.found', ['id' => $carte->carte_blr_id]) }}" class="action-btn edit-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('gest.det', ['id' => $carte->carte_blr_id]) }}" class="action-btn view-btn" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('blr.delete', ['id' => $carte->carte_blr_id]) }}" method="post" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn" data-confirm="Tu veux supprimer cette carte?" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-search"></i>
                                                <p>Aucune carte trouvée</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/blr-det.js') }}"></script>
</body>
</html>
