<x-app-layout>
    {{-- @php
        $message = "Vous n'avez pas saisi le nom d'utilisateur";
    @endphp


<x-alert :color="'bg-green-500'" :message="$message"/>
<x-alert :color="'bg-red-500'" :message="'Ce champs est requis'"/> --}}

    <x-card>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus magnam temporibus ratione consectetur
            excepturi sit facere odit reiciendis dolores, at minima exercitationem ea aliquam maxime quod? Sint quas
            omnis cupiditate.</p>
    </x-card>

    <div class="max-w-2x1 mx-auto p-4 sm:p-6 lg:p-8">

        <div class="text-white">
            <a href="{{ route('change.language', 'fr') }}">Français</a> | <a
                href="{{ route('change.language', 'en') }}">Anglais</a>
        </div><br>

        <form action="{{ route('chirps.store') }}" method="post">
            @csrf
            <textarea name="message" placeholder="{{ __('util.msg') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <x-primary-button class="mt-4"> {{ __('util.chirp') }} </x-primary-button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y divide-gray-300">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                @if (! $chirp->created_at->eq($chirp->updated_at))
                                    | <small class="text-gray-500 text-sm border border-gray bg-red-200 rounded p-1 mr-1"> Modifié </small> <small class="text-gray-500">{{$chirp->updated_at->diffForHumans()}}</small> 
                                @endif

                            </div>
                            {{-- Ne s'affiche que pour les commentaires de l'utilisateur --}}
                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form action="{{route('chirps.destroy', $chirp)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            {{-- <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Supprimer') }}
                                            </x-dropdown-link> --}}
                                            <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"> 
                                                {{__('Supprimer')}} </button>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</x-app-layout>
