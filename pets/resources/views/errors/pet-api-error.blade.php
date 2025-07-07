<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Błąd usługi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="container mx-auto p-8 mt-10">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-md" role="alert">
        <p class="font-bold text-xl mb-2">Wystąpił błąd</p>
        <p>Nie udało się pobrać danych z zewnętrznej usługi. Spróbuj ponownie później.</p>
        <div class="mt-4 bg-red-50 p-3 rounded">
            <p class="text-sm font-semibold">Szczegóły błędu:</p>
            <p class="text-sm font-mono">{{ $message }}</p>
        </div>
    </div>
</div>

</body>
</html>
