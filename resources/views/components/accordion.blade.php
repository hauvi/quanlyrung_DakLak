<!-- Default Header with optional title -->
<div
    class="accordion-header cursor-pointer transition flex items-center h-8 space-x-1 shadow rounded-md border-1 hover:bg-zinc-50">
    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
    </svg>
    <h3 class="font-semibold text-sm">{{ $title }}</h3>
</div>
<!-- Default Content -->
<div class="accordion-content px-5 py-0 overflow-hidden max-h-0">
    {{ $slot }}
</div>

