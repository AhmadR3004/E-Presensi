<nav x-data="{ open: false }"
    class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ url('logo.png') }}" class="h-12">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <b>{{ __('Dashboard') }}</b>
                    </x-nav-link>
                </div>

                <!-- Monitoring Presensi -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('presensi.monitoring')" :active="request()->routeIs('presensi.monitoring')">
                        <b>{{ __('Monitoring Presensi') }}</b>
                    </x-nav-link>
                </div>
                <!-- Data Izin/Sakit -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('presensi.dataizinsakit')" :active="request()->routeIs('presensi.dataizinsakit')">
                        <b>{{ __('Approval Izin/Sakit') }}</b>
                    </x-nav-link>
                </div>

                <!-- Data Master Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="top" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <b>{{ __('Data Master') }}</b>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('pegawai.index')">
                                {{ __('Pegawai') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('jabatan.index')">
                                {{ __('Jabatan') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Laporan Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="top" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <b>{{ __('Laporan') }}</b>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('laporan.pegawai')">
                                {{ __('Pegawai') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('laporan.presensi')">
                                {{ __('Presensi') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('laporan.rekap-presensi')">
                                {{ __('Rekap Presensi') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('laporan.izinsakit')">
                                {{ __('Izin Sakit') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('laporan.rekap-izinsakit')">
                                {{ __('Rekap Izin Sakit') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <!-- Konfigurasi Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="top" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <b>{{ __('Konfigurasi') }}</b>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('konfigurasi.lokasikantor')">
                                {{ __('Lokasi Kantor') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Monitoring Presensi -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('presensi.monitoring')" :active="request()->routeIs('presensi.monitoring')">
                {{ __('Monitoring Presensi') }}
            </x-responsive-nav-link>
        </div>

        <!-- Data Izin/Sakit -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('presensi.dataizinsakit')" :active="request()->routeIs('presensi.dataizinsakit')">
                {{ __('Approval Izin/Sakit') }}
            </x-responsive-nav-link>
        </div>

        <!-- Data Master Dropdown for Mobile -->
        <div class="pt-2 pb-3 space-y-1">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <b>{{ __('Data Master') }}</b>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-responsive-nav-link :href="route('pegawai.index')">
                        {{ __('Pegawai') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('jabatan.index')">
                        {{ __('Jabatan') }}
                    </x-responsive-nav-link>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Laporan Dropdown for Mobile -->
        <div class="pt-2 pb-3 space-y-1">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <b>{{ __('Laporan') }}</b>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-responsive-nav-link :href="route('laporan.presensi')">
                        {{ __('Presensi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('laporan.rekap-presensi')">
                        {{ __('Rekap Presensi') }}
                    </x-responsive-nav-link>
                    <x-dropdown-link :href="route('laporan.izinsakit')">
                        {{ __('Izin Sakit') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('laporan.rekap-izinsakit')">
                        {{ __('Rekap Izin Sakit') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Konfigurasi Dropdown for Mobile -->
        <div class="pt-2 pb-3 space-y-1">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <b>{{ __('Konfigurasi') }}</b>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-responsive-nav-link :href="route('konfigurasi.lokasikantor')">
                        {{ __('Lokasi Kantor') }}
                    </x-responsive-nav-link>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
