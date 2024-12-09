<div class="flex mb-2">
    <label for="{{ $name }}"
        class="flex items-center flex-shrink-0 text-sm font-bold bg-gray-200 w-28 rounded-l-lg px-2">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="border border-gray-300 text-sm rounded-r-lg leading-tight focus:outline block w-full p-2 text-wrap">
        <option value="" disabled selected>{{ $placeholder }}</option>
        @foreach ($options as $item)
            <option value="{{ $item->id }}">{{ $valueCallback($item) }}</option>
        @endforeach
    </select>
</div>
