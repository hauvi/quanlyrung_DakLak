<x-layout>
    {{--  <aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto pt-16 bg-white">
        <x-schema>Quản lý người dùng</x-schema>
        <ul id="dropdown-example" class=" pace-y-2">
            <x-sidebar-link>Phòng ban</x-sidebar-link>
            <x-sidebar-link>Người dùng</x-sidebar-link>
            <x-sidebar-link>Phân quyền</x-sidebar-link>
        </ul>
    </div>
</aside> --}}
    <x-sidebar></x-sidebar>
    <div class="sm:ml-64 mt-20 px-10">
        <x-table></x-table>
    </div>
</x-layout>
