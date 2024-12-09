<!-- resources/views/components/modal.blade.php -->
<div {{ $attributes->merge(['class' => 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden']) }}>
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" id="close-modal-btn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        {{ $slot }}
    </div>
</div>