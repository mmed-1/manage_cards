<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Annuaire des utilisateurs du système</h1>
        <a href="{{ route('compte.choice') }}">← Retour</a>
    </header>

    <form action="{{ route('users.search') }}" method="post">
        @csrf
        <input 
            type="text"
            name="search"
            placeholder="Veuillez saisir le nom complet ou l'adresse e-mail de l'utilisateur"
            value="{{ request('search') }}"
        />
        <button type="submit">🔍</button>
    </form>

    @if (session('delete'))
        @if (session('status') === 'success')
            <div>
                <span style="color: green;">
                    L'utilisateur est bien supprime
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
                <th>nom complet</th>
                <th>email</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->prenom . ' ' . $user->nom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('update.user1', ['id' => $user->user_id]) }}">modifier</a>
                        <a href="{{ route('user.det' , ['id' => $user->user_id]) }}">detaille</a>
                        <form action="{{ route('user.delete', ['id' => $user->user_id]) }}" method="post"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tu veux supprimer ce compte')">
                                supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: gray;">
                        Aucun utilisateur ne correspond à votre recherche.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>