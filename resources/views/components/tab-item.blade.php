<!-- resources/views/components/tab-item.blade.php -->
<li class="{{ $active ? 'bg-white border-t border-r border-l -mb-px' : '' }} px-4 text-gray-800 font-semibold py-2 rounded-t border-black">
    <a href="{{ $href }}">{{ $slot }}</a>
</li>
