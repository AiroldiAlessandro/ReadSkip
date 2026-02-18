<livewire:short />
<div class="max-w-7xl mx-auto px-4 py-7">
    <p class="text-2xl font-bold text-black">
        {{ $title }}
    </p>
    <p class="text-gray-700 mb-6 mt-5">
        {{ $subtitle }}
    </p>
    <div class="overflow-x-auto">
        <div class="flex space-x-6 py-4 px-2">
            @foreach ($shorts as $short)
                @include('partials.book-detail.short-preview', $short)
            @endforeach
        </div>
    </div>
    <script>
        var progress = 0;
        const duration = 10000; // 6 secondi
        const intervalTime = 40; // ogni 40ms aggiorniamo (~100 step)
        const step = 100 / (duration / intervalTime);
        var interval;
        var current;

        $('div[name="shortPreview"]').click(function(){
            const content = $(this).data('content');
            current = $(this).data('current');
            const total = $(this).data('total');
            $('#openShortButton').attr('data-content', content);
            $('#openShortButton').attr('data-total', total);
            $('#openShortButton').attr('data-current', current);
            $('#openShortButton').click();
        });
        Livewire.on('openModal', (payload) => {
            startProgressBar();
        });

        $(document).on('click', 'div[name="next_short"]', function(e){
            // Prendo la larghezza del div
            const width = $(this).width();
            // Prendo la posizione del click relativa al div
            const x = e.offsetX;

            if(x < width / 2){
                // Click nella metà sinistra
                previousShort(); // funzione per tornare indietro
            } else {
                // Click nella metà destra
                nextShort(); // funzione per andare avanti
            }
        });
        $(document).on('click', 'button[name="close_short"]', function(){
            clearInterval(interval);
        });
        function startProgressBar(){
            progress = 0;
            clearInterval(interval);
            interval = setInterval(function () {
                progress += step;

                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    nextShort();
                }

                $(`.progress-bar[name='short_progress_bar'][data-number='${current}']`).css("width", progress + "%");
            }, intervalTime);
        }
        function nextShort(){
            current ++;
            let next_short = $(`div[name='shortPreview'][data-current='${current}']`);
            if (next_short.length) {
                next_short.click();
            }else{
                $('button[name="close_short"]').click();
            }
        }
        function previousShort(){
            current --;
            let next_short = $(`div[name='shortPreview'][data-current='${current}']`);
            if (next_short.length) {
                next_short.click();
            }else{
                $('button[name="close_short"]').click();
            }
        }
    </script>
    <style>
        div[name="shortPreview"]:hover{
            cursor: pointer;
        }
    </style>
</div>