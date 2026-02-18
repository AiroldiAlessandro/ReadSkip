<div>
  <button class="w-full flex items-center p-4 font-semibold text-left" onclick="loadChapter(this)" data-chapter="{{ $counter }}">
    <span class="mr-4 w-8 flex-shrink-0 font-bold text-primary text-left">
      {{ str_pad($counter, 2, '0', STR_PAD_LEFT) }}.
    </span>
    <span class="flex-1">
      {{ $title }}
    </span>
  </button>
</div>
@if ($counter <= ($total - 1))
  <hr>
@endif