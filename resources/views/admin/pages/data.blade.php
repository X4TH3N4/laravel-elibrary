<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Eserler') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white dark:bg-gray-800">
                    <div class="mx-auto max-w-7xl">
                        <div class="bg-white dark:bg-gray-800 py-10">
                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-base font-semibold leading-6text-gray-800 dark:text-gray-200">{{__('Eser Listesi')}}</h1>
                                        <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">{{__('Aşağıda veri tabanında olan bütün eserlerin listesini görebilir, değişiklik yapabilirsiniz.')}}</p>
                                        @if (session('message'))

                                            <div x-data="{ show: true }"
                                                 x-init="setTimeout(() => show = false, 5000)"
                                                 x-show="show" class="alert alert-success"
                                                 x-cloak>
                                                <div class="mt-6 overflow-hidden rounded shadow-sm">

                                                    <div class="relative flex justify-between px-2 py-2 font-bold text-gray-900 dark:text-gray-100 bg-green-600 rounded-t">

                                                        <div class="relative flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 class="inline w-6 h-6 mr-2 opacity-75">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            <span>{{__('Başarılı!')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="p-3 bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-900 rounded-b shadow-lg">
                                                        <span class="">{{__('Eser başarıyla eklendi!')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <a href="{{route('Eser Ekle')}}">
                                        <x-success-button>{{__('Eser Ekle')}}</x-success-button></a>
                                    </div>
                                </div>
                                <div class="mt-8 flow-root">
                                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <table class="min-w-full divide-y divide-gray-700">
                                                <thead>
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        {{__('Eser Adı')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Yazarı')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Eser Türü')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Yayın Tarihi')}}</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">{{__('Düzenle')}}</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-800">
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        {{__('Seyahatname')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('Evliya Çelebi')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('Manzum')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{_('1630-81')}}</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                                                            <x-purple-button>{{__('Düzenle')}}</x-purple-button>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        {{__('Surname-i Vehbi')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('Seyyid Vehbi')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('Mensur-Manzum')}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">{{__('1720')}}</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                                                            <x-purple-button>{{__('Düzenle')}}</x-purple-button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
