<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Connexion - Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- Login Container -->
    <div class="login-container">
        
        <!-- Logo and Title -->
        <div class="login-header">
            <div class="login-logo">
                <x-application-logo />
            </div>
            <h1 class="login-title">Equipment Tracker</h1>
            <p class="login-subtitle">Connectez-vous pour gérer vos équipements</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="message message-success mb-6">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       required autofocus autocomplete="username"
                       class="form-input" placeholder="votre@email.com">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" name="password" 
                       required autocomplete="current-password"
                       class="form-input" placeholder="••••••••">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-checkbox">
                <input id="remember_me" type="checkbox" name="remember" class="checkbox">
                <label for="remember_me" class="checkbox-label">Se souvenir de moi</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="primary-button w-full mb-4">
                SE CONNECTER
            </button>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="forgot-password-link">
                        Mot de passe oublié ?
                    </a>
                </div>
            @endif
        </form>

        <!-- Test Credentials -->
        <div class="test-credentials">
            <h3 class="test-credentials-title">Comptes de test:</h3>
            <div class="test-credentials-list">
                <div><strong>Admin:</strong> admin@example.com / password</div>
                <div><strong>Utilisateur:</strong> pierre@example.com / password</div>
            </div>
        </div>

    </div>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
