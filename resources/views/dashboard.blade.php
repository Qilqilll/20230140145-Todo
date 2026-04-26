<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <div class="mt-2 text-sm font-medium text-gray-400">
                        Role: {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
