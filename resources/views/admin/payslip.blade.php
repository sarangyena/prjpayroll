<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 lg:text-left leading-tight">
            {{ __('Payslip') }}
        </h2>
    </x-slot>
    <div class="py-6 lg:py-12">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="border-b-2 border-green-300 font-bold text-2xl text-center lg:text-left">PAYSLIP
                        DETAILS
                    </p>
                    <div class="flex justify-between">
                        <form method="post" action="{{ route('a-payslip') }}"
                            class="flex justify-between text-nowrap mt-3">
                            @csrf
                            <div class="flex gap-3">
                                <h1 class="text-lg self-center">Pay Period:</h1>
                                <x-select-input id="week" name="week" class="w-1/9 mt-1">
                                    <option selected value="{{ isset($week) ? $week : $weeks[count($weeks) - 1] }}">
                                        {{ isset($week) ? $week : $weeks[count($weeks) - 1] }}</option>
                                    @foreach ($weeks as $w)
                                        <option value="{{ $w }}">{{ $w }}</option>
                                    @endforeach
                                </x-select-input>
                                <button type="submit"
                                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center">Generate
                                    Payslip</button>
                            </div>
                        </form>
                        <div class="flex">
                            <x-search />
                            <x-hide />
                        </div>
                    </div>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif(session('danger'))
                        <x-danger-alert />
                    @endif
                    @if ($data->isEmpty())
                        <x-info-alert />
                    @else
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="view">
                                <thead
                                    class="text-center text-nowrap text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-3 py-2">
                                            ID
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Action
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Pay Id
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Username
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Name
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Job
                                        </th>
                                        <th scope="col" class="px-3 py-2">
                                            Pay Period
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
                                                {{ $d->id }}
                                            </th>
                                            <td class="px-4 py-3 flex gap-3 justify-center">
                                                <a href="{{ route('p-payslip', $d->id) }}" id="print"
                                                    class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 mx-auto">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('a-editPay', $d->id) }}" id="edit"
                                                    class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 mx-auto">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d->pay_id }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d->user_name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d->name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d->job }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $d->pay_period }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->rate }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d->days }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d->late }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->salary }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->rph }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                {{ $d->hrs }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->otpay }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->holiday }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->sss }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->philhealth }}
                                            </td>
                                            <td class="px-4 py-3 hide" hidden>
                                                ₱ {{ $d->advance }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d->gross }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d->deduction }}
                                            </td>
                                            <td class="px-4 py-3">
                                                ₱ {{ $d->net }}
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
