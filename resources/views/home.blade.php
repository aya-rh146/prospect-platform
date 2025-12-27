<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Bienvenue sur notre plateforme</h1>

    <!-- Formulaire Prospect -->
    <form action="{{ route('prospects.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Nom Complet</label>
            <input type="text" name="full_name" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Téléphone</label>
            <input type="text" name="phone_number" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Ville</label>
            <select name="city" class="border p-2 w-full" required>
                <option value="Tangier">Tangier</option>
                <option value="Tetouan">Tetouan</option>
                <option value="Rabat">Rabat</option>
                <option value="Kenitra">Kenitra</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Envoyer</button>
    </form>

    <!-- Liste vidéos -->
    <h2 class="text-2xl font-bold mt-8 mb-4">Vidéos Highlights</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($videos as $video)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-bold mb-2">{{ $video->title }}</h3>
                <video width="100%" controls>
                    <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
