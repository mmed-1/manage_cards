<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>

<body>
    <header>
        <h1>La liste des clients</h1>
        <a href="{{ route('choice2') }}">← Retour</a>
    </header>
    <main>
        <form action="{{ route('clients.search') }}" method="post">
            @csrf
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Entrer le nom complet de client ou son email"
            />
            <button type="submit">🔎</button>
        </form>
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
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->email }}</td>
                        @php
                            if($client->user_id) {
                                if($client->user_id == auth()->guard('user')->id())
                                    $name = 'Vous';
                                else
                                    $name = $client->utilisateur->prenom . ' ' . $client->utilisateur->nom;
                            } elseif($client->user_principale_id) {
                                if($client->user_principale_id == auth()->guard('user_principale')->id())
                                    $name = 'Vous';
                                else 
                                    $name = $client->utilisateur_principale->prenom . ' ' . $client->utilisateur_principale->nom;
                            } else $name = ' ';
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
                @empty
                    <tr>
                        <td>Aucun client trouve</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>

</html>
