@props([
    'error' => false,
    'isDisabled' => false,
    'isMarkedAsRequired' => true,
    'prefix' => null,
    'required' => false,
    'suffix' => null,
])

<label
    {{ $attributes->class(['fi-fo-field-wrp-label inline-flex items-center gap-x-3']) }}
>
    {{ $prefix }}

    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
        {{ $slot }}@if ($required && $isMarkedAsRequired && ! $isDisabled)<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
        @endif
    </span>

    {{ $suffix }}
</label>
