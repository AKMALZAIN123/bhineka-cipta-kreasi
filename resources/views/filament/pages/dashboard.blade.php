<x-filament-panels::page>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-950 dark:text-white">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="flex items-center gap-2">
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600 dark:text-gray-400">Waktu Server</p>
                <p id="server-time" class="text-xl font-semibold text-gray-950 dark:text-white">
                    {{ now()->format('H:i:s') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Widgets --}}
    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="[...$this->getWidgetData()]"
        :widgets="$this->getVisibleWidgets()"
    />

    {{-- Script realtime jam --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clock = document.getElementById('server-time');
            if (!clock) return;

            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                clock.textContent = `${hours}:${minutes}:${seconds}`;
            }

            updateClock(); // Set awal
            setInterval(updateClock, 1000); // Update tiap detik
        });
    </script>
</x-filament-panels::page>
