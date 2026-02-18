<div class="border rounded">
  <button class="w-full flex items-center justify-between p-4 font-semibold text-left" onclick="toggleAccordion_more_details(this)">
    <span>{{ $title }}</span>
    <!-- <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
    </svg> -->
  </button>
  <div class="px-4 pb-4">
    <p>{{ $content }}</p>
  </div>
</div>