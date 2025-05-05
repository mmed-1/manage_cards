<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Liste des cartes BLR</h1>
        <a href="{{ route('choice')}}">← Retour</a>
    </header>

    <main>
        <form action="{{ route('blr.search') }}" method="post">
            @csrf
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Entrer numero de carte"
            />
            <button>🔎</button>
        </form>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if (session('delete'))
            @if (session('status') == 'success')
                <div>
                    <span style="color: green; padding: 10px;">
                        La carte est supprime
                    </span>
                </div>
            @else
                <div>
                    <span style="color: red; padding: 10px;">
                        Il y a un probleme
                    </span>
                </div>
            @endif
        @endif

        @if(session('update'))
            @if(session('status') === 'success')
                <div>
                    <span style="color: green; padding: 10px;">
                        La carte est bien modifie
                    </span>
                </div>
            @endif
        @endif
        <table>
            <thead>
                <tr>
                    <th>numero de carte</th>
                    <th>adresse d'equipement associes</th>
                    <th>numero de port</th>
                    <th>operateur</th>
                    <th>ajoutee par</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cartes as $carte)
                    <tr>
                        <td>{{ $carte->num_carte }}</td>
                        <td>{{ $carte->equipement->ip_address }}</td>
                        <td>{{ $carte->num_port }}</td>
                        <td>{{ $carte->operateur }}</td>
                        @php
                            if($carte->user_id) {
                                if($carte->user_id == auth()->guard('user')->id())
                                    $name = 'Vous';
                                else
                                    $name = $carte->utilisateur->prenom . ' ' . $carte->utilisateur->nom;
                            } elseif($carte->user_principale_id) {
                                if($carte->user_principale_id == auth()->guard('user_principale')->id())
                                    $name = 'Vous';
                                else
                                    $name = $carte->utilisateur_principale->prenom . ' ' . $carte->utilisateur_principale->nom;
                            } else $name = ' ';
                        @endphp
                        <td>{{ $name }}</td>
                        <td>
                            <a href="{{ route('blr.found', ['id' => $carte->carte_blr_id]) }}">Modifier</a>
                            <a href="">detaille</a>
                            <form action="{{ route('blr.delete', ['id' => $carte->carte_blr_id]) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tu veux supprimer cette carte?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 10px;">
                            Aucune carte trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>
</html>