<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 lg:text-left leading-tight">
            {{ __('Generate Payroll') }}
        </h2>
    </x-slot>
    <div class="py-6 lg:py-12">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">GENERATE PAYROLL
                    </p>
                    <div class="lg:flex lg:justify-between">
                        <form method="post" action="{{ route('a-payroll') }}" class="flex gap-5 mt-3">
                            @csrf
                            <x-date-range />
                            <button type="submit"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </form>
                        <div class="flex justify-between mt-2 lg: gap-3" id="export">
                            <a href="{{route('p-payroll')}}" class="">
                                <x-export />
                            </a>    
                            <x-hide />
                        </div>
                    </div>
                    @if (Cache::get('data'))
                        @php
                            $data = Cache::get('data');
                        @endphp
                    @endif
                    @if (session('success'))
                        <x-success-alert />
                    @elseif(session('danger'))
                        <x-danger-alert />
                    @endif
                    @if ($data == null)
                        <x-info-alert />
                    @else
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                id="view">
                                <thead
                                    class="text-center text-nowrap text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-3 py-2">
                                            Username
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Date Hired
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Name
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Job
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Payroll Period
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Rate
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Days
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Late
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Salary
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Rate Per Hour
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            No. of Hours
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Overtime Pay
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Holiday
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            SSS
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Philhealth
                                        </th>
                                        <th scope="col" class="px-3 py-2 hide" hidden>
                                            Advance
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Gross
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Deductions
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Net Pay
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr
                                            class="text-center text-nowrap odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $d['user_name'] }}
                                            </th>
                                            <td class="px-4 py-3">
                                                {{ $d['hired'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d['name'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d['job'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d['pay_period'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['rate'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d['days'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d['late'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['salary'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['rph'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d['ot'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['otpay'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['holiday'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['sss'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['philhealth'] }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d['advance'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d['gross'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d['deductions'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d['net'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            if ($('#view tbody tr').length < 1) {
                $('#export').hide();
            }
            $('#search').on('input', function() {
                var inputValue = $(this).val().toUpperCase();
                $('#view tbody tr').filter(function() {
                    $(this).toggle($(this).text().indexOf(inputValue) > -1);
                });
            });
            $('#week').change(function (){
                var data = $(this).val();
                window.location.href = '/payslip?data=' + encodeURIComponent(JSON.stringify(data));
            })
            $('#hide-column').click(function() {
                $('.hide').toggle();
            });
        })
        
    </script>
</x-app-layout>
