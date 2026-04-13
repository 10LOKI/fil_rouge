<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ActTogether')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-green-600">ActTogether</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('events.index') }}" class="hover:text-green-600">Événements</a>
                <a href="{{ route('rewards.index') }}" class="hover:text-green-600">Récompenses</a>
                @auth
                    @if(Auth::user()->hasRole('student'))
                        <a href="{{ route('student.dashboard') }}" class="hover:text-green-600">Mon Dashboard</a>
                    @elseif(Auth::user()->hasRole('partner'))
                        <a href="{{ route('partner.dashboard') }}" class="hover:text-green-600">Espace Partenaire</a>
                    @elseif(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="hover:text-green-600">Mon Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-500 hover:underline">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-green-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">S'inscrire</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t text-center text-sm text-gray-400 py-4">
        © {{ date('Y') }} ActTogether — Ensemble pour un monde meilleur.
    </footer>

</body>
</html>
