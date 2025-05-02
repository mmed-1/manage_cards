<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Annuaire des comptes</h1>
        <a href="{{ route('admin.choice2') }}">← Retour</a>
    </header>

    <form action="{{ route('search.acc') }}" method="post">
        @csrf
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Rechercher un client par son nom ou son email"
        />
        <button type="submit">🔍</button>
    </form>

    @if (session('delete'))
        @if (session('status') === 'success')
            <div>
                <span style="color: green;">
                    Le compte est bien supprime
                </span>
            </div>
        @else
            <div>
                <span style="color: red;">
                    Il y a un probleme
                </span>
            </div>
        @endif
    @endif

    @if (session('create'))
            @switch(session('status'))
                @case('success0')
                    <div>
                        <span style="color: green;">
                            Le compte est bien modifie. <br> un email est envoye! 
                        </span>
                    </div>
                    @break
                @case('success1')
                    <div>
                        <span style="color: green;">
                            Le compte est bien modifie.
                        </span>
                    </div>
                    @break
            @endswitch
        @endif
    <table>
        <thead>
            <tr>
                <th>Nom de client</th>
                <th>Email</th>
                <th>Creer par</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comptes as $compte)
                <tr>
                    <td>{{ $compte->prenom . ' ' . $compte->nom }}</td>
                    <td>{{ $compte->email }}</td>
                    <td>{{ $compte->admin->prenom . ' ' . $compte->admin->nom}}</td>
                    <td>
                        <a href="{{ route('show.update', ['id' => $compte->user_principale_id]) }}">✏️</a>
                        <form action="{{ route('compte.delete', ['id' => $compte->user_principale_id]) }}" method="post"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tu veux supprimer ce compte')">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: gray;">
                        Aucun compte ne correspond à votre recherche.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>