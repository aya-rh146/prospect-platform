@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('messages.videos.title') }}
                </h2>
                <p class="text-gray-600 mt-2">{{ __('messages.videos.description') }}</p>
            </div>
            <a href="{{ route('admin.videos.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                {{ __('messages.videos.add') }}
            </a>
        </div>

        <!-- Videos List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <h3 class="text-2xl font-bold">{{ __('messages.videos.list_title') }}</h3>
                <p class="text-gray-600 mt-1">{{ __('messages.videos.drag_help') }}</p>
            </div>
            <div class="p-6">
                <div id="sortable-videos" class="space-y-4">
                    @foreach($videos as $video)
                    <div class="video-item bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-indigo-300 transition-colors cursor-move" data-id="{{ $video->id }}" data-order="{{ $video->display_order }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Drag Handle -->
                                <div class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                                    </svg>
                                </div>
                                
                                <!-- Video Info -->
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $video->title }}</h4>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-sm text-gray-500">{{ __('messages.videos.table.order') }}: {{ $video->display_order }}</span>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $video->is_active ? __('messages.videos.form.active') : __('messages.videos.form.inactive') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.videos.edit', $video->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ __('messages.common.edit') }}
                                </a>
                                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('{{ __('messages.videos.delete_confirm') }}')">
                                        {{ __('messages.common.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($videos->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    {{ __('messages.videos.table.empty') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-videos');
    
    new Sortable(el, {
        animation: 150,
        handle: '.video-item',
        ghostClass: 'opacity-50',
        chosenClass: 'ring-2 ring-indigo-500',
        
        onEnd: function(evt) {
            const videoItems = document.querySelectorAll('.video-item');
            const newOrder = [];
            
            videoItems.forEach((item, index) => {
                newOrder.push({
                    id: item.dataset.id,
                    order: index + 1
                });
            });
            
            // Send new order to server
            fetch('/admin/videos/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    videos: newOrder
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Order updated successfully');
                }
            })
            .catch(error => {
                console.error('Error updating order:', error);
            });
        }
    });
});
</script>
@endsection
