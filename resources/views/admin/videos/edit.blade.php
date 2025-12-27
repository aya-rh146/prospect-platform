@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ isset($video) ? 'Modifier' : 'Ajouter' }} Vidéo</h1>

    <form action="{{ isset($video) ? route('videos.update', $video->id) : route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($video))
            @method('PUT')
        @endif

        <input type="text" name="title" value="{{ $video->title ?? '' }}" placeholder="Titre vidéo" class="border p-2 w-full mb-4" required>
        <input type="file" name="video" class="mb-4" {{ isset($video) ? '' : 'required' }}>
        <input type="number" name="display_order" value="{{ $video->display_order ?? 0 }}" placeholder="Ordre" class="border p-2 w-full mb-4">
        <label class="block mb-4">
            <input type="checkbox" name="is_active" {{ isset($video) && $video->is_active ? 'checked' : '' }}> Actif
        </label>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
