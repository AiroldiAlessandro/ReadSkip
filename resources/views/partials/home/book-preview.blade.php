<a href="/book/{{$id}}">
    <div class="w-40 flex-shrink-0">
        <img src="{{ $image }}" alt="Titolo libro" class="w-full h-56 rounded shadow-md">

        <!-- Titolo (1 riga fissa) -->
        <p class="mt-2 text-sm font-medium line-clamp-1 h-[1.5em] leading-[1.5em] overflow-hidden">
            {{ $title }}
        </p>

        <!-- Sottotitolo (2 righe fisse) -->
        <p class="mt-2 text-xs line-clamp-2 h-[3em] leading-[1.5em] overflow-hidden">
            {{ $subtitle }}
        </p>

        <div class="mt-2 flex justify-between items-center text-xs font-medium text-gray-700">
            <p class="mt-2">{{ $time }} min</p>
            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 4l10 6-10 6V4z" />
            </svg>
        </div>
    </div>
</a>
