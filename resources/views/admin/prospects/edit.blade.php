@extends('layouts.admin')

@section('title', 'تعديل Prospect')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">تعديل Prospect</h1>

    <form action="{{ route('admin.prospects.update', $prospect->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block mb-2">الاسم</label>
            <input type="text" name="name" value="{{ old('name', $prospect->name) }}" class="w-full border rounded px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2">الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone', $prospect->phone) }}" class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email', $prospect->email) }}" class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2">المدينة</label>
            <input type="text" name="city" value="{{ old('city', $prospect->city) }}" class="w-full border rounded px-4 py-2">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">حفظ التعديلات</button>
            <a href="{{ route('admin.prospects.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded hover:bg-gray-600">رجوع</a>
        </div>
    </form>
</div>
@endsection
