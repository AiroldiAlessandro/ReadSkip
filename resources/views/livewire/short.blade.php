<div>
    <!-- Bottone per aprire il modale -->
    <button onclick="Livewire.dispatch('openModal', { content: this.dataset.content, total: this.dataset.total, current: this.dataset.current })" class="hidden"
        id="openShortButton">
        Apri Modale
    </button>
    <!-- Overlay -->
    @if($show)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="rounded-lg shadow-lg p-6 w-full max-w-xs sm:max-w-sm md:max-w-md aspect-[9/16] mx-auto
            bg-[url('/images/short-wallpaper.webp')] bg-cover bg-center">
                <!-- Barra in alto con progress bar a sinistra e bottone a destra -->
                <div class="flex items-center justify-between space-x-2">
                    
                    <!-- Progress bar stile Instagram -->
                    <div class="flex gap-1 flex-1">
                        @for ($i = 0; $i < $total; $i++)
                            <div class="h-1 flex-1 bg-white/30 rounded overflow-hidden">
                                <div 
                                    class="h-full bg-white progress-bar" name="short_progress_bar" data-number="{{ $i }}"
                                    style="width: {{ ($i < $current) ? '100%' : '0%' }};">
                                </div>
                            </div>
                        @endfor
                    </div>
                    
                    <!-- Bottone close -->
                    <button wire:click="close" name="close_short" class="text-white rounded-md px-4 py-2">X</button>
                </div>
                <div class="flex items-center justify-center h-full" name="next_short">
                    <p class="text-center text-3xl text-[#2b2b2b]" style="font-family: 'Annie Use Your Telescope', cursive;">{{ $content }}</p>
                </div>

                <div class="absolute bottom-20 left-1/2 -translate-x-1/2">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="w-32 opacity-80">
                </div>

            </div>
        </div>
    @endif
</div>