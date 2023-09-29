<x-app-layout>
    {{-- @php
        $message = "Vous n'avez pas saisi le nom d'utilisateur";
    @endphp


<x-alert :color="'bg-green-500'" :message="$message"/>
<x-alert :color="'bg-red-500'" :message="'Ce champs est requis'"/> --}}
<div class="text-white">
    <a href="{{route('change.language', 'fr')}}">Français</a> | <a href="{{route('change.language', 'en')}}">Anglais</a> 
</div>
<x-card>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus magnam temporibus ratione consectetur excepturi sit facere odit reiciendis dolores, at minima exercitationem ea aliquam maxime quod? Sint quas omnis cupiditate.</p>
</x-card>

    <div class="max-w-2x1 mx-auto p-4 sm:p-6 lg:p-8">
        <form action="{{route('chirps.store')}}" method="post">
            @csrf
            <textarea name="message" placeholder="{{ __('util.msg')}}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{old('message')}}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2"/>

            <x-primary-button class="mt-4"> {{__('util.chirp')}} </x-primary-button>
        </form>
    </div>

</x-app-layout>