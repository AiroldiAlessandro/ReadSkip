<div class="flex flex-col sm:flex-row w-full">
    <div class="w-full sm:w-1/3 p-4 sm:sticky sm:top-4 self-start">
        <div class="border border-gray-200 shadow-lg rounded-lg">
            <div class="justify-center p-3">
                <p class="text-2xl font-bold text-black mt-5 text-center"> {{$title}} </p>
                <p class="text-sm text-gray-700 mb-6 mt-2 text-center"> {{$author}} </p>  
                <!-- Audio player -->   
                @if (!empty($chapter_audio_path))
                <div class="p-2">
                    @php
                        $audio_path = asset('storage/' . $chapter_audio_path);
                    @endphp
                    <!-- Audio element (nascosto) -->
                    <audio id="audioPlayer" src="{{ $audio_path }}"></audio>

                    <!-- Pulsanti di controllo -->
                    <div class="flex justify-center items-center gap-4">
                        <button id="backwardBtn" class="rounded-full w-12 h-12 flex items-center justify-center">
                            <img src="{{ asset('images/back_10.png') }}" alt="back_10_sec">
                        </button>
                        <button id="playPauseBtn" class="bg-primary text-white rounded-full border-8 border-primary-100 w-20 h-20 flex items-center justify-center p-3">
                            <svg id="play_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M187.2 100.9C174.8 94.1 159.8 94.4 147.6 101.6C135.4 108.8 128 121.9 128 136L128 504C128 518.1 135.5 531.2 147.6 538.4C159.7 545.6 174.8 545.9 187.2 539.1L523.2 355.1C536 348.1 544 334.6 544 320C544 305.4 536 291.9 523.2 284.9L187.2 100.9z"/></svg>
                            <svg id="pause_icon" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M176 96C149.5 96 128 117.5 128 144L128 496C128 522.5 149.5 544 176 544L240 544C266.5 544 288 522.5 288 496L288 144C288 117.5 266.5 96 240 96L176 96zM400 96C373.5 96 352 117.5 352 144L352 496C352 522.5 373.5 544 400 544L464 544C490.5 544 512 522.5 512 496L512 144C512 117.5 490.5 96 464 96L400 96z"/></svg>
                        </button>
                        <button id="forwardBtn" class="rounded-full w-12 h-12 flex items-center justify-center">
                            <img src="{{ asset('images/forward_10.png') }}" alt="forward_10_sec">
                        </button>
                    </div>
                    <!-- Barra di progresso -->
                    <div class="px-6 mt-4">
                        <input
                            type="range"
                            min="0"
                            max="100"
                            value="0"
                            class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-black"
                            id="progressBar"
                        />
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span id="currentTime">0:00</span>
                            <span id="totalTime">0:00</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <!-- Chapters -->
            <div class="border-t">
                <button class="w-full flex items-center justify-between p-4 font-semibold text-left text-primary" onclick="toggleAccordion(this)">
                    <span>Capitoli</span>
                    <svg class="w-5 h-5 transform transition-transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-4 pb-4">
                    @if ($chapters_list)
                        @foreach ($chapters_list as $number => $title)
                            <hr>
                            <div class="p-1 flex text-sm cursor-pointer p-2 @if ($number != $chapter_number) opacity-50 @endif " data-chapter-number="{{ $number }}" wire:click="showChapter({{ $number }})">
                                <div>
                                    <span class="font-bold text-primary">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}.</span>  {{ $title }}
                                </div>
                                <div class="p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:10px" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <!--  -->
        </div>
        
    </div>
    <div class="w-full sm:w-2/3 p-4" id="chapter_text">
    @php
        $progess_bar = (100 * $chapter_number) / $chapter_total_count;
    @endphp

        <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
            <div class="bg-primary h-1 rounded-full transition-all duration-1000 ease-out" style="width: {{ $progess_bar }}%;"></div>
        </div>
        <p class="text-2xl font-bold text-black mt-5">
            <span class="font-bold text-primary">
                {{ str_pad($chapter_number, 2, '0', STR_PAD_LEFT) }}.
            </span> 
            {{ $chapter_name }}
        </p>
        <!-- Animazione testo -->
        <div x-data="{ show: true }" x-effect="show = false; setTimeout(() => show = true, 10)" wire:loading.class="opacity-50">
            <template x-if="show">
                <p  id="chapter_long_text"
                    x-transition:enter="transition-opacity duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="text-gray-700 mb-6 mt-5 text-justify"
                >
                    {{ $chapter_long_text }}
                </p>
            </template>
            <div id="highlight-custom-menu" class="highlight-custom-menu">
                <button id="highlight-btn">Evidenzia</button>
                <button id="copy-btn">Copia</button>
            </div>
            <div id="highlighted-custom-menu" class="highlight-custom-menu">
                <button id="delete-highlight-btn">Elimina</button>
                <button id="copy-highlighted-btn">Copia</button>
                <button id="note-highlight-btn">Aggiungi nota</button>
            </div>
        </div>
        <hr class="mt-5">
        <div class="flex flex-row w-full">
            <div class="w-full w-1/3 p-4 justify-center">
                @if ($chapter_number > 1)
                <button class="bg-white rounded-full border border-gray-200 w-14 h-14 flex items-center justify-center" wire:click="previousChapter">
                    <img src="{{ asset('images/right_arrow.png') }}" alt="prossima pagina" class="h-5 w-5 rotate-180">
                </button>
                @endif
            </div>
            <div class="flex w-full w-1/3 p-4 justify-center items-center">
                <p class="text-sm">{{ $chapter_number }} su {{ $chapter_total_count }}</p>
            </div>
            <div class="flex w-full w-1/3 p-4 justify-end items-center">
                @if ($chapter_number < $chapter_total_count)
                <button class="bg-white rounded-full border border-gray-200 w-14 h-14 flex items-center justify-center" wire:click="nextChapter">
                    <img src="{{ asset('images/right_arrow.png') }}" alt="prossima pagina" class="h-5 w-5">
                </button>
                @endif
            </div>
        </div>
        <!--  -->
        
        @if ( $chapter_relevant_quote)
            <div class="bg-yellow rounded-lg p-5 mt-7">
                <p class="p4 font-semibold">Citazione capitolo</p>
                <p class="italic">"{{ $chapter_relevant_quote }}"</p>
            </div>
        @endif
        <div class="rounded-lg px-5 pt-5 border border-gray-200 mt-7">
            <p class="p4 font-semibold">Domande capitolo</p>
            @include('partials.book-detail.more-details', [
                'keys' => $open_questions_and_answers
            ])  
        </div>
        <div class="rounded-lg p-5 border border-gray-200 mt-5">
            <p class="p4 font-semibold">Sintesi capitolo</p>
            <p class="text-justify mt-5">{{ $chapter_text }}</p>
        </div>
        <div class="rounded-lg p-5 border border-gray-200 mt-5">
            <p class="p4 font-semibold"> Rispondi alle seguenti domande:</p>
            @if ($questions_and_answers && $questions_and_answers->domande)
                @foreach ($questions_and_answers->domande as $key => $domanda_obj)
                    <p class="font-semibold mt-7">{{ $domanda_obj->domanda }}</p>
                    @foreach ($domanda_obj->risposte as $key_risposte => $risposte)
                        @if ($key_risposte != 0)
                            <br>
                        @endif
                        <input type="radio" class="mx-2" name="question_{{ $key }}" wire:model="userAnswers.{{ $key }}" value="{{ $key_risposte }}">
                        <p class="inline italic">{{ $risposte->testo }}</p>
                    @endforeach
                @endforeach
            @endif
            <br>
            <div class="relative inline-block text-left">
                <button class="bg-primary text-white px-4 py-2 rounded-full hover:bg-primary/80 mt-2" wire:click="checkQuestionResponse">Verifica</button>
            </div>
            {{-- Messaggio di risultato --}}
            @if ($resultMessage)
                <div class="mt-4 p-3 rounded {{ $score == count($questions_and_answers->domande) ? 'bg-green-100' : 'bg-yellow-100' }}">
                    <p class="font-semibold">{{ $resultMessage }}</p>
                </div>
            @endif
        </div>
        <hr class="mt-5">
        <div class="flex flex-row w-full">
            <div class="w-full w-1/3 p-4 justify-center">
                @if ($chapter_number > 1)
                <button class="bg-white rounded-full border border-gray-200 w-14 h-14 flex items-center justify-center" wire:click="previousChapter">
                    <img src="{{ asset('images/right_arrow.png') }}" alt="prossima pagina" class="h-5 w-5 rotate-180">
                </button>
                @endif
            </div>
            <div class="flex w-full w-1/3 p-4 justify-center items-center">
                <p class="text-sm">{{ $chapter_number }} su {{ $chapter_total_count }}</p>
            </div>
            <div class="flex w-full w-1/3 p-4 justify-end items-center">
                @if ($chapter_number < $chapter_total_count)
                <button class="bg-white rounded-full border border-gray-200 w-14 h-14 flex items-center justify-center" wire:click="nextChapter">
                    <img src="{{ asset('images/right_arrow.png') }}" alt="prossima pagina" class="h-5 w-5">
                </button>
                @endif
            </div>
        </div>
    </div>
    <!-- NOTE modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <!-- Bottone chiusura -->
            <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

            <!-- Titolo -->
            <h2 class="text-xl font-bold mb-4">Inserisci le tue note qui:</h2>

            <!-- Contenuto -->
            <div class="mb-4">
                <label for="note" class="block text-gray-700 font-medium mb-1">Note:</label>
                <textarea id="note" rows="4" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Scrivi qui le tue note..."></textarea>
            </div>

            <!-- Azioni -->
            <div class="flex justify-end space-x-2">
                <button id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annulla</button>
                <button id="saveNote" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salva</button>
            </div>
        </div>
    </div>
    <script>
        //menu evidenzia
        var highlights_global;
        document.addEventListener('load-highlights', event => {
            highlights_global = event.detail[0];
            loadhighlights(highlights_global);
        });
        async function loadhighlights(highlights) {
            setTimeout(() => {
                let contentDiv = document.getElementById("chapter_long_text");
                if (!contentDiv) return;
                // 🔹 Rimuovi tutti gli span evidenziati esistenti
                const oldSpans = contentDiv.querySelectorAll('span[data-highlight-id]');
                oldSpans.forEach(span => {
                    const parent = span.parentNode;
                    // sostituisco lo span con il suo contenuto testuale
                    parent.replaceChild(document.createTextNode(span.textContent), span);
                    parent.normalize(); // unisce eventuali nodi di testo adiacenti
                });

                highlights.forEach(h => {
                    let text = h.text;
                    let walker = document.createTreeWalker(contentDiv, NodeFilter.SHOW_TEXT);
                    while (walker.nextNode()) {
                        let node = walker.currentNode;
                        let idx = node.nodeValue.indexOf(text);
                        if (idx !== -1) {
                            let range = document.createRange();
                            range.setStart(node, idx);
                            range.setEnd(node, idx + text.length);

                            let span = document.createElement('span');
                            span.style.backgroundColor = '#405de663';
                            span.setAttribute('data-highlight-id', h.id);
                            range.surroundContents(span);
                            break;
                        }
                    }
                });
            }, 50); // 50ms dovrebbe bastare perché Alpine abbia renderizzato
        }
        $(document).on('mouseup', function(e) {
            var selection = window.getSelection();
            var selectedText = selection.toString();
            if (selectedText) {
                var range = selection.getRangeAt(0);
                /* check se dentro a chapter_long_text */
                var container = range.commonAncestorContainer;
                if (container.nodeType === 3) {
                    container = container.parentNode;
                }
                if ($(container).closest('#chapter_long_text').length <= 0) {
                    return;
                }
                /*  */
                var rect = range.getBoundingClientRect();
                var menu = $('#highlight-custom-menu');

                // Posiziona il menu sopra la selezione
                if ($('#highlight-custom-menu').is(':hidden')) {
                    menu.css({
                        left: rect.left + window.scrollX + (rect.width / 2) - (menu.outerWidth() / 2),
                        top: rect.top + window.scrollY - menu.outerHeight() - 5,
                        display: 'block'
                    });
                }

                // Aggiungi eventi ai pulsanti del menu
                $('#highlight-btn').off('click').on('click', function() {
                    let range = selection.getRangeAt(0);
                    let span = document.createElement('span');
                    span.style.backgroundColor = '#405de663';
                    range.surroundContents(span);
                    hideAllHighlightlMenu();
                    let highlightData = {
                        text: selectedText, // Testo evidenziato
                        position: range.getBoundingClientRect() // Posizione della selezione
                    };
                    Livewire.dispatch('saveHighlight', { text: selectedText, position: highlightData.position })
                    window.addEventListener('highlight-saved', function handler(event) {
                        const id = event.detail[0].id;
                        span.setAttribute('data-highlight-id', id);
                        window.removeEventListener('highlight-saved', handler);
                    });
                });

                $('#copy-btn').off('click').on('click', function() {
                    navigator.clipboard.writeText(selectedText).then(function() {
                        //alert('Testo copiato!');
                    });
                    hideAllHighlightlMenu();
                });
            } else {
                hideAllHighlightlMenu();
            }
        });
        // Nascondi il menu quando si clicca altrove
        $(document).on('mousedown', function(e) {
            if (!$(e.target).closest('#highlight-custom-menu').length && !$(e.target).closest('#highlighted-custom-menu').length) {
                hideAllHighlightlMenu();
            }
        });
///////////////        
        //click su un testo evidenziato
        $(document).on('click', '#chapter_long_text span', function (){
            const span = $(this);
            let highlight_id = span.attr('data-highlight-id');
            const selection = window.getSelection();
            const range = document.createRange();
            range.selectNodeContents(span[0]);
            selection.removeAllRanges();
            selection.addRange(range);
            var selectedText = selection.toString();

            // Mostra il menu personalizzato
            const rect = range.getBoundingClientRect();
            const menu = $('#highlighted-custom-menu');
            hideAllHighlightlMenu();
            let note = getNote(highlight_id);
            if (note) {
                $('#note-highlight-btn').html('Modifica nota');
            }else{
                $('#note-highlight-btn').html('Aggiungi nota');
            }
            menu.css({
                left: rect.left + window.scrollX + (rect.width / 2) - (menu.outerWidth() / 2),
                top: rect.top + window.scrollY - menu.outerHeight() - 5,
                display: 'block'
            });
            menu.attr('data-highlight-id', highlight_id);
            $('#copy-highlighted-btn').off('click').on('click', function() {
                navigator.clipboard.writeText(selectedText).then(function() {
                    //alert('Testo copiato!');
                });
                hideAllHighlightlMenu();
            });
            $('#note-highlight-btn').off('click').on('click', function() {
                if (note) {
                    $('#note').val(note);
                }else{
                    $('#note').val('');
                }
                $('#modal').removeClass('hidden');
                hideAllHighlightlMenu();
            });
            $('#saveNote').off('click').on('click', function() {
                // Chiama il metodo Livewire
                Livewire.dispatch('saveHighlightNote', { id: highlight_id, text: $('#note').val() });
                // Chiudi il modale
                $('#modal').addClass('hidden');
                // Pulire la textarea se vuoi
                $('#note').val('');
            });
        });
        $('#delete-highlight-btn').off('click').on('click', function() {
            let menu = $('#highlighted-custom-menu');
            let highlightId = menu.attr('data-highlight-id');
            if (!highlightId) return;
            Livewire.dispatch('deleteHighlight', { id: highlightId });
            let span = $(`span[data-highlight-id="${highlightId}"]`);
            span.contents().unwrap(); // rimuove solo il span, mantenendo il testo
            hideAllHighlightlMenu();
        });
        $('#closeModal, #cancelBtn').click(function() {
            $('#modal').addClass('hidden');
        });

        // Chiudi modale cliccando fuori dal contenuto
        $('#modal').click(function(e) {
            if (e.target.id === 'modal') {
                $(this).addClass('hidden');
            }
        });
        function getNote(highlight_id){
            let note = null;
            highlights_global.forEach(h => {
                let text = h.text;
                if (h.id == highlight_id && h.note && h.note != '') {
                    note = h.note;
                }
            });

            return note;
        }
        /*  */
        Livewire.on('scrollToTop', () => {
            const target = document.getElementById('chapter_text');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
        function hideAllHighlightlMenu(){
            $('#highlight-custom-menu').hide();
            $('#highlighted-custom-menu').hide();
        }
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
        Livewire.hook('morph.updated', (message, component) => {
            initAudioPlayer();
        });
        initAudioPlayer();
        function initAudioPlayer(){
            const audio = document.getElementById('audioPlayer');
            if (!audio) return;

            const playPauseBtn = document.getElementById('playPauseBtn');
            const progressBar = document.getElementById('progressBar');
            const currentTimeEl = document.getElementById('currentTime');
            const totalTimeEl = document.getElementById('totalTime');
            const backwardBtn = document.getElementById('backwardBtn');
            const forwardBtn = document.getElementById('forwardBtn');

            // Reset listeners per evitare duplicati
            audio.replaceWith(audio.cloneNode(true));
            playPauseBtn.replaceWith(playPauseBtn.cloneNode(true));
            backwardBtn.replaceWith(backwardBtn.cloneNode(true));
            forwardBtn.replaceWith(forwardBtn.cloneNode(true));
            progressBar.replaceWith(progressBar.cloneNode(true));

            // Ricollega gli elementi dopo il clone
            const newAudio = document.getElementById('audioPlayer');
            const newPlayPauseBtn = document.getElementById('playPauseBtn');
            const newProgressBar = document.getElementById('progressBar');
            const newCurrentTimeEl = document.getElementById('currentTime');
            const newTotalTimeEl = document.getElementById('totalTime');
            const newBackwardBtn = document.getElementById('backwardBtn');
            const newForwardBtn = document.getElementById('forwardBtn');

            function formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
            }

            newAudio.addEventListener('loadedmetadata', () => {
                newTotalTimeEl.textContent = formatTime(newAudio.duration);
                newProgressBar.max = Math.floor(newAudio.duration);
            });

            newAudio.addEventListener('timeupdate', () => {
                newProgressBar.value = Math.floor(newAudio.currentTime);
                newCurrentTimeEl.textContent = formatTime(newAudio.currentTime);
            });

            newPlayPauseBtn.addEventListener('click', () => {
                if (newAudio.paused) {
                    newAudio.play();
                    document.getElementById('pause_icon').style.display = 'block';
                    document.getElementById('play_icon').style.display = 'none';
                } else {
                    newAudio.pause();
                    document.getElementById('pause_icon').style.display = 'none';
                    document.getElementById('play_icon').style.display = 'block';
                }
            });

            newBackwardBtn.addEventListener('click', () => {
                newAudio.currentTime = Math.max(0, newAudio.currentTime - 10);
            });

            newForwardBtn.addEventListener('click', () => {
                newAudio.currentTime = Math.min(newAudio.duration, newAudio.currentTime + 10);
            });

            newProgressBar.addEventListener('input', () => {
                newAudio.currentTime = newProgressBar.value;
            });
        }
    </script>
    <style>
        .highlight-custom-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 5px;
            font-size: 14px;
        }

        .highlight-custom-menu button {
            background: none;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .highlight-custom-menu button:hover {
            background-color: #f0f0f0;
        }
    </style>
</div>
