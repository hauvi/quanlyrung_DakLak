<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lý rừng</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources//images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css"> --}}
    <script src="{{ Vite::asset('resources/js/jquery-3.6.0.min.js') }}"></script>
    <link href="{{ Vite::asset('resources/css/fontawesome/fontawesome.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 p-0 h-screen w-screen">
    <nav class="fixed top-0 z-50 w-full bg-white border-b font-hanken-grotesk shadow-md h-12">
        <div class="px-6 pt-1.5 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button aria-label="open" id="open" onclick="showNav(true)"
                        class="p-2 hover:bg-zinc-300 rounded-full">
                        <img src="{{ Vite::asset('resources/images/menu.svg') }}" width="20" height="20"
                            alt="menu--v1" />
                    </button>
                    <a href="/" class="flex">
                        <img src="{{ Vite::asset('resources/images/favicon-32x32.png') }}" class="h-8 mx-1"
                            alt="Pixel Position Logo" />
                        <span class="flex mx-2 items-center font-bold">Cơ sở dữ liệu rừng Đăk Lăk</span>
                    </a>
                </div>
                <div class="absolute left-1/2 transform -translate-x-1/2 items-center">
                    <div class="space-x-6">
                        {{--  <x-nav-link href="/" :active="request()->is('/')">Trang chủ</x-nav-link> --}}
                        <x-nav-link href="/" :active="request()->is('/')">Bản đồ</x-nav-link>
                        <x-nav-link href="/data" :active="request()->is('data')">Dữ liệu</x-nav-link>
                        <x-nav-link href="/profession" :active="request()->is('profession')">Công tác</x-nav-link>
                        {{-- <x-nav-link href="/admin" :active="request()->is('admin')">Quản trị</x-nav-link> --}}
                    </div>
                </div>
                {{-- <div>
                    <x-button href="/login">Đăng nhập</x-button>
                </div> --}}
            </div>
        </div>
    </nav>

    @php
        $class = '';
    @endphp
    {{--   <main {{$attributes->merge(['class'=>'fixed top-12 left-0 bottom-8 z-40 w-sceen h-[calc(100%-4.5rem)]'])}}>{{ $slot }}</main> --}}
    <main {{ $attributes->merge(['class' => 'top-12 bottom-8 z-40 h-[calc(100%-4.5rem)]']) }}>
        {{ $slot }}</main>

    <footer class="fixed bottom-0 left-0 z-50 w-full bg-white border-t h-6 font-semibold">
        <div class="w-full py-1 px-4 md:flex md:items-center md:justify-between">
            <span class="text-xs sm:text-center">© 2024 IGEO v1.0
            </span>
            <div class="absolute left-1/2 transform -translate-x-1/2 text-xs sm:text-center">
                Cổng thông tin quản lý dữ liệu rừng tỉnh Đăk Lăk
            </div>
            <ul class="flex flex-wrap items-center text-xs sm:mt-0">
                {{-- <li>
                    <a href="#" class="hover:underline me-3">Đang hoạt động: <span>01</span></a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-3">Hôm nay: <span>01</span></a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-3">Tháng này: <span>01</span></a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Tất cả: <span>01</span></a>
                </li> --}}
            </ul>
        </div>
    </footer>

    <script>
        let Main = document.getElementById("sidebar");
        let Table = document.getElementById("table");
        let open = document.getElementById("open");

        const showNav = (flag) => {
            if (flag) {
                /* Table.classList.toggle("-translate-x-[20%]"); */
                Main.classList.toggle("-translate-x-full");

                if (Table.classList.contains("w-4/5")) {
                    Table.classList.remove("w-4/5");
                    Table.classList.add("w-full");
                } else {
                    Table.classList.remove("w-full");
                    Table.classList.add("w-4/5");
                }
            }
        };
    </script>
</body>

</html>
