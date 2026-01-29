@extends('layouts.app') <!-- utilisez votre layout existant -->

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-md mx-auto glass p-10 rounded-3xl">
        <h2 class="text-3xl font-bold text-center mb-8">Connexion Admin</h2>
        
        @if($errors->any())
            <div class="glass p-4 rounded-xl mb-6 text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus
                   class="w-full glass mb-6 px-6 py-4 rounded-xl text-lg">
            <input type="password" name="password" placeholder="Mot de passe" required
                   class="w-full glass mb-8 px-6 py-4 rounded-xl text-lg">
            <div class="flex items-center mb-6">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-white/80">Se souvenir de moi</label>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 py-5 rounded-xl text-xl font-bold">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection