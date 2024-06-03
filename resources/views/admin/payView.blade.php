<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 lg:text-left leading-tight">
            {{ __('Payroll') }}
        </h2>
    </x-slot>
    <div class="py-6 lg:py-12">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">PAYROLL DETAILS</p>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('danger'))
                        <x-danger-alert />
                    @endif
                    @if ($data->isEmpty())
                        <x-info-alert />
                    @else
                        @include('partials._payroll')
                    @endif
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._log')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#search').on('input', function() {
                var inputValue = $(this).val().toUpperCase();
                $('#view tbody tr').filter(function() {
                    $(this).toggle($(this).text().indexOf(inputValue) > -1);
                });
            });
            $('#hide-column').click(function() {
                $('.hide').toggle();
            });
        })
        
    </script>
</x-app-layout>
