<!DOCTYPE html>
<html lang="en">
<x-head title="">
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Modifier la carte sim</h1>
    </header>  
    <main>
        <form action="{{ route('update', ['id' => $carte->carte_sim_id]) }}" method="post">
            @csrf
            @method('POST')
            <label for="l1">Numero carte sim:</label>
            <input type="text" name="num" id="l1" value="{{$carte->num_carte_sim}}" autofocus /> <br>

            <label for="l2">ICE de la carte:</label>
            <input type="text" name="ice" id="l2" value="{{$carte->ice}}" required /> <br>

            <label for="l3">Operateur:</label>
            <input type="text" name="operateur" id="l3" value="{{$carte->operateur}}" required><br>

            <input type="submit" name="update" value="Modifier la carte" />
            <input type="reset" value="Annuler" />
        </form>
        @if($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{$error}}</li>                        
                    @endforeach
                </ul>
            </div>
        @endif
    </main>  
</body>
</html>