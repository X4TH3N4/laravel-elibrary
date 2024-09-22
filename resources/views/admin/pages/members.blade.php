<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('Üye Ekle')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-50 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-800">
                    <div class="mx-auto max-w-7xl">
                        <div class="bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-800 py-10">
                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-gray-800 dark:text-gray-200 text-base font-semibold leading-6">{{__('Üye Listesi')}}</h1>
                                        <p class="text-gray-800 dark:text-gray-200 mt-2 text-sm t">{{__('Aşağıda tüm üyeleri görebilir, değişiklik yapabilirsiniz.')}}</p>
                                        @if (session('message'))

                                            <div x-data="{ show: true }"
                                                 x-init="setTimeout(() => show = false, 5000)"
                                                 x-show="show" class="alert alert-success"
                                                 x-cloak>
                                                <div class="mt-6 overflow-hidden rounded shadow-sm">
                                                    <div class="relative flex justify-between px-2 py-2 font-bold text-white bg-green-600 rounded-t">
                                                        <div class="relative flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 class="inline w-6 h-6 mr-2 opacity-75">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span>{{__('Başarılı!')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="p-3 bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-900 rounded-b shadow-lg">
                                                        <span class="">{{__('Üye başarıyla eklendi!')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <a href="{{ route('Üye Ekle') }}">
                                            <x-success-button>{{__('Üye Ekle')}}</x-success-button>
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-8 flow-root text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800">
                                    <div class="text-gray-800 dark:text-gray-200 -mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="text-gray-800 dark:text-gray-200 inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <table class="text-gray-800 dark:text-gray-200 min-w-full divide-y divide-gray-700">
                                                <thead>
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        {{__('Üye Adı')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Yetkisi')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Üyelik Durumu')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Son Değişiklik Tarihi')}}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{__('Hesap Oluşturma Tarihi')}}</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">{{__('Düzenle')}}</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-800">
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        <div class="flex items-center gap-x-4">
                                                            <img
                                                                src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                                alt="" class="h-8 w-8 rounded-full bg-gray-800">
                                                            <div
                                                                class="truncate text-sm font-medium leading-6 text-gray-800 dark:text-gray-200">{{__('Berk YILDIZ')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm ttext-gray-800 dark:text-gray-200">
                                                        <div class="flex gap-x-3">
                                                            <div
                                                                class="rounded-md bg-gray-700/40 px-2 py-1 text-xs text-gray-800 dark:text-gray-200  font-medium text-gray-400 ring-1 ring-inset ring-white/10">{{__('Root')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        <div
                                                            class="flex items-center justify-end gap-x-2 sm:justify-start">
                                                            <div
                                                                class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                                                                <div class="h-1.5 w-1.5 rounded-full bg-current"></div>
                                                            </div>
                                                            <div class="text-gray-800 dark:text-gray-200 sm:block">{{__('Aktif')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('45 dakika önce')}}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('1 hafta önce')}}
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                                                            <x-purple-button>{{__('Düzenle')}}</x-purple-button>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-800 dark:text-gray-200 sm:pl-0">
                                                        <div class="flex items-center gap-x-4">
                                                            <img
                                                                src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                                alt="" class="h-8 w-8 rounded-full bg-gray-800">
                                                            <div
                                                                class="truncate text-sm font-medium leading-6 text-gray-800 dark:text-gray-200">{{__('e-Library System')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">

                                                        <div class="flex gap-x-3">
                                                            <div
                                                                class="rounded-md bg-gray-700/40 px-2 py-1 text-xs  font-medium text-gray-800 dark:text-gray-200 ring-1 ring-inset ring-white/10">{{__('Admin')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        <div
                                                            class="flex items-center justify-end gap-x-2 sm:justify-start">
                                                            <div
                                                                class="flex-none rounded-full p-1 text-rose-400 bg-rose-400/10">
                                                                <div class="h-1.5 w-1.5 rounded-full bg-current"></div>
                                                            </div>
                                                            <div class="text-gray-800 dark:text-gray-200 sm:block">{{__('Pasif')}}</div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('45 dakika önce')}}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                        {{__('1 hafta önce')}}
                                                    </td>
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
