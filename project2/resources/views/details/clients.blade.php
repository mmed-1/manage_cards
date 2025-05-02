<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>

<body>
    <header>
        <h1>La liste des clients</h1>
        <a href="{{ route('choice') }}">Retour</a>
    </header>
    <main>
        @if (session('delete'))
            @if (session('status') === 'success')
                <span style="color: green;">
                    Le client est bien supprime
                </span>
            @else
                <span style="color: red;">
                    Il y a un probleme
                </span>
            @endif
        @endif
        @if (session('up'))
            @if (session('status') === 'success')
                <span style="color: green;">
                    Le client est bien modifie
                </span>
            @endif
        @endif
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>prenom</th>
                    <th>Email</th>
                    <th>Cree par</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->email }}</td>
                        @php
                            if($client->utilisateur && $client->utilisateur->nom && $client->utilisateur->prenom)
                                $name = $client->utilisateur->prenom . ' ' . $client->utilisateur->nom;
                            elseif($client->utilisateur_principale && $client->utilisateur_principale->nom && $client->utilisateur_principale->prenom)
                                $name = $client->utilisateur_principale->prenom . ' ' . $client->utilisateur_principale->nom;
                            else
                                $name = '';
                        @endphp
                        <td>{{ $name }}</td>
                        <td>
                            <a href="{{ route('client.modification', ['id' => $client->client_id]) }}">✏️</a>
                            <a href="{{ route('client.detaille', ['id' => $client->client_id]) }}">Detaille</a>
                            <form action="{{ route('client.delete', ['id' => $client->client_id]) }}" method="post"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tu veux supprimer ce client?')">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
