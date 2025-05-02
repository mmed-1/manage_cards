<!DOCTYPE html>
<html lang="en">
<x-head title="Connexion">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #F3F4F6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        main {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        h1 {
            text-align: center;
            color: #1E3A8A;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-weight: 600;
            color: #1E3A8A;
            font-size: 0.9rem;
        }

        input {
            padding: 0.8rem;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #1E3A8A;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        input[type="submit"] {
            background: #1E3A8A;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #1A3172;
        }

        /* Error messages styling */
        .alert-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            animation: slideIn 0.3s ease;
            min-width: 300px;
            border-left: 4px solid;
        }

        .alert.error {
            border-color: #DC2626;
            color: #DC2626;
        }

        .alert.success {
            border-color: #16A34A;
            color: #16A34A;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .close-btn {
            margin-left: auto;
            cursor: pointer;
            background: none;
            border: none;
            color: inherit;
            padding: 0 0.5rem;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        @media (max-width: 480px) {
            main {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .alert-container {
                width: calc(100% - 2rem);
                left: 1rem;
                right: auto;
            }
            
            .alert {
                min-width: auto;
                width: 100%;
            }
        }
        .password-reset-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .password-reset-link a {
            color: #1E3A8A;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .password-reset-link a:hover {
            color: #1A3172;
            text-decoration: underline;
        }

        /* Loading spinner for form submission */
        .submit-loader {
            display: none;
            width: 1.5rem;
            height: 1.5rem;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #1E3A8A;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</x-head>
<body>
    <div class="alert-container">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $error }}</span>
                    <button class="close-btn">&times;</button>
                </div>
            @endforeach
        @endif

        @if (session('login'))
            <div class="alert {{ session('status') === 'failed' ? 'error' : 'success' }}">
                <i class="fas {{ session('status') === 'failed' ? 'fa-exclamation-triangle' : 'fa-check-circle' }}"></i>
                <span>
                    @if (session('status') === 'failed')
                        L'email ou le mot de passe est incorrect
                    @endif
                </span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
    </div>

    <main>
        <h1>Connexion</h1>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group">
                <label for="l1">Email</label>
                <input type="email" name="email" id="l1" required autofocus placeholder="exemple@domain.com">
            </div>

            <div class="input-group">
                <label for="l2">Mot de passe</label>
                <input type="password" name="password" id="l2" required placeholder="••••••••">
            </div>

            <input type="submit" name="entrer" value="Se connecter">
        </form>
        <a href="{{ route('password.reset') }}">Réinitialiser le mot de passe</a>
    </main>

    <script>
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.alert').remove();
            });
        });

        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.remove();
            });
        }, 5000);
    </script>
</body>
</html>