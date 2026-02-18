<div>
  <button class="w-full flex items-center p-4 font-semibold text-left" onclick="toggleAccordionKeyIdeas(this)">
    <span class="mr-4 w-8 flex-shrink-0 font-bold text-primary text-left">
      {{ str_pad($counter, 2, '0', STR_PAD_LEFT) }}.
    </span>
    <span class="flex-1">
      {{ $title }}
    </span>
    <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
    </svg>
  </button>
  <div class="px-4 pb-4 hidden">
    <p>{{ $content }}</p>
  </div>
</div>
@if ($counter <= ($total - 1))
  <hr>
@endif