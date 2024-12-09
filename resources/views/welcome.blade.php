<x-layout class="mt-16 max-w-[986px] mx-auto">
    <div class="space-y-2">
        <section class="flex flex-row items-center">
            <h1 class="font-bold text-lg basis-1/4">Tìm kiếm dữ liệu rừng</h1>
            <form action="" class="basis-1/2">
                <input type="text" placeholder="Nhập khu vực cần tìm ..." class="rounded-lg bg-black/5 px-5 py-4 w-full max-w-xl shadow-lg">
            </form>
        </section>

        <section>
            <x-section-heading>Khu vực</x-section-heading>
            <div class="h-96 mt-2">
                <iframe width="100%" height="100%"
                    src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=mm&metricTemp=°C&metricWind=km/h&zoom=9&overlay=rain&product=ecmwf&level=surface&lat=10.77&lon=106.638&detailLat=10.833&detailLon=106.611&marker=true&message=true"
                    frameborder="0" class="rounded-xl shadow-lg"></iframe>
            </div>
        </section>

        <section>
            <x-section-heading>Tin tức</x-section-heading>
            <div class="grid lg:grid-cols-3 gap-8 mt-2">
                <x-news-card />
                <x-news-card />
                <x-news-card />
            </div>
        </section>
    </div>
</x-layout>
