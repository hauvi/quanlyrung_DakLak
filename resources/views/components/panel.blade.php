@php
    $class = 'p-4 bg-black/10 rounded-xl border border-2 border-transparent hover:border-blue-600 hover:shadow-md group transition-color duration-1000';
@endphp
<div {{ $attributes(['class' => $class]) }}>
    {{ $slot }}
</div>
