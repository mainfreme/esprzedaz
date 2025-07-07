@extends('templates.app')

@section('title', 'Dodaj Zdjęcie')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pets.upload-image', ['id' => $id]) }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Opis:</label>
            <input type="text" name="additionalMetadata">
        </div>

        <div>
            <label>Plik:</label>
            <input type="file" name="file">

        </div>
        <div>
            <button type="submit">Wyślij obraz</button>
        </div>
    </form>
@endsection
