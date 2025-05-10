<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Liste de carte BLR</h1>
        <a href="{{ route('admin.home')}}">← Retour</a>
    </header>
    <main>
        <form action="{{ route('blr.search2') }}" method="post">
            @csrf
            <input 
                type="text"
                name="search"
                value="{{ request('search')}}"
                placeholder="Entrer un nom de compte ou numero de carte"
            />
            <button type="submit">🔎</button>
        </form>
        @if (session('update'))
            @if (session('status') == 'success')
                <div>
                    <span style="color: green;">
                        Le port est bien modifie
                    </span>
                </div>
            @else
                <div>
                    <span style="color: red;">
                        Il y a un problem
                    </span>
                </div>
            @endif
        @endif
        <table>
            <thead>
                <tr>
                    <th>numero de carte</th>
                    <th>equipement adresse</th>
                    <th>numero de port</th>
                    <th>operateur</th>
                    <th>compte associé</th>
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
                            if($carte->user_principale_id)
                                $compte = $carte->utilisateur_principale->prenom . ' ' . $carte->utilisateur_principale->nom;
                            elseif($carte->user_id)
                                $compte = $carte->utilisateur->utilisateurs_principale->prenom . ' ' . $carte->utilisateur->utilisateurs_principale->nom;
                        @endphp
                        <td>{{ $compte }}</td>
                        <td>
                            <a href="{{ route('blr.fd', ['id' => $carte->carte_blr_id]) }}">modifier</a>
                            <a href="{{ route('blr.det', ['id' => $carte->carte_blr_id]) }}">detaille</a>
                            {{-- <form action="" method="post" style="display: inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('Tu veux supprimer cette carte')">supprimer</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>Aucune carte trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>
</html>