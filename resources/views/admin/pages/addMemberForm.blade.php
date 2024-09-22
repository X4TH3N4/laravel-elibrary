<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Üye Ekle') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Üye eklemek için lütfen aşağıdaki bilgileri doldurun.") }}
        </p>
    </header>



    <form method="POST" action="{{ route('aqua', ['id' => 5 ]) }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label class="text-gray-700 dark:text-gray-50" for="name" :value="__('Üye Adı')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Üye E-Mail Adresi')" />
            <x-text-input id="name" placeholder="ornek@mail.com" name="email" type="email" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div class="flex items-center gap-4">
            <x-button>{{ __('Üyei Ekle') }}</x-button>
        </div>
    </form>
</section>
