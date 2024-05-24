<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payroll') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">PAYROLL</p>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('error'))
                        <x-danger-alert />
                    @endif
                    @if ($payroll->isEmpty())
                        <x-info-alert />
                    @else
                        @include('partials._payroll')
                    @endif
                    @if (!$payroll->isEmpty())
                        <div class="mt-4">
                            {{ $payroll->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials._log')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-admin-layout>
