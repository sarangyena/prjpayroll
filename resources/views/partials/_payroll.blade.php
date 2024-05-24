<div class="flex justify-between">
    <x-search />
    <div class="flex">
        <button type="button" id="hide-column"
            class="mt-2 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-1.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"><svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 hide">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 hide" hidden>
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
        @if (Route::currentRouteName() != 'e-salary')
            <a href="{{ Route::currentRouteName() == 'a-payroll' ? route('a-all') : route('a-payroll') }}"
                class="mt-2">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </button>
            </a>
            <a href="{{ route('p-payroll', $payroll->currentPage()) }}" id="print" class="mt-2">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg></button>
            </a>
        @endif

    </div>

</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="payroll">
        <thead
            class="text-nowrap text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-5 py-2">
                    ID
                </th>
                @if (Route::currentRouteName() != 'e-salary')
                    <th scope="col" class="px-5 py-2">
                        Action
                    </th>
                @endif
                <th scope="col" class="px-5 py-2">
                    Payroll No.
                </th>
                <th scope="col" class="px-5 py-2">
                    Username
                </th>
                <th scope="col" class="px-5 py-2">
                    Week
                </th>
                <th scope="col" class="px-5 py-2">
                    Name
                </th>
                <th scope="col" class="px-5 py-2">
                    Job
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Rate
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    No. Of Days
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Late
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Salary
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Rate Per Hour
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    No. Of Hours
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    OT Pay
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Holiday
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    PhilHealth
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    SSS
                </th>
                <th scope="col" class="px-5 py-2 hide" hidden>
                    Advance
                </th>
                <th scope="col" class="px-5 py-2">
                    Gross
                </th>
                <th scope="col" class="px-5 py-2">
                    Deductions
                </th>
                <th scope="col" class="px-5 py-2">
                    Total
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payroll as $pay)
                <tr
                    class="text-nowrap text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $pay->id }}
                    </th>
                    @if (Route::currentRouteName() != 'e-salary')
                        <td class="px-5 py-2 flex gap-3">
                            <a href="{{ route('print', $pay->id) }}" id="print"
                                class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                </svg>
                            </a>
                            <a href="{{ route('a-payEdit', $pay->id) }}" id="edit"
                                class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                        </td>
                    @endif
                    <td class="px-5 py-2">
                        {{ $pay->pay_id }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->userName }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->week }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->name }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->job }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->rate }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->days }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->late }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->salary }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->rph }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->hrs }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->otpay }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->holiday }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->philhealth }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->sss }}
                    </td>
                    <td class="px-5 py-2 hide" hidden>
                        {{ $pay->advance }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->gross }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->deduction }}
                    </td>
                    <td class="px-5 py-2">
                        {{ $pay->net }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            var inputValue = $(this).val().toUpperCase();
            $('#payroll tbody tr').filter(function() {
                $(this).toggle($(this).text().indexOf(inputValue) > -1);
            });
        });
        $('#hide-column').click(function() {
            $('.hide').toggle();
        });
    })
</script>
