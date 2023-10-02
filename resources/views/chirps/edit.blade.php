<x-app-layout>

    <div class="max-w-2x1 mx-auto p-4 sm:p-6 lg:p-8">

        <div class="text-white">
            <a href="{{ route('change.language', 'fr') }}">Français</a> | <a
                href="{{ route('change.language', 'en') }}">Anglais</a>
        </div><br>

        <form action="{{ route('chirps.update', $chirp) }}" method="post">
            @csrf
            @method('PATCH')
            {{-- <input type="hidden" name="" id="" value="PATCH"> --}}
            <textarea name="message" placeholder="{{ __('util.msg') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message', $chirp->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <x-primary-button class="mt-4"> {{ __('Mettre à jour') }} </x-primary-button>
            <x-primary-button class="mt-4 bg-red-400" href="{{route('chirps.index')}}"> {{ __('Annuler') }} </x-primary-button>
        </form>
    </div>

</x-app-layout>
