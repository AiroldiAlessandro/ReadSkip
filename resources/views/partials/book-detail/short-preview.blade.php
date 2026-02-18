<!-- <div class="flex flex-shrink-0 bg-white overflow-hidden gap-2" name="shortPreview" data-content="{{$text}}"  data-current="{{$current}}"  data-total="{{$total_count}}">
    <div class="flex flex-col justify-between">
        <img src="{{  asset('images/short-template/'.($current+1).'.png') }}" alt="Titolo libro" class="w-[150px] h-[150px] object-cover rounded-4xl">
    </div>
</div> -->
<div class="flex flex-shrink-0 bg-white overflow-hidden gap-2 rounded-lg" name="shortPreview" data-content="{{$text}}"  data-current="{{$current}}"  data-total="{{$total_count}}">
    <div class="flex flex-col items-center justify-center max-w-[200px] h-[350px] p-3 bg-[url('/images/short-wallpaper.webp')] bg-cover bg-center">
        <p class="text-center text-sm text-[#2b2b2b]" style="font-family: 'Annie Use Your Telescope', cursive;">{{$text}}</p>
    </div>
</div>