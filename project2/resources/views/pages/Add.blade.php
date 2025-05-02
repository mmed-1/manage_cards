<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Ajouter une carte sim</h1>
        <div>
            <img src="" alt="">
            <a href="{{route('choice')}}">Back</a>
        </div>
    </header>
    
    <main>
        <form action="/gestion/add-card" method="post">
            @csrf
            <label for="l1">Numero carte sim:</label>
            <input type="text" name="num_carte_sim" id="l1" required autofocus /> <br>

            <label for="l2">ICE de la carte:</label>
            <input type="text" name="ice" id="l2" required /> <br>

            <label for="l3">Operateur:</label>
            <input type="text" name="operateur" id="l3" required><br>

            <label for="l4">Solde</label>
            <input type="text" name="solde" value="1" required id="l4" /> <br>

            <label for="l5">Email de client:</label>
            <input type="email" name="client_email" id="l5" required /> <br>

            <label for="l6">Matricule de voiture</label>
            <input type="text" name="matricule" id="l6" required /> <br>

            <input type="submit" value="Ajouter carte" />
            <input type="reset" value="Annuler" />
        </form>
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('create'))
        <div>
            @if (session('status') === 'success')
                <span style="color: green;">
                    La carte est bien enregistrée {{-- Fixed feminine agreement --}}
                </span>
            @elseif(session('status') === 'error')
                <span style="color: red;">
                    Aucun client correspondant n'a été trouvé dans notre système. Merci de vérifier les données fournies.
                </span>
            @elseif(session('status') === 'error2')
                <span style="color: red;">
                    Aucun véhicule correspondant n'a été trouvé dans notre système. Veuillez vérifier les informations saisies.
                </span>     
            @elseif (session('error'))
                <span style="color: red;">
                    Les informations de cette carte sont deja enregistre {{-- Fixed feminine agreement --}}
                </span>
            @else
                <span style="color: red;">
                    La carte n'est pas bien enregistrée {{-- Fixed feminine agreement --}}
                </span>
             @endif
        </div>
        @endif
    </main>
</body>
</html>