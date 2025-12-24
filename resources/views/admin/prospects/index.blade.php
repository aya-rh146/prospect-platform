@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Prospects</h1>

    <table class="table-auto w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prospects as $prospect)
            <tr>
                <td>{{ $prospect->full_name }}</td>
                <td>{{ $prospect->phone_number }}</td>
                <td>{{ $prospect->email }}</td>
                <td>{{ $prospect->city }}</td>
                <td>
                    <form action="{{ route('prospects.destroy', $prospect->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-2 py-1 rounded">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $prospects->links() }} <!-- pagination -->
</div>
@endsection
