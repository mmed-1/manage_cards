<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Liste des véhicules</h1>
        <a href="{{ route('choice.vehicule') }}">← Retour</a>
    </header>


    <form action="{{ route('vehicules.search') }}" method="post">
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
                    La vehicule est bien supprime
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
        @if (session('status') === 'success')
            <div>
                <span style="color: green;">
                    La vehicule est bien modifie
                </span>
            </div>
        @endif
    @endif
    
    <main>
        <table>
            <thead>
                <tr>
                    <th>Marque</th>
                    <th>Matriculation</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicules as $vehicule)
                    <tr>
                        <td>{{ $vehicule->marque }}</td>
                        <td>{{ $vehicule->matriculation }}</td>
                        <td>{{ $vehicule->type }}</td>

                        <td>
                            <a href="{{ route('vehicule.form2' , ['id' => $vehicule->vehicule_id]) }}">✏️</a>
                            <a href="">detaille</a>
                            <form action="{{ route('vehicule.delete', ['id' => $vehicule->vehicule_id]) }}" method="post"
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
                        <td>
                            Aucune véhicule ne correspond à votre recherche.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>
</html>