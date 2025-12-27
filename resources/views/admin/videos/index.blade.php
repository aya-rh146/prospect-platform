@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Vidéos</h1>

    <a href="{{ route('videos.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Ajouter Vidéo</a>

    <table class="table-auto w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th>Title</th>
                <th>Ordre</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
            <tr>
                <td>{{ $video->title }}</td>
                <td>{{ $video->display_order }}</td>
                <td>{{ $video->is_active ? 'Oui' : 'Non' }}</td>
                <td>
                    <a href="{{ route('videos.edit', $video->id) }}" class="bg-blue-600 text-white px-2 py-1 rounded">Modifier</a>
                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-2 py-1 rounded">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
