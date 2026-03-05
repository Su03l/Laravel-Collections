<x-app-layout>
    <x-slot name="header">
        <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2" dir="ltr">// SETTINGS</p>
        <h2 class="text-4xl font-black tracking-tighter uppercase">الملف الشخصي</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-0">
        <div class="border-4 border-black p-8 lg:p-10">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="border-4 border-black border-t-0 p-8 lg:p-10">
            @include('profile.partials.update-password-form')
        </div>

        <div class="border-4 border-black border-t-0 p-8 lg:p-10">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>