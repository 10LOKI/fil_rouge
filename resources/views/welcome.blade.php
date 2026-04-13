<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ActTogether — Ensemble pour un monde meilleur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-gray-800">

    {{-- NAV --}}
    <nav class="fixed top-0 w-full bg-white/90 backdrop-blur shadow-sm z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-green-600">ActTogether</a>
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="#causes" class="hover:text-green-600">Causes</a>
                <a href="#events" class="hover:text-green-600">Événements</a>
                <a href="#partners" class="hover:text-green-600">Partenaires</a>
                @auth
                    @if(Auth::user()->hasRole('student'))
                        <a href="{{ route('student.dashboard') }}" class="hover:text-green-600">Mon Dashboard</a>
                    @elseif(Auth::user()->hasRole('partner'))
                        <a href="{{ route('partner.dashboard') }}" class="hover:text-green-600">Espace Partenaire</a>
                    @elseif(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-red-500 hover:underline">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-green-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="min-h-screen bg-gradient-to-br from-green-600 to-emerald-800 flex items-center pt-16">
        <div class="max-w-6xl mx-auto px-4 py-24 grid md:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full mb-4 inline-block">
                    🌱 Plateforme de bénévolat étudiant
                </span>
                <h1 class="text-5xl font-extrabold leading-tight mb-6">
                    Agis.<br>Engage-toi.<br>
                    <span class="text-yellow-300">Récompense-toi.</span>
                </h1>
                <p class="text-green-100 text-lg mb-8">
                    Rejoins des missions de bénévolat, cumule des points et échange-les contre des récompenses offertes par nos entreprises partenaires.
                </p>
                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('register') }}"
                        class="bg-yellow-400 text-gray-900 font-bold px-6 py-3 rounded-full hover:bg-yellow-300 transition">
                        Rejoindre maintenant
                    </a>
                    <a href="#events"
                        class="border border-white text-white px-6 py-3 rounded-full hover:bg-white/10 transition">
                        Voir les événements
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 gap-4">
                @foreach([
                    ['icon' => '🎓', 'value' => $stats['students'],       'label' => 'Étudiants inscrits'],
                    ['icon' => '🤝', 'value' => $stats['participations'], 'label' => 'Participations'],
                    ['icon' => '🏢', 'value' => $stats['partners'],       'label' => 'Entreprises partenaires'],
                ] as $s)
                    <div class="bg-white/10 backdrop-blur rounded-2xl p-6 flex items-center gap-4 text-white">
                        <span class="text-4xl">{{ $s['icon'] }}</span>
                        <div>
                            <p class="text-3xl font-bold">{{ $s['value'] }}</p>
                            <p class="text-green-200 text-sm">{{ $s['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CAUSES --}}
    <section id="causes" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2">Nos causes</h2>
            <p class="text-center text-gray-500 mb-12">Choisis la cause qui te tient à cœur</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['emoji' => '🏠', 'title' => 'Social',    'desc' => 'Orphelinats, maisons de retraite, aide aux personnes vulnérables.',    'color' => 'blue'],
                    ['emoji' => '🌿', 'title' => 'Écologie',  'desc' => 'Nettoyage de plages, reforestation, sensibilisation environnementale.', 'color' => 'green'],
                    ['emoji' => '🐾', 'title' => 'Animaux',   'desc' => 'Refuges animaliers, adoption, protection de la faune sauvage.',         'color' => 'orange'],
                ] as $cause)
                    <div class="bg-white rounded-2xl shadow p-8 text-center hover:shadow-lg transition">
                        <div class="text-5xl mb-4">{{ $cause['emoji'] }}</div>
                        <h3 class="text-xl font-bold mb-2">{{ $cause['title'] }}</h3>
                        <p class="text-gray-500 text-sm">{{ $cause['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section id="events" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2">Événements à venir</h2>
            <p class="text-center text-gray-500 mb-12">Des missions près de chez toi</p>

            @if($events->isEmpty())
                <p class="text-center text-gray-400">Aucun événement disponible pour le moment.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="border rounded-2xl p-6 hover:shadow-md transition flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                    {{ $event->category }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $event->date_event->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="font-semibold text-lg">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-400">Par {{ $event->partner->company_name }}</p>
                            <div class="flex items-center justify-between mt-auto pt-2">
                                <span class="text-green-600 font-bold">+{{ $event->points_worth }} pts</span>
                                <a href="{{ route('events.show', $event) }}"
                                    class="text-sm text-green-600 hover:underline font-medium">
                                    Voir →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('events.index') }}"
                        class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition">
                        Voir tous les événements
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-20 bg-green-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Comment ça marche ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                @foreach([
                    ['step' => '1', 'icon' => '📝', 'title' => 'Inscris-toi',      'desc' => 'Crée ton compte étudiant en 2 minutes'],
                    ['step' => '2', 'icon' => '🔍', 'title' => 'Trouve une mission','desc' => 'Parcours le catalogue d\'événements'],
                    ['step' => '3', 'icon' => '🤝', 'title' => 'Participe',         'desc' => 'Rejoins l\'événement et agis concrètement'],
                    ['step' => '4', 'icon' => '🎁', 'title' => 'Récompense-toi',   'desc' => 'Échange tes points contre des bons d\'achat'],
                ] as $step)
                    <div class="bg-white rounded-2xl p-6 shadow">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mx-auto mb-3">
                            {{ $step['step'] }}
                        </div>
                        <div class="text-3xl mb-3">{{ $step['icon'] }}</div>
                        <h3 class="font-semibold mb-1">{{ $step['title'] }}</h3>
                        <p class="text-gray-500 text-sm">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PARTNERS --}}
    <section id="partners" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2">Nos partenaires</h2>
            <p class="text-center text-gray-500 mb-12">Des entreprises engagées qui financent vos récompenses</p>

            @if($partners->isEmpty())
                <p class="text-center text-gray-400">Aucun partenaire pour le moment.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($partners as $partner)
                        <div class="border rounded-xl p-4 text-center hover:shadow transition">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2 text-green-700 font-bold text-lg">
                                {{ strtoupper(substr($partner->company_name, 0, 1)) }}
                            </div>
                            <p class="text-xs font-medium text-gray-700">{{ $partner->company_name }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 bg-gradient-to-r from-green-600 to-emerald-700 text-white text-center">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="text-4xl font-extrabold mb-4">Prêt à faire la différence ?</h2>
            <p class="text-green-100 mb-8 text-lg">Rejoins des milliers d'étudiants qui agissent pour un monde meilleur.</p>
            <a href="{{ route('register') }}"
                class="bg-yellow-400 text-gray-900 font-bold px-8 py-4 rounded-full text-lg hover:bg-yellow-300 transition">
                Créer mon compte gratuitement
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm">
        <p>© {{ date('Y') }} ActTogether — Ensemble pour un monde meilleur.</p>
    </footer>

</body>
</html>
