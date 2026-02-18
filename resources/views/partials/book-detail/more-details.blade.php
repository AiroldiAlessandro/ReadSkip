<div class=" mx-auto space-y-4 py-7">
        @foreach ($keys as $key)
            @include('partials.book-detail.more-detail', $key)
        @endforeach
</div>
<script>
  function toggleAccordion_more_details(button) {
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