@extends('layouts.admin')

@section('title', 'جميع الـ Prospects')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">جميع الـ Prospects</h1>
        <a href="{{ route('admin.prospects.export') }}" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Export CSV
        </a>
    </div>

    <form method="GET" class="mb-6">
        <div class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم، الهاتف، المدينة..." class="flex-1 border rounded px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-6 rounded hover:bg-blue-700">بحث</button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-right">ID</th>
                    <th class="px-4 py-3 text-right">الاسم</th>
                    <th class="px-4 py-3 text-right">الهاتف</th>
                    <th class="px-4 py-3 text-right">المدينة</th>
                    <th class="px-4 py-3 text-right">التاريخ</th>
                    <th class="px-4 py-3 text-right">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prospects as $prospect)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $prospect->id }}</td>
                    <td class="px-4 py-3">{{ $prospect->name }}</td>
                    <td class="px-4 py-3">{{ $prospect->phone }}</td>
                    <td class="px-4 py-3">{{ $prospect->city }}</td>
                    <td class="px-4 py-3">{{ $prospect->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.prospects.edit', $prospect->id) }}" class="text-blue-600 hover:underline ml-4">تعديل</a>
                        <form action="{{ route('admin.prospects.destroy', $prospect->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('متأكد من الحذف؟')" class="text-red-600 hover:underline">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $prospects->appends(request()->query())->links() }}
    </div>
</div>
@endsection