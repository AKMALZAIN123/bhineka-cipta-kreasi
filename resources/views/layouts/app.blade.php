<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- FONT AWESOME (UNTUK ICON) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          referrerpolicy="no-referrer" />

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('css')

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    
    @stack('scripts')

    <script>
        //navbar search
        document.addEventListener("DOMContentLoaded", () => {
            const searchBtn = document.getElementById("searchDropdownBtn");
            const searchMenu = document.getElementById("searchDropdownMenu");

            if (searchBtn) {
                searchBtn.addEventListener("click", () => {
                    searchMenu.classList.toggle("show");
                });

                document.addEventListener("click", (e) => {
                    if (!searchBtn.contains(e.target) && !searchMenu.contains(e.target)) {
                        searchMenu.classList.remove("show");
                    }
                });
            }
        });

        //navbar logout
        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById("userDropdownBtn");
            const menu = document.getElementById("userDropdownMenu");

            if (btn) {
                btn.addEventListener("click", () => {
                    menu.classList.toggle("show");
                });

                document.addEventListener("click", (e) => {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove("show");
                    }
                });
            }
        });
    </script>
</body>
</html>
