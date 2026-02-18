<div class="max-w-7xl mx-auto px-4 py-7">
    <p class="text-2xl font-bold text-black">
        Capitoli
    </p>
    <div class="mx-auto">
        @php
            $counter_keys = 0;
        @endphp
        @foreach ($keys as $key)
            @php
                $counter_keys++;
                $key['counter'] = $counter_keys;
                $key['total'] = count($keys);
            @endphp
            @include('partials.book-detail.chapter', $key)
        @endforeach
    </div>
</div>
<script>
  function loadChapter(button) {
    const chapter = button.dataset.chapter;
    location.href = `/read/{{ $slug }}?chapter=${chapter}`;
  }
</script>