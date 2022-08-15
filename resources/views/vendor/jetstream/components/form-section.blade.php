@props(['submit'])

<div style="border-color:#fff;border-style:hidden" {{ $attributes->merge(['class' => 'md:grid md:grid-cols-1 md:gap-6']) }}>
{{-- 
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>
--}}

    <div style="border-color:#fff;border-style:hidden" class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="px-4 py-5 bg-white sm:p-6  {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="gridx grid-cols-6x gap-6">
                    {{ $form }}
                </div>
                @if (isset($actions))
                <div class="flex items-center justify-center px-4 py-3 text-right sm:px-6  sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
            </div>


        </form>
    </div>
</div>
