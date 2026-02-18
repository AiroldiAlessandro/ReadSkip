<div class="max-w-7xl mx-auto px-4 py-12 border-t border-b border-gray-200">
    <p class="text-2xl font-bold text-black mt-5">
        {{ $title }}
    </p>
    <p class="text-gray-700 mb-6 mt-5">
        {{ $subtitle }}
    </p>
    <div class="overflow-x-auto">
        <div class="flex space-x-6 py-4 px-2">
            @foreach ($books as $book)
                @include('partials.home.short-preview', $book)
            @endforeach
        </div>
        <div class="flex space-x-6 py-4 px-2">
            @foreach ($books as $book)
                @include('partials.home.short-preview', $book)
            @endforeach
        </div>
    </div>
</div>