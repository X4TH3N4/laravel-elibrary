<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Eser Ekle') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Eser eklemek için aşağıdaki bilgileri doldurun.") }}
        </p>

    </header>

    <form method="POST" action="{{ route('Eser Ekle') }}" class="relative mt-6 space-y-6">
        @csrf
        <div class="space-y-12">
            <div class="border-white/10 pb-12">
                <hr class="border-white/10 pb-6">
                <h1 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{__('Eser Bilgileri')}}</h1>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-full">
                        <label for="first-name"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Adı')}}</label>
                        <div class="mt-2">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                   required>
                            <x-input-error class="mt-2" :messages="$errors->get('first-name')"/>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="country"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Türü')}}</label>
                        <div class="mt-2">
                            <select id="country" name="country" autocomplete="country-name"
                                    class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 [&_*]:text-black"
                                    required>
                                <option class="">Hatırat</option>
                                <option>Günlük</option>
                                <option>Otobiyografi</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country')"/>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="country3"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Tarzı')}}</label>
                        <div class="mt-2">
                            <select id="country3" name="country3" autocomplete="country-name"
                                    class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 [&_*]:text-black"
                                    required>
                                <option>Mensur</option>
                                <option>Manzum</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country3')"/>
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="country2"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Dili')}}</label>
                        <div class="mt-2">
                            <select id="country2" name="country2" autocomplete="country-name"
                                    class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 [&_*]:text-black"
                                    required>
                                <option>Arapça</option>
                                <option>Farsça</option>
                                <option>Osmanlıca</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country2')"/>
                        </div>
                    </div>

                    <div class="col-span-full ">
                        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Eser
                            Dosyası</label>
                        <label for="file-upload"
                               class="border-gray-400 border-1 bg-gray-50 relative cursor-pointer rounded-md bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-900 font-semibold
                                           text-gray-900 dark:text-gray-100 hover:text-indigo-500">
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">

                                <div class="text-center">
                                    <svg class=" mx-auto h-12 w-12 text-gray-500" viewBox="0 0 24 24" fill="currentColor"
                                         aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-400 ">

                                        <span>Dosya seç</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only ">

                                        <p class="pl-1">veya buraya fırlat</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-400">PDF Dosyası</p>
                                </div>

                            </div>
                        </label>
                        <p class="mt-3 text-sm leading-6 text-gray-400">{{__('Dosya yükleyin veya aşağıda bulunan Eser Linkini girin.')}}</p>
                    </div>


                    <div class="sm:col-span-full">
                        <label for="third-name"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Linki')}}</label>
                        <div class="mt-2">
                            <input type="text" name="third-name" id="third-name" autocomplete="given-name"
                                   placeholder="https://ornek.com/eser.pdf"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            <x-input-error class="mt-2" :messages="$errors->get('first-name')"/>
                        </div>
                    </div>


                    <div class="sm:col-span-full">
                        <label for="last-name"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Toplam Sayfa Sayısı')}}</label>
                        <div class="mt-2">
                            <input type="text" name="last-name" id="last-name" autocomplete="given-name"
                                   placeholder="Varak No"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            <x-input-error class="mt-2" :messages="$errors->get('first-name')"/>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="about"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Eser Bilgisi')}}</label>
                        <div class="mt-2">
                            <textarea id="about" name="about" rows="3"
                                      class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('about')"/>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-400">{{__('Eser ile ilgili verilecek bilgileri yazınız. (Zorunlu Değil)')}}</p>
                    </div>

                    <div class="sm:col-span-full">
                        <label for="first-namee"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('En Boy Bilgileri')}}</label>
                        <div class="mt-2">
                            <input type="text" name="first-namee" id="first-namee" autocomplete="given-name"
                                   placeholder="16 cm x 23.5 cm"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('first-namee')"/>
                            <p class="mt-3 text-sm leading-6 text-gray-400">{{__('Lütfen En x Boy şeklinde giriniz.')}}</p>
                        </div>
                    </div>

                    <div class="sm:col-span-full">
                        <label for="date"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Tarihi')}}</label>
                        <div class="mt-2">
                            <div class="relative ">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide datepicker-orientation="bottom" id="tarih"
                                       name="tarih" type="text"
                                       class="bg-white/5  border-0 shadow-sm ring-1 ring-inset ring-white/10 text-gray-900 dark:text-gray-100 rounded-md focus:ring-2 focus:ring-inset focus:ring-indigo-500 block w-full pl-10 p-2.5"
                                       placeholder="Tarih girin.">
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('tarih')"/>
                        </div>
                    </div>

                    <div class="sm:col-span-full">
                        <label for="country5"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Tarih Cinsi')}}</label>
                        <div class="mt-2">
                            <select id="country5" name="country5" autocomplete="country-name"
                                    class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 [&_*]:text-black"
                                    required>
                                <option>Hicri</option>
                                <option>Miladi</option>
                                <option>Rumi</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country5')"/>
                        </div>
                    </div>
                </div>
                <div class="border-white/10 pb-6">
                    <hr class="border-white/10 pb-12">
                    <hr class="border-white/10 pb-12">
                    <h1 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100 mb-4">Neşir Bilgileri</h1>

                    <div class="sm:col-span-full mb-2">

                        <label for="neshir"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Neşirin Kaynağı')}}</label>
                        <div class="mt-2">
                            <input type="text" name="neshir" id="neshir" autocomplete="given-name"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                   required>
                            <x-input-error class="mt-2" :messages="$errors->get('neshir')"/>
                        </div>
                    </div>
                    <div class="sm:col-span-full mb-2">

                        <label for="nesirISBN"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('ISBN')}}</label>
                        <div class="mt-2">
                            <input type="text" name="nesirISBN" id="nesirISBN" autocomplete="given-name"
                                   class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                   required>
                            <x-input-error class="mt-2" :messages="$errors->get('nesirISBN')"/>
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="country6"
                               class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{__('Neşir Çeşidi')}}</label>
                        <div class="mt-2">
                            <select id="country6" name="country6" autocomplete="country-name"
                                    class="block w-full rounded-md border-gray-400 border-1 bg-gray-50 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 [&_*]:text-black"
                                    required>
                                <option>Arap Alfabesi - Matbu</option>
                                <option>Latinize - Transkripsiyon</option>
                                <option>Transliterasyon</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country6')"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-button>{{ __('    Eseri Ekle') }}</x-button>
        </div>
    </form>
</section>
