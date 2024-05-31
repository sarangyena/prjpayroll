<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300">PAYROLL</p>
                    <div class="columns-3 mt-3">
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <div class="flex justify-center gap-3 border-b-2 pb-3 mx-5 border-green-300">
                                <p class="text-xl text-center self-center">TOTAL PAYROLL</p>
                                <select id="month"
                                    class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>THIS MONTH</option>
                                    @foreach ($data['mNames'] as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <p class="text-4xl text-center py-10" id="m">₱ {{ $data['month'] }}</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <div class="flex justify-center gap-3 border-b-2 pb-3 mx-5 border-green-300">
                                <p class="text-xl text-center self-center">TOTAL PAYROLL</p>
                                <select id="year"
                                    class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>THIS YEAR</option>
                                    @foreach ($data['y'] as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-4xl text-center py-10" id="y">₱ {{ $data['year'] }}</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <p class="text-xl text-center border-b-2 pb-1 border-green-300 mx-5">CURRENT PERIOD</p>
                            <p class="text-4xl text-center py-12">{{ $data['weekId'] }} Period</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript">
            $(document).ready(function() {
                $('#drawer-example').click(function(){
                    console.log('success');
                })
                $('#month').change(function() {
                    const data = {
                        month: $(this).val()
                    };
                    axios.post('empMonth', data)
                        .then(response => {
                            $('#m').text('₱ ' + response.data);
                        })
                        .catch(error => {
                            console.error(error.response.data);
                        });
                    
                });
                $('#year').change(function() {
                    const data = {
                        year: $(this).val()
                    };
                    axios.post('empYear', data)
                        .then(response => {
                            $('#y').text('₱ ' + response.data);
                        })
                        .catch(error => {
                            console.error(error.response.data);
                        });
                    
                });
            })
        </script>
</x-app-layout>
