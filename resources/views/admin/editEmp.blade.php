<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="self-center font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Employee') }}
            </h2>
            <a href="{{ route('a-empView') }}">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Cancel</button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300">EDIT EMPLOYEE</p>
                    @if (session('danger'))
                        <x-danger-alert />
                    @endif
                    @include('partials._emp')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            var userId = document.getElementById("user_name");
            var temp = userId.value;
            var imageName = '@php echo $image->image_name; @endphp';
                    var imageData = '@php $blob = $image->image_data; $dataUri = "data:image/jpeg;base64," . base64_encode($blob); echo $dataUri @endphp';
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = imageData;
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
            $('#promote').change(function() {
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
                } else {
                    userId.value = temp;
                }
            });
        });
    </script>
</x-app-layout>
