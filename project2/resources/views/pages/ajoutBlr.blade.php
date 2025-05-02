<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="">
</x-head>
<body>
    <header>
        <h1>Ajout d'une carte BLR</h1>
        <a href="{{ route('choice') }}">Retour</a>
    </header>

    <main>
        <form action="{{ route('blr.add') }}" method="post">
            @csrf
            <div>
                <label for="l1">Numero de la carte:</label>
                <input type="text" name="num_carte" id="l1" required autofocus />
            </div>
    
            <div>
                <label for="l3">Equipement adresse:</label>
                <select  name="equipement_id" id="l3">
                    <option value="" selected disabled>choisir un equipement</option>
                    @foreach ($equipements as $equipement)
                        <option value="{{ $equipement->equipement_id }}">{{ $equipement->ip_address }}</option>
                    @endforeach
                </select>
            </div>
    
            <div>
                <label for="l2">Numero de port:</label>
                <input type="text" name="num_port" id="l2" required />
            </div>
    
            <div>
                <label for="l4">Operateur:</label>
                <input type="text" name="operateur" id="l4" required />
            </div>
    
            <input type="submit" value="Ajouter la carte" />
            <button type="submit" name="reset" value="annuler">Annuler</button>
        </form>
        @if (session('create'))
            @if (session('status') === 'success')
                <span style="color: green; padding: 10px;">
                    La carte est bien ajoute
                </span>
            @elseif (session('status') === 'error')
                <span style="color: red; padding: 10px;">
                    La carte est deja enregistre dans notre systeme
                </span>
            @else
                <span style="color: red; padding: 10px;">
                    Il y a un probleme
                </span>
            @endif
        @endif
    </main>
</body>
</html>