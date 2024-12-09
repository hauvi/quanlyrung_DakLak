<!-- resources/views/components/form-search.blade.php -->
<div class="flex sm:flex-row flex-col">
    <div class="flex flex-row mb-1 sm:mb-0">
        <div
            class="relative appearance-none h-full rounded-l border block bg-white border-gray-400 text-gray-700 px-2 leading-tight focus:outline-none hover:bg-zinc-300 transition-colors duration-300">
            <button id="advanced-search-btn" class="py-1 text-white rounded focus:outline-none group">
                <img width="20" height="20" src="{{ Vite::asset('resources/images/settings.png') }}" alt="settings"
                    class="transform transition-transform duration-300 group-hover:rotate-90 group-hover:brightness-125" />
            </button>
        </div>
        <div class="relative">
            <select
                class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 px-4 pr-8 leading-tight focus:outline-none text-sm">
                <option>--Chọn huyện--</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="block relative">
        <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                <path
                    d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                </path>
            </svg>
        </span>
        <input placeholder="Tìm kiếm ..."
            class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-1 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
    </div>
</div>
