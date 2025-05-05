<!DOCTYPE html>
<html lang="en">
<x-head title="">
    <link rel="stylesheet" href="">
</x-head>
<body>
    <header>
        <h1>Tout Les equipements</h1>
        <a href="{{route('admin.choice')}}">Retour</a> <!-- maybe here an Icon we will see that -->
    </header>

    <main>
        @if (session('deleted'))
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
        @if (session('submited'))
            @if (session('error'))
                <span style="color: red; margin: 5px;">Il y a un probleme</span>
            @elseif (session('status') === 'success')
                <span style="color: green; margin: 5px;">L'equipement est bien Modifie</span>
            @else
                <span style="color: red; margin: 5px;">Il y a un probleme</span>
            @endif
        @endif
        <table>
            <thead>
                <tr>
                    <th>adresse ip</th>
                    <th>nombre de ports</th>
                    <th>ajoutee par</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipements as $equipement)
                    <tr>
                        <td>{{$equipement->ip_address}}</td>
                        <td>{{$equipement->nombre_port}}</td>
                        @php
                            if($equipement->admin_id == auth()->guard('admin')->id())
                                $name = 'Vous';
                            else
                                $name = $equipement->admin->prenom . ' ' . $equipement->admin->nom;
                        @endphp
                        <td>{{ $name }}</td>
                        <td><a href="{{route('formEqui', ['id' => $equipement->equipement_id])}}">modifier</a></td>
                        <td><a href="">detaille</a></td>
                        <td>
                            <form action="{{ route('deleteEqui', ['id' => $equipement->equipement_id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tu veux supprimer ce equippement')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>