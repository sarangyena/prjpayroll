<x-app-layout>
    <div class="py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300">SCAN QR</p>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('danger'))
                        <x-danger-alert />
                    @endif
                    <div class="mt-3 columns-2">
                        @php
                            $data1 = session()->get('data1');
                            if (!isset($data1)) {
                                $data1 = [];
                                $data1['user_name'] = '';
                                $data1['role'] = '';
                                $data1['job'] = '';
                                $data1['name'] = '';
                                $data1['image_data'] = '';
                            }
                        @endphp
                        <div class="flex flex-col">
                            <div id="reader" class="w-9/12  mx-auto"></div>
                            <x-text-input id="image" class="block mt-3 w-full uppercase" type="file"
                                name="image" accept="image/*" />
                        </div>

                        <div>
                            <form method="POST" action="{{ route('qr-store') }}" id="qrForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <img src="{{ asset('images/user.png') }}" class="w-1/3 mx-auto mt-10" id="imagePreview">
                                    <div class="columns-2 mt-3">
                                        <div>
                                            <x-input-label for="user_name" :value="__('User ID:')" />
                                            <x-text-input id="user_name" class="block mt-1 w-full uppercase"
                                                type="text" name="user_name"
                                                value="{{ old('user_name', $data1['user_name']) }}" readonly />
                                        </div>
                                        <div>
                                            <x-input-label for="role" :value="__('Role:')" />
                                            <x-text-input id="role" class="block mt-1 w-full uppercase"
                                                type="text" name="role" value="{{ old('role', $data1['role']) }}"
                                                readonly />
                                        </div>
                                        <div>
                                            <x-input-label for="job" :value="__('Job:')" />
                                            <x-text-input id="job" class="block mt-1 w-full uppercase"
                                                type="text" name="job" value="{{ old('job', $data1['job']) }}"
                                                readonly />
                                        </div>
                                        <x-input-label for="name" :value="__('Name:')" />
                                        <x-text-input id="name" class="block mt-1 w-full uppercase" type="text"
                                            name="name" value="{{ old('name', $data1['name']) }}" readonly />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
            $(document).ready(function() {
                @if ($data1['image_data'] != '')
                    var imageData = '@php $blob = $data1['image_data']; $dataUri = "data:image/jpeg;base64," . base64_encode($blob); echo $dataUri @endphp';
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = imageData;
                @endif
                
                const html5QrCode = new Html5Qrcode("reader");
                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                    html5QrCode.stop();
                    navigator.geolocation.getCurrentPosition((position) => {
                        const data = {
                            id: decodedText,
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                        };
                        const request = [
                            axios.post('qr/data',data),
                            axios.post('qr/image',data, {responseType: 'blob'}),
                            axios.post('qr/store',data),
                        ];

                        Promise.all(request)
                            .then((responses) => {
                                const data1 = responses[0].data;
                                $('#user_name').val(data1.user_name);
                                $('#role').val(data1.role);
                                $('#job').val(data1.job);
                                $('#name').val(data1.name);

                                const blobData = responses[1].data;
                                const blobUrl = URL.createObjectURL(blobData);
                                $('#imagePreview').attr('src', blobUrl);

                                const data2 = responses[2].data;
                                if(data2.add == true){
                                    var dataObject = {
                                        user_name: $('#user_name').val(),
                                        role: $('#role').val(),
                                        job: $('#job').val(),
                                        name: $('#name').val(),
                                        message: 'Successfully added record.',
                                    }
                                    var jsonData = JSON.stringify(dataObject);
                                    window.location.href = '/session?object=' + encodeURIComponent(jsonData);
                                }else if(data2.update == true){
                                    var dataObject = {
                                        user_name: $('#user_name').val(),
                                        role: $('#role').val(),
                                        job: $('#job').val(),
                                        name: $('#name').val(),
                                        message: 'Successfully updated record.',
                                    }
                                    var jsonData = JSON.stringify(dataObject);
                                    window.location.href = '/session?object=' + encodeURIComponent(jsonData);
                                }else if(data2.error == true){
                                    var dataObject = {
                                        user_name: $('#user_name').val(),
                                        role: $('#role').val(),
                                        job: $('#job').val(),
                                        name: $('#name').val(),
                                        message: 'Employee does not exist.',
                                    }
                                    var jsonData = JSON.stringify(dataObject);
                                    window.location.href = '/session?error=' + encodeURIComponent(jsonData);
                                }
                            })
                    });
                };
                const config = { fps: 20, qrbox: { width: 400, height: 400 } };
                html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);

                $('#image').change(function(e){
                    const html5QrCode = new Html5Qrcode("reader", /* verbose= */ false);
                    if (e.target.files.length == 0) {
                        // No file selected, ignore 
                        return;
                    }
                    
                    const imageFile = e.target.files[0];
                    // Scan QR Code
                    html5QrCode.scanFile(imageFile, true)
                    .then(decodedText => {

                        navigator.geolocation.getCurrentPosition((position) => {
                            const data = {
                                id: decodedText,
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                            };
                            const request = [
                                axios.post('qr/data',data),
                                axios.post('qr/image',data, {responseType: 'blob'}),
                                axios.post('qr/store',data),
                            ];
                            Promise.all(request)
                                .then((responses) => {
                                    const data1 = responses[0].data;
                                    $('#user_name').val(data1.user_name);
                                    $('#role').val(data1.role);
                                    $('#job').val(data1.job);
                                    $('#name').val(data1.name);

                                    const blobData = responses[1].data;
                                    const blobUrl = URL.createObjectURL(blobData);
                                    $('#imagePreview').attr('src', blobUrl);

                                    const data2 = responses[2].data;
                                    if(data2.add == true){
                                        var dataObject = {
                                            user_name: $('#user_name').val(),
                                            role: $('#role').val(),
                                            job: $('#job').val(),
                                            name: $('#name').val(),
                                            message: 'Successfully added record.',
                                        }
                                        var jsonData = JSON.stringify(dataObject);
                                        window.location.href = '/session?object=' + encodeURIComponent(jsonData);
                                    }else if(data2.update == true){
                                        var dataObject = {
                                            user_name: $('#user_name').val(),
                                            role: $('#role').val(),
                                            job: $('#job').val(),
                                            name: $('#name').val(),
                                            message: 'Successfully updated record.',
                                        }
                                        var jsonData = JSON.stringify(dataObject);
                                        window.location.href = '/session?object=' + encodeURIComponent(jsonData);
                                    }else if(data2.error == true){
                                        var dataObject = {
                                            user_name: $('#user_name').val(),
                                            role: $('#role').val(),
                                            job: $('#job').val(),
                                            name: $('#name').val(),
                                            message: 'Employee does not exist.',
                                        }
                                        var jsonData = JSON.stringify(dataObject);
                                        window.location.href = '/session?error=' + encodeURIComponent(jsonData);
                                    }
                                })
                        });
                    })
                    .catch(err => {
                        // failure, handle it.
                        console.log(`Error scanning file. Reason: ${err}`)
                    });
                });
            })
            
        </script>
</x-app-layout>
