<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class=" sm:px-6 lg:px-8 max-w-7xl mx-auto items-center mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex h-16 w-full justify-center">
            <div class="flex">
                <!-- Logo -->
                <div
                    class="md:absolute sm:fixed sm:top-0 sm:left-2 sm:p-1 block h-9 w-auto fill-current text-gray-800 dark:text-gray-200">
                    <x-custom-link href="{{ route('Ana Sayfa') }}">
                        <x-application-logo/>
                    </x-custom-link>
                </div>

                <!-- Navigation Links -->

                <div class="hidden space-x-5 sm:-my-px sm:ml-5 justify-center sm:flex max-w-4xl grow">
                    <x-nav-link :href="route('Ana Sayfa')" :active="request()->routeIs('Ana Sayfa')">
                        {{ __('Ana Sayfa') }}
                    </x-nav-link>
                    @if (request()->is('dashboard*'))
                        <x-nav-link :href="route('Panel')" :active="request()->routeIs('Panel')">
                            {{ __('Panel') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Geçmiş')" :active="request()->routeIs('Geçmiş')">
                            {{ __('Geçmiş') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Eserler')" :active="request()->routeIs('Eserler') || request()->routeIs('Eser Ekle')">
                            {{ __('Eserler') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Üyeler')" :active="request()->routeIs('Üyeler') || request()->routeIs('Üye Ekle')">
                            {{ __('Üyeler') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Duyuru Paneli')" :active="request()->routeIs('Duyuru Paneli')">
                            {{ __('Duyurular') }}
                        </x-nav-link>
                        <div class="md:absolute sm:fixed sm:top-0 sm:right-2 sm:p-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"/>
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
                    @else
                        <x-nav-link :href="route('Hakkımızda')" :active="request()->routeIs('Hakkımızda')">
                            {{ __('Hakkımızda') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Görseller')" :active="request()->routeIs('Görseller')">
                            {{ __('Görseller') }}
                        </x-nav-link>
                        <x-nav-link :href="route('Duyurular')" :active="request()->routeIs('Duyurular')">
                            {{ __('Duyurular') }}
                        </x-nav-link>
                        <x-nav-link :href="route('İletişim')" :active="request()->routeIs('İletişim')">
                            {{ __('İletişim') }}
                        </x-nav-link>
                        <div class="md:absolute sm:fixed sm:top-0 sm:right-2 sm:p-4" align="right">
                            @auth
                                <a href="{{url('admin')}}">
                                    <x-button href="{{url('admin')}}"
                                              :active="request()->routeIs('admin')">
                                        {{ __('Panel') }}
                                    </x-button>
                                </a>
                            @else
                                <a href="{{route('login')}}">
                                    <x-button :href="route('login')"> {{__('Giriş Yap')}} </x-button>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{route('register')}}">
                                        <x-button href="{{ route('register') }}">{{__('Kayıt Ol')}}</x-button>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

            </div>
            <!-- Hamburger -->
            <div class="-mr-2 absolute mr-2 mt-4 items-center sm:hidden right-0">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('Ana Sayfa')" :active="request()->routeIs('Ana Sayfa')">
                {{ __('Ana Sayfa') }}
            </x-responsive-nav-link>
            @if (request()->is('dashboard*'))
                <x-responsive-nav-link :href="route('Panel')" :active="request()->routeIs('Panel')">
                    {{ __('Panel') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Geçmiş')" :active="request()->routeIs('Geçmiş')">
                    {{ __('Geçmiş') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Eserler')" :active="request()->routeIs('Eserler')">
                    {{ __('Eserler') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Üyeler')" :active="request()->routeIs('Üyeler')">
                    {{ __('Üyeler') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Duyuru Paneli')" :active="request()->routeIs('Duyuru Paneli')">
                    {{ __('Duyuru Paneli') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('Hakkımızda')" :active="request()->routeIs('Hakkımızda')">
                    {{ __('Hakkımızda') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Görseller')" :active="request()->routeIs('Görseller')">
                    {{ __('Görseller') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('Duyurular')" :active="request()->routeIs('Duyurular')">
                    {{ __('Duyurular') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('İletişim')" :active="request()->routeIs('İletişim')">
                    {{ __('İletişim') }}
                </x-responsive-nav-link>
                @if (Route::has('login'))
                    <div
                        class="sm:top-0 sm:right-0 py-3.5 text-center align-content-center items-center self-center justify-items-center"
                        align="center">
                        @auth
                            <a href="{{url('admin')}}">
                                <x-button href="{{url('admin')}}"
                                          :active="request()->routeIs('admin')">
                                    {{ __('Panel') }}
                                </x-button>
                            </a>
                        @else
                            <a href="{{route('login')}}">
                                <x-button :href="route('login')"> {{__('Giriş Yap')}} </x-button>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{route('register')}}">
                                    <x-button href="{{ route('register') }}">{{__('Kayıt Ol')}}</x-button>
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            @endif
        </div>

        @if (request()->is('dashboard*'))
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
        @endif
    </div>
</nav>
