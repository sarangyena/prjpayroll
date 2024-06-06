<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="self-center font-semibold text-base text-gray-800 leading-tight lg:text-xl">
                {{ __('Add Employee') }}
            </h2>
            <a href="{{route('a-empView')}}">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-1 text-center lg:px-5 lg:py-2.5">Employee Details</button>
            </a>
        </div>
    </x-slot>
    
    <div class="py-6">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">PERSONAL DETAILS</p>
                    @if (session('danger'))
                        <x-danger-alert />
                    @endif
                    @include('partials._emp')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            var userId = document.getElementById("user_name");
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
            // EMPLOYEE
            $('#emp').change(function() {
                if ($(this).is(':checked')) {
                    const data = {
                        role: 'EMPLOYEE'
                    };
                    axios.post('username', data)
                        .then(response => {
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
            $('#eAddC').change(function(){
                if ($(this).is(':checked')) {
                    $('#eAdd').val($('#address').val());

                }else{
                    $('#eAdd').val('');
                }
            })
        })
    </script>
</x-app-layout>
