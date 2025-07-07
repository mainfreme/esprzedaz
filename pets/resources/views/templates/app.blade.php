@php
    use App\Enums\PetStatus;
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
<header>
    @if(isset($currentStatus))
        <h1 class="text-3xl font-bold mb-6">Lista zwierząt o statusie: <span class="text-blue-600">{{ $currentStatus }}</span></h1>
    @endif
</header>

<nav>
    <ul>
        <li>
            <a href="{{ route('pets.index', ['status' => PetStatus::AVAILABLE->value]) }}">Zwierzęta {{ PetStatus::AVAILABLE->label() }}</a>
        </li>
        <li>
            <a href="{{ route('pets.index', ['status' => PetStatus::PENDING->value]) }}">Zwierzęta {{ PetStatus::PENDING->label() }}</a>
        </li>
        <li>
            <a href="{{ route('pets.index', ['status' => PetStatus::SOLD->value]) }}">Zwierzęta {{ PetStatus::SOLD->label() }}</a>
        </li>
    </ul>
</nav>

<main>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mx-auto p-8">
        @yield('content')
    </div>
</main>

<footer>
    <p>&copy; 2025 Moja aplikacja. Wszelkie prawa zastrzeżone.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
