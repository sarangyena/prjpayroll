<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="self-center font-semibold text-base text-gray-800 leading-tight lg:text-xl">
                {{ __('Logs') }}
            </h2>
            <a href="{{route('a-logs')}}"
                class="self-center">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-1 text-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>
            </a>
        </div>
    </x-slot>
    <div class="py-6 lg:py-12">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">LOGS</p>
                    <div class="lg:flex  lg:justify-between">
                        <x-search />
                        <div class="flex">
                            <select id="dateType"
                                class="self-center w-1/2 p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="date">By Specific Date:</option>
                                <option value="range">Ranged Date:</option>
                            </select>
                            <x-date-picker />
                            <x-date-range />
                        </div>
                    </div>
                    @if ($data->isEmpty())
                        <x-info-alert />
                    @else
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                            <table id="view" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Username
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Log
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created At
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr
                                            class="text-nowrap odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $d->id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ App\Models\User::where('id', $d->user_id)->first()->user_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $d->title }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $d->log }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $d->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#r').hide();
            $('#search').on('input', function() {
                var inputValue = $(this).val().toUpperCase();
                $('#view tbody tr').filter(function() {
                    $(this).toggle($(this).text().indexOf(inputValue) > -1);
                });
            });
            $('.datepicker-picker').click(function() {
                if($('#dateType').val() == 'range'){
                    if($('#start').val() != $('#end').val()){
                        var data = [
                            $('#start').val(),
                            $('#end').val(),
                        ] 
                        window.location.href = '/logs?range=' + encodeURIComponent(JSON.stringify(data));
                    }
                }else if($('#dateType').val() == 'date'){
                    if($('#date').val() != ''){
                        var date = $('#date').val();
                        window.location.href = '/logs?date=' + encodeURIComponent(date);                    
                    }
                    
                }
            });
            $('#dateType').on('change', function() {
                var val = $(this).val();
                if(val == 'date'){
                    $('#dateType').removeClass('w-1/4');
                    $('#dateType').addClass('w-1/2');
                    $('#r').hide();
                    $('#d').show();
                }else if(val == 'range'){
                    $('#dateType').removeClass('w-1/3');
                    $('#dateType').addClass('w-1/4');
                    $('#d').hide();
                    $('#r').show();
                }
            });
        });
    </script>
</x-app-layout>
