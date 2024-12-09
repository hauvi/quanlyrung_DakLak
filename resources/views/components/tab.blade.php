<!-- resources/views/components/tabs.blade.php -->
<ul  id="tabs" {{ $attributes->merge(['class' => 'inline-flex pt-2 px-1 w-full border-b border-black']) }}>
    {{ $slot }}
</ul>