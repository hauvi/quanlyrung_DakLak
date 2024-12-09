<label for="{{ $id }}"
    class="flex items-center flex-shrink-0 text-gray-700 text-sm font-bold bg-gray-200 w-28 rounded-l-lg px-2">{{ $label }}</label>
<input type="text" id="{{ $id }}" name="{{ $id }}" placeholder="{{ $placeholder }}"
    class="border border-gray-300 text-gray-900 text-sm rounded-r-lg leading-tight focus:outline block w-full p-2">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#{{ $id }}", {
            dateFormat: "Y-m-d",
        });
    });
</script>
