@extends('templates.app')

@section('title', $title ?? 'Lista zwierząt')

@section('content')



    @if($pets->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">Informacja</p>
            <p>Nie znaleziono żadnych zwierząt o tym statusie.</p>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="py-3 px-6 text-right space-x-2">
                <a href="{{ route('pets.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                    Dodaj nowego zwierzaka
                </a>
            </div>
            <table class="min-w-full leading-normal">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Zdjęcie</th>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Imię</th>
                    <th class="py-3 px-6 text-left">Kategoria</th>
                    <th class="py-3 px-6 text-left">Tagi</th>
                    <th class="py-3 px-6 text-center">Status</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @foreach ($pets as $pet)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            @if($pet->resource->mainPhotoUrl)
                                <img src="{{ $pet->resource->mainPhotoUrl }}" alt="Zdjęcie {{ $pet->resource->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xs text-gray-500">Brak</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">{{ $pet->resource->id }}</td>
                        <td class="py-3 px-6 text-left font-semibold">{{ $pet->resource->name }}</td>
                        <td class="py-3 px-6 text-left">
                            @if($pet->resource->category)
                                {{ $pet->resource->category->name }}
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">
                            @foreach ($pet->resource->tags as $tags)
                                #{{ $tags->name }}
                            @endforeach
                        </td>
                        <td class="py-3 px-6 text-center">
                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">{{ $pet->resource->status }}</span>
                        </td>
                        <td class="py-3 px-6 text-right space-x-2">
                            <a href="{{ route('pets.detail', $pet->resource->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                Zobacz szczegóły
                            </a>
                            <a href="{{ route('pets.edit', $pet->resource->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                Edytuj
                            </a>
                            <form action="{{ route('pets.destroy', ['status' => $pet->resource->status, 'id'=> $pet->resource->id]) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Na pewno chcesz usunąć tego zwierzaka?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                                    Usuń
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
