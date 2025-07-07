@extends('templates.app')

@section('title', ' ')

@section('content')

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @php
            $route = isset($pet) ? route('pets.update', ['id'=> $pet->id]) : route('pets.store');
            $method = isset($pet) ? 'PUT' : 'POST';
        @endphp

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $route }}"  method="POST">
            @csrf
            @if(isset($pet))
                @method('PUT')
            @endif
            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nazwa</label>
                <input type="text" name="name" id="name" value="{{ old('name', $pet->name ?? '') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-700">Kategoria (Nazwa)</label>
                <input type="text" name="category[name]" id="category_name"
                       value="{{ old('category.name', $pet->category->name ?? '') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Photo URLs --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Photo URLs
                </label>
                <div id="photo-urls-wrapper">
                    @foreach(old('photoUrls', $pet->photoUrls ?? ['']) as $i => $url)
                        <input type="text" name="photoUrls[{{ $i }}]" value="{{ $url }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm mb-2" />
                    @endforeach
                </div>
                <button type="button" id="add-photo-url"
                        class="mt-2 text-sm text-blue-600 hover:underline">+ Dodaj URL</button>
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tagi</label>
                <div id="tags-wrapper">
                        @foreach(old('tags', $pet->tags ?? [['name' => '']]) as $index => $tag)
                            <div class="flex gap-2 mb-2 tag-row">
                                <input type="text" name="tags[{{ $index }}][name]" placeholder="Nazwa"
                                       value="{{ $tag->name ?? '' }}"
                                       class="w-3/4 border border-gray-300 rounded-md shadow-sm px-2 py-1" />
                            </div>
                        @endforeach
                </div>
                <button type="button" id="add-tag"
                        class="mt-2 text-sm text-blue-600 hover:underline">+ Dodaj tag
                </button>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    @foreach(['available', 'pending', 'sold'] as $option)
                        <option
                            value="{{ $option }}" {{ old('status', $pet->status ?? '') === $option ? 'selected' : '' }}>
                            {{ ucfirst($option) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    {{ isset($pet) ? 'Zapisz zmiany' : 'Dodaj zwierzaka' }}
                </button>
            </div>
        </form>

    </div>


    <script>
        let tagIndex = {{ count(old('tags', $pet->tags ?? [['id' => '', 'name' => '']])) }};

        document.getElementById('add-tag').addEventListener('click', function () {
            const wrapper = document.getElementById('tags-wrapper');

            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2', 'mb-2', 'tag-row');

            div.innerHTML = `
            <input type="text" name="tags[${tagIndex}][name]" placeholder="Nazwa"
                class="w-3/4 border border-gray-300 rounded-md shadow-sm px-2 py-1">
        `;

            wrapper.appendChild(div);
            tagIndex++;
        });

        document.getElementById('add-photo-url').addEventListener('click', () => {
            const wrapper = document.getElementById('photo-urls-wrapper');
            const index = wrapper.querySelectorAll('input').length;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = `photoUrls[${index}]`;
            input.className = 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm mb-2';
            wrapper.appendChild(input);
        });
    </script>
@endsection


