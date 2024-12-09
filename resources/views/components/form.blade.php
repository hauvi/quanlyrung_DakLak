<div class="fixed right-0 z-40 h-[calc(100%-4.5rem)] w-4/5 px-3 pt-4 transition-all duration-500">
    <!-- Sử dụng Flexbox để chia thành hai cột -->
    <form method="POST" action="{{ $action }}">
        <h2 class="flex justify-center text-lg font-semibold py-2">{{ $title }}</h2>
        <div class="flex  justify-center">
            {{ $slot }}
        </div>
        <!-- Nút Lưu kế hoạch nằm giữa hai cột -->
        <div class="flex justify-center py-2">
            <button type="submit" class="bg-emerald-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                {{ $buttonText }}
            </button>
            <span class="border-s-2 m-2 border-black"></span>
            <button type="button" id="cancel-btn"
                class="bg-gray-200 border-s font-bold py-2 px-4 rounded hover:bg-stone-300">Hủy</button>
        </div>
        <input type="hidden" id="geom" name="geom">
    </form>
</div>
