<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links - Desktop -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 sm:space-x-8">
                    <!-- Dashboard (semua role) -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Menu Super Admin -->
                    @if (auth()->user()->role === 'super_admin')
                        <x-nav-link :href="route('super-admin.approvals.index')" :active="request()->routeIs('super-admin.approvals.*')">
                            {{ __('Approvals') }}
                        </x-nav-link>
                        <x-nav-link :href="route('super-admin.users.index')" :active="request()->routeIs('super-admin.users.*')">
                            {{ __('User Management') }}
                        </x-nav-link>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ __('Data Master') }}</div>
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
                                <x-dropdown-link :href="route('admin.master.transporters.index')">
                                    {{ __('Transporter') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.barangs.index')">
                                    {{ __('Nama Barang') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.suppliers.index')">
                                    {{ __('Nama Supplier') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.customers.index')">
                                    {{ __('Customer') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Menu Import Timbangan untuk Super Admin -->
                        {{-- <x-nav-link :href="route('admin.timbangan.import.index')" :active="request()->routeIs('admin.timbangan.import.*')">
                            {{ __('Import Timbangan') }}
                        </x-nav-link> --}}
                    @endif

                    <!-- Menu Admin -->
                    @if (auth()->user()->role === 'admin')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ __('Produksi') }}</div>
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
                                <x-dropdown-link :href="route('admin.produksi-raw.index')">
                                    {{ __('Produksi Raw') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.terima-raw.index')">
                                    {{ __('Terima Raw') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.timbangan.index')">
                                    {{ __('Timbangan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.keluar-material.index')">
                                    {{ __('Keluar Material') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.keluar-material-utm.index')">
                                    {{ __('Keluar Material UTM') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ __('Data Master') }}</div>
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
                                <x-dropdown-link :href="route('admin.master.transporters.index')">
                                    {{ __('Transporter') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.barangs.index')">
                                    {{ __('Nama Barang') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.suppliers.index')">
                                    {{ __('Nama Supplier') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.master.customers.index')">
                                    {{ __('Customer') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Menu Import Timbangan untuk Admin -->
                        {{-- <x-nav-link :href="route('admin.timbangan.import.index')" :active="request()->routeIs('admin.timbangan.import.*')">
                            {{ __('Import Timbangan') }}
                        </x-nav-link> --}}
                    @endif

                    <!-- Menu untuk Admin & Super Admin (UM & Lembur) -->
                    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                        <x-nav-link :href="route('admin.um-lembur.index')" :active="request()->routeIs('admin.um-lembur.*')">
                            {{ __('UM & Lembur') }}
                        </x-nav-link>
                    @endif

                    <!-- Menu Kasir -->
                    @if (auth()->user()->role === 'kasir')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ __('Penjualan') }}</div>
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
                                <x-dropdown-link :href="route('kasir.jual-material.index')">
                                    {{ __('Jual Material') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('kasir.aju-kas.index')">
                                    {{ __('Aju Kas') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('kasir.lap-kas.index')">
                                    {{ __('Laporan Kas') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('kasir.hutang.index')">
                                    {{ __('Hutang') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('kasir.piutang.index')">
                                    {{ __('Piutang') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif

                    <!-- Menu Read Only (semua role) -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ __('Laporan') }}</div>
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
                            <x-dropdown-link :href="route('readonly.produksi-raw.index')">
                                {{ __('Data Produksi Raw') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.timbangan.index')">
                                {{ __('Data Timbangan') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.terima-raw.index')">
                                {{ __('Data Terima Raw') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.keluar-material.index')">
                                {{ __('Data Keluar Material') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.keluar-material-utm.index')">
                                {{ __('Data Keluar Material UTM') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.jual-material.index')">
                                {{ __('Data Jual Material') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.hutang.index')">
                                {{ __('Data Hutang') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.piutang.index')">
                                {{ __('Data Piutang') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('readonly.um-lembur.index')">
                                {{ __('Data UM & Lembur') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Role Badge -->
                <span
                    class="mr-3 px-2 py-1 text-xs rounded-full 
                    @if (auth()->user()->role === 'super_admin') bg-purple-100 text-purple-800
                    @elseif(auth()->user()->role === 'admin') bg-blue-100 text-blue-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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

    <!-- Responsive Navigation Menu - Mobile -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Super Admin Mobile Menu -->
            @if (auth()->user()->role === 'super_admin')
                <x-responsive-nav-link :href="route('super-admin.approvals.index')" :active="request()->routeIs('super-admin.approvals.*')">
                    {{ __('Approvals') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('super-admin.users.index')" :active="request()->routeIs('super-admin.users.*')">
                    {{ __('User Management') }}
                </x-responsive-nav-link>

                <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Master</div>
                </div>
                <x-responsive-nav-link :href="route('admin.master.transporters.index')" :active="request()->routeIs('admin.master.transporters.*')">
                    {{ __('Transporter') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.barangs.index')" :active="request()->routeIs('admin.master.barangs.*')">
                    {{ __('Nama Barang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.suppliers.index')" :active="request()->routeIs('admin.master.suppliers.*')">
                    {{ __('Nama Supplier') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.customers.index')" :active="request()->routeIs('admin.master.customers.*')">
                    {{ __('Customer') }}
                </x-responsive-nav-link>

                <!-- Import Timbangan untuk Super Admin Mobile -->
                {{-- <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Import</div>
                </div> --}}
                {{-- <x-responsive-nav-link :href="route('admin.timbangan.import.index')" :active="request()->routeIs('admin.timbangan.import.*')">
                    {{ __('Import Timbangan') }}
                </x-responsive-nav-link> --}}
            @endif

            <!-- Admin Mobile Menu -->
            @if (auth()->user()->role === 'admin')
                <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produksi</div>
                </div>
                <x-responsive-nav-link :href="route('admin.produksi-raw.index')" :active="request()->routeIs('admin.produksi-raw.*')">
                    {{ __('Produksi Raw') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.terima-raw.index')" :active="request()->routeIs('admin.terima-raw.*')">
                    {{ __('Terima Raw') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.timbangan.index')" :active="request()->routeIs('admin.timbangan.*')">
                    {{ __('Timbangan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.keluar-material.index')" :active="request()->routeIs('admin.keluar-material.*')">
                    {{ __('Keluar Material') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.keluar-material-utm.index')" :active="request()->routeIs('admin.keluar-material-utm.*')">
                    {{ __('Keluar Material UTM') }}
                </x-responsive-nav-link>

                <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Master</div>
                </div>
                <x-responsive-nav-link :href="route('admin.master.transporters.index')" :active="request()->routeIs('admin.master.transporters.*')">
                    {{ __('Transporter') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.barangs.index')" :active="request()->routeIs('admin.master.barangs.*')">
                    {{ __('Nama Barang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.suppliers.index')" :active="request()->routeIs('admin.master.suppliers.*')">
                    {{ __('Nama Supplier') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.master.customers.index')" :active="request()->routeIs('admin.master.customers.*')">
                    {{ __('Customer') }}
                </x-responsive-nav-link>

                <!-- Import Timbangan untuk Admin Mobile -->
                {{-- <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Import</div>
                </div>
                <x-responsive-nav-link :href="route('admin.timbangan.import.index')" :active="request()->routeIs('admin.timbangan.import.*')">
                    {{ __('Import Timbangan') }}
                </x-responsive-nav-link> --}}
            @endif

            <!-- Menu untuk Admin & Super Admin (UM & Lembur) Mobile -->
            @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Karyawan</div>
                </div>
                <x-responsive-nav-link :href="route('admin.um-lembur.index')" :active="request()->routeIs('admin.um-lembur.*')">
                    {{ __('UM & Lembur') }}
                </x-responsive-nav-link>
            @endif

            <!-- Kasir Mobile Menu -->
            @if (auth()->user()->role === 'kasir')
                <div class="pt-2 pb-1">
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Penjualan & Keuangan
                    </div>
                </div>
                <x-responsive-nav-link :href="route('kasir.jual-material.index')" :active="request()->routeIs('kasir.jual-material.*')">
                    {{ __('Jual Material') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.aju-kas.index')" :active="request()->routeIs('kasir.aju-kas.*')">
                    {{ __('Aju Kas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.lap-kas.index')" :active="request()->routeIs('kasir.lap-kas.*')">
                    {{ __('Laporan Kas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.hutang.index')" :active="request()->routeIs('kasir.hutang.*')">
                    {{ __('Hutang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.piutang.index')" :active="request()->routeIs('kasir.piutang.*')">
                    {{ __('Piutang') }}
                </x-responsive-nav-link>
            @endif

            <!-- Read Only Mobile Menu (semua role) -->
            <div class="pt-2 pb-1">
                <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</div>
            </div>
            <x-responsive-nav-link :href="route('readonly.produksi-raw.index')" :active="request()->routeIs('readonly.produksi-raw.*')">
                {{ __('Data Produksi Raw') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.timbangan.index')" :active="request()->routeIs('readonly.timbangan.*')">
                {{ __('Data Timbangan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.terima-raw.index')" :active="request()->routeIs('readonly.terima-raw.*')">
                {{ __('Data Terima Raw') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.keluar-material.index')" :active="request()->routeIs('readonly.keluar-material.*')">
                {{ __('Data Keluar Material') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.keluar-material-utm.index')" :active="request()->routeIs('readonly.keluar-material-utm.*')">
                {{ __('Data Keluar Material UTM') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.jual-material.index')" :active="request()->routeIs('readonly.jual-material.*')">
                {{ __('Data Jual Material') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.hutang.index')" :active="request()->routeIs('readonly.hutang.*')">
                {{ __('Data Hutang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.piutang.index')" :active="request()->routeIs('readonly.piutang.*')">
                {{ __('Data Piutang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readonly.um-lembur.index')" :active="request()->routeIs('readonly.um-lembur.*')">
                {{ __('Data UM & Lembur') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="mt-1">
                    <span
                        class="px-2 py-1 text-xs rounded-full 
                        @if (auth()->user()->role === 'super_admin') bg-purple-100 text-purple-800
                        @elseif(auth()->user()->role === 'admin') bg-blue-100 text-blue-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                    </span>
                </div>
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