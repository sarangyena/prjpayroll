<x-qr-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View QR Logins') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">QR LOGINS</p>
                    @if ($qr->isEmpty())
                        <x-info-alert />
                    @else
                        @include('partials._qr')
                    @endif
                    <div class="mt-4">
                        {{ $qr->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-qr-layout>
