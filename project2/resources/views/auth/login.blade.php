<!DOCTYPE html>
<html lang="en">
<x-head title="Connexion">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</x-head>
<body>
    <!-- Error Container -->
    <div class="error-container" id="errorContainer">
        <div class="error-wrapper">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="error-message">
                        <div class="error-content">
                            <div class="error-icon">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div class="error-text">
                                <span>Erreur</span>
                                {{ $error }}
                            </div>
                            <button class="error-close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif

            @if (session('login') && session('status') === 'failed')
                <div class="error-message">
                    <div class="error-content">
                        <div class="error-icon">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="error-text">
                            <span>Échec de connexion</span>
                            L'email ou le mot de passe est incorrect
                        </div>
                        <button class="error-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Success messages container -->
    <div class="alert-container">
        @if (session('login') && session('status') !== 'failed')
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <span>Connexion réussie</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
    </div>

    <main id="loginForm">
        <h1>Connexion</h1>
        <form action="{{ route('login') }}" method="post" id="loginFormElement">
            @csrf
            <div class="input-group {{ $errors->has('email') ? 'error' : '' }}">
                <label for="l1">Email</label>
                <input type="email" name="email" id="l1" required autofocus placeholder="example@domain.com">
            </div>

            <div class="input-group {{ $errors->has('password') ? 'error' : '' }}">
                <label for="l2">Mot de passe</label>
                <input type="password" name="password" id="l2" required placeholder="••••••••">
            </div>

            <input type="submit" name="entrer" value="Se connecter">
        </form>
        <a href="{{ route('password.reset') }}">Mot de passe oublié?</a>
    </main>

    <script>
        // Pass Laravel variables to JavaScript
        window.appData = {
            hasErrors: {{ $errors->any() || (session('login') && session('status') === 'failed') ? 'true' : 'false' }},
            hasEmailError: {{ $errors->has('email') ? 'true' : 'false' }},
            hasPasswordError: {{ $errors->has('password') ? 'true' : 'false' }}
        };
    </script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>