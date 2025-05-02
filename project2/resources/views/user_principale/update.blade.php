<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Modifier le compte de l'utilisateur {{ $user->prenom . ' ' . $user->nom }}</h1>
    </header>

    <main>
        <form action="{{ route('update.user0', ['id' => $user->user_id]) }}" method="post">
            @csrf
            <div>
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required value="{{ $user->nom }}">
            </div>

            <div>
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required value="{{ $user->prenom }}"/>
            </div>

            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}"/>
            </div>

            <div>
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>

            <div>
                <label for="password2" class="form-label">Confirmer mot de passe</label>
                <input type="password" class="form-control" id="password2" name="password_confirmation" required />
            </div>

            <input type="submit" value="Modifier l'utilisateur" />
        </form>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if (session('create'))
            @switch(session('status'))
                @case('emailError')
                    <div>
                        <span style="color: red;">
                            un probleme d'envoie d'email 
                        </span>
                    </div>
                    @break
                @case('unique')
                    <div>
                        <span style="color: red;">
                            Cette addresse email existe deja
                        </span>
                    </div>
                    @break
                @default
                    <div>
                        <span style="color: red;">
                            Il y a un probleme
                        </span>
                    </div>
            @endswitch
        @endif
    </main>
</body>
</html>