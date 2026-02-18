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
            @include('partials.book-detail.key-idea', $key)
        @endforeach
    </div>
</div>
<script>
  function toggleAccordionKeyIdeas(button) {
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
</script>