<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Consulter les cartes</h1>
        <a href="{{route('choice')}}">Retour</a>
    </header>
    <main>
        <form action="{{ route('details.search') }}" method="post">
            @csrf
            <input type="text" 
                name="search" 
                placeholder="Entrer ICE ou bien numero de votre carte" 
                value="{{ request('search') }}"
            />
            <button type="submit">Rechercher</button>
        </form>
        @if($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if (session('delete'))
            @if (session('status') === 'success')
                <span style="color: green; margin: 5px;">
                    La carte est bien supprimee {{-- Fixed feminine agreement --}}
                </span>
            @else
                <span style="color: red; margin: 5px;">
                    Erreur de suppression {{-- Fixed feminine agreement --}}
                </span>
            @endif
        @endif
        @if (session('submitted'))
            @if (session('status') === 'success')
                <span style="color: green;">
                    La carte est bien modifiee {{-- Fixed feminine agreement --}}
                </span>
            @else
                <span style="color: red;">
                    Erreur de modification {{-- Fixed feminine agreement --}}
                </span>
            @endif
        @endif
        @if ($cartes->isEmpty())
            <div>
                <div>
                    <p>Aucune carte SIM n'a été trouvée avec ce numéro de carte ou ce code ICE.</p>
                </div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Numero de carte sim</th>
                        <th>Ice de carte</th>
                        <th>Operateur</th>
                        <th>Solde</th>
                        <th>Ajouter par</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartes as $carte)
                        <tr>
                            <td>{{$carte->num_carte_sim}}</td>
                            <td>{{$carte->ice}}</td>
                            <td>{{$carte->operateur}}</td>
                            <td>{{$carte->solde}}Go</td>
                            @php
                            if ($carte->utilisateur && $carte->utilisateur->nom && $carte->utilisateur->prenom) {
                                // If utilisateur exists and has nom and prenom
                                $name = $carte->utilisateur->nom . ' ' . $carte->utilisateur->prenom;
                            } elseif ($carte->user_principale && $carte->user_principale->nom && $carte->user_principale->prenom) {
                                // If user_principale exists and has nom and prenom
                                $name = $carte->user_principale->nom . ' ' . $carte->user_principale->prenom;
                            } else {
                                // Default case if both are null or missing
                                $name = 'N/A';
                            }
                            @endphp
                        
                            <td>{{ $name }}</td>
                            <td>
                                <a href="{{route('edit', ['id' => $carte->carte_sim_id])}}">✏️</a>

                                <form action="{{ route('delete', ['id' => $carte->carte_sim_id]) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this carte?')">
                                        🗑️
                                    </button>
                                </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>
    <x-footer></x-footer>
</body>
</html>
