<x-qr-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl my-auto text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('QR') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">SCAN QR</p>
                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('danger'))
                        <x-danger-alert />
                    @endif

                    @php
                        $user = session()->get('data');
                        if (!isset($user)) {
                            $user = [];
                            $user['userName'] = '';
                            $user['role'] = '';
                            $user['job'] = '';
                            $user['name'] = '';
                            $user['image_data'] = '';
                        }
                    @endphp
                    <div class="mt-3 columns-2">
                        <video id="preview" class="w-80 mx-auto"></video>
                        <div>
                            <form method="POST" action="{{ route('qr-store') }}" id="qrForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <img src="{{ asset('images/user.png') }}" class="w-24 mx-auto" id="imagePreview">
                                    <div class="columns-2 mt-3">
                                        <div>
                                            <x-input-label for="userName" :value="__('User ID:')" />
                                            <x-text-input id="userName" class="block mt-1 w-full uppercase"
                                                type="text" name="userName"
                                                value="{{ old('userName', $user['userName']) }}" readonly />
                                        </div>
                                        <div>
                                            <x-input-label for="role" :value="__('Role:')" />
                                            <x-text-input id="role" class="block mt-1 w-full uppercase"
                                                type="text" name="role" value="{{ old('role', $user['role']) }}"
                                                readonly />
                                        </div>
                                        <div>
                                            <x-input-label for="job" :value="__('Job:')" />
                                            <x-text-input id="job" class="block mt-1 w-full uppercase"
                                                type="text" name="job" value="{{ old('job', $user['job']) }}"
                                                readonly />
                                        </div>
                                        <x-input-label for="name" :value="__('Name:')" />
                                        <x-text-input id="name" class="block mt-1 w-full uppercase" type="text"
                                            name="name" value="{{ old('name', $user['name']) }}" readonly />
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <p class="font-bold text-2xl border-b-2 border-green-300">QR LOGIN</p>
                    @if (!isset($qr) || $qr->isEmpty())
                        <x-info-alert />
                    @else
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                            @include('partials._qr')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            @if ($user['image_data'] != '')
                var imageData = '@php $blob = $user['image_data']; $dataUri = "data:image/jpeg;base64," . base64_encode($blob); echo $dataUri @endphp';
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = imageData;
            @endif
            

            let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
            Instascan.Camera.getCameras().then(function(cameras){
                if(cameras.length > 0){
                    scanner.start(cameras[0]);
                }else{
                    alert('No Cameras Found.');
                }
            }).catch(function(e){
                console.error(e);
            });

            scanner.addListener('scan', function(content) {
                console.log(content);
                navigator.geolocation.getCurrentPosition((position) => {
                    const data = {
                        id: content,
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    };
                    const request = [
                        axios.post('qr/find',data),
                        axios.post('qr/image',data, {responseType: 'blob'}),
                        axios.post('qr/check', data),
                    ];
                    Promise.all(request)
                        .then(responses => {
                            const data1 = responses[0].data;
                            const data3 = responses[2].data;
                            $('#userName').val(data1.userName);
                            $('#role').val(data1.role);
                            $('#job').val(data1.job);
                            $('#name').val(data1.name);

                            const blobData = responses[1].data;
                            const blobUrl = URL.createObjectURL(blobData);
                            $('#imagePreview').attr('src', blobUrl);

                            var form = $('#qrForm');
                            if(data3.check == 'login' || data3.check == 'null'){
                                form.attr('action', '{{route('qr-store')}}');
                                form.submit();
                            }else if(data3.check == 'logout'){
                                form.attr('action', '{{route('qr-update')}}');
                                form.append('<input type="hidden" name="_method" value="PATCH">');
                                form.submit();
                            }
                        })
                    })
                });
            })
    </script>
</x-qr-layout>
