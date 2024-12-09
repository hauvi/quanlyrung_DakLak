<aside id="sidebar"
    class="fixed left-0 top-12 z-40 w-1/5 h-[calc(100%-4.5rem)] transform transition-transform duration-500 border-r border-gray-200 shadow-md"
    aria-label="Sidebar">
    <div class="h-full px-5 overflow-y-auto bg-white py-3">
        <!-- Phần nội dung chính của sidebar -->
        <div class="flex-grow">
            {{ $slot }}
        </div>

      {{--   <!-- Nút "Nhập Excel" luôn nằm ở đáy -->
        <div class="fixed justify-center bottom-3">
            <x-button href="{{ route('import.form') }}">Nhập Excel</x-button>
        </div> --}}
    </div>
</aside>
<script>
    document.querySelectorAll(".accordion-header").forEach((header) => {
        header.addEventListener("click", function() {
            const accordionContent = this.nextElementSibling;
            const isOpen = accordionContent.style.maxHeight && accordionContent.style.maxHeight !==
                "0px";

            // Thay đổi phần nội dung của accordion hiện tại
            if (!isOpen) {
                accordionContent.style.maxHeight = `${accordionContent.scrollHeight}px`;
            } else {
                accordionContent.style.maxHeight = "0px";
            }
        });
    });
</script>
