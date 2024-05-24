<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl my-auto text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employee') }}
            </h2>
            <a href="{{ route('a-view') }}"><button type="button"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2 text-center me-2">VIEW
                    EMPLOYEES</button></a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">ADD EMPLOYEE</p>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('error'))
                        <x-danger-alert />
                    @endif
                    @include('partials._emp')
                </div>
            </div>
        </div>
    </div>
    <!-- Log Timeline-->
    @include('partials._log')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            //Image Preview
            $('#image').change(function(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').show();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            //Convert to Uppercase
            $('#empForm input[type="text"]').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
            $('#empForm input[type="email"]').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
            // EMPLOYEE
            $('#emp').change(function() {
                if ($(this).is(':checked')) {
                    const data = {
                        role: 'EMPLOYEE'
                    };
                    axios.post('username', data)
                        .then(response => {
                            var userId = document.getElementById("userName");
                            userId.value = response.data;
                            // Handle successful response
                        })
                        .catch(error => {
                            console.error(error.response.data);
                            // Handle error
                        });
                }
            });
            // ON-CALL
            $('#on').change(function() {
                if ($(this).is(':checked')) {
                    const data = {
                        role: 'ON-CALL'
                    };
                    axios.post('username', data)
                        .then(response => {
                            var userId = document.getElementById("userName");
                            userId.value = response.data;
                            // Handle successful response
                        })
                        .catch(error => {
                            console.error(error.response.data);
                            // Handle error
                        });
                }
            });
            //Clear Form
            $('#clear').click(function() {
                $('#empForm')[0].reset();
                $("#imagePreview").attr("src", "{{ asset('images/user.png') }}");
            })
        })
    </script>
</x-admin-layout>
