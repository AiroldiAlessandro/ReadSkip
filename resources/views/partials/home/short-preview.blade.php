<!-- <div class="w-40 flex-shrink-0">
    <img src="{{ asset('images/short-template.png') }}" alt="Titolo libro" class="w-full h-auto rounded shadow-md">
    <p class="mt-2 text-sm font-medium">{{ $title }}</p>
    <p class="mt-2 text-sm text-xs">{{ $subtitle }}</p>
    <div class="mt-2 flex justify-between items-center text-xs font-medium text-gray-700">
        <p class="mt-2 text-sm text-xs font-medium mt-2">{{ $time }}min</p>
        <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6 4l10 6-10 6V4z" />
        </svg>
    </div>
</div> -->
<!-- <div class="w-40 flex-shrink-0 grid grid-cols-3 items-center gap-2">
    <div class="col-span-1 flex justify-center">
        <img src="{{ asset('images/short-template.png') }}" alt="Titolo libro" class="w-full h-auto rounded shadow-md">
    </div>
    
    <div class="col-span-1">
        <p class="mt-2 text-sm font-medium">{{ $title }}</p>
        <p class="mt-2 text-sm text-xs">{{ $subtitle }}</p>
    </div>

</div> -->

<div class="flex w-[360px] flex-shrink-0 bg-white overflow-hidden gap-2">
    <!-- Colonna sinistra: testo (1/3) -->
    <div class="w-1/3 flex flex-col justify-between">
        <img src="{{  asset('images/short-template.png') }}" alt="Titolo libro" class="w-full h-full object-cover rounded-md">
    </div>
    <!-- Colonna destra: immagine (2/3) -->
    <div class="w-2/3 flex flex-col justify-between h-full p-1">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-medium text-primary">{{ $title_1 }}</p>
            <p class="text-sm font-medium">{{ $title_2 }}</p>
            <p class="text-xs text-gray-600">{{$subtitle}}</p>
        </div>
        <div class="flex justify-between items-center text-xs font-medium text-gray-700">
            <span>20min</span>
        </div>
    </div>
</div>