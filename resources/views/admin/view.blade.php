<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl my-auto text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employee') }}
            </h2>
            <a href="{{ route('a-employee') }}"><button type="button"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2 text-center me-2">ADD
                    EMPLOYEES</button></a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">EMPLOYEE DETAILS</p>

                    @if (session('success'))
                        <x-success-alert />
                    @elseif (session('danger'))
                        <x-danger-alert />
                    @endif
                    @if ($employees->isEmpty())
                        <x-info-alert />
                    @else
                        <div class="flex justify-between">
                            <x-search />
                            <button type="button" id="hide-column"
                                class="mt-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-1.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hide">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hide" hidden>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                id="view">
                                <thead
                                    class="text-nowrap text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-5 py-2">
                                            ID
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Actions
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Date Hired
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Role
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Username
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Name
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Email
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Phone No.
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Job
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            Status
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            SSS
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            PhilHealth
                                        </th>
                                        <th scope="col" class="px-5 py-2">
                                            Address
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            eName
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            ePhone
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            eAddress
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide">
                                            isActive
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            Created By
                                        </th>
                                        <th scope="col" class="px-5 py-2 hide" hidden>
                                            Edited By
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr data-id="{{ $employee->id }}"
                                            class="text-nowrap text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $employee->id }}
                                            </th>
                                            <td class="px-5 py-2 flex gap-3">
                                                <a href="{{ route('a-edit', $employee->id) }}" id="edit"
                                                    class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 mx-auto">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('a-delete', $employee->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <a href="#" id="edit"
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-5 h-5 mx-auto">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </a>
                                                </form>
                                                <a href="{{ route('a-qr', $employee->id) }}" id="qr"
                                                    class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 mx-auto">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->created_at->toDateString() }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->role }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->userName }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->name }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->email }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->phone }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->job }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->status }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->sss }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->philhealth }}
                                            </td>
                                            <td class="px-5 py-2">
                                                {{ $employee->address }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->eName }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->ePhone }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->eAdd }}
                                            </td>
                                            <td class="px-5 py-2 hide">
                                                {{ $employee->eStatus }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->created_by }}
                                            </td>
                                            <td class="px-5 py-2 hide" hidden>
                                                {{ $employee->edited_by }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="mt-4">
                        {{ $employees->links() }}
                    </div>
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
        $(document).ready(function(){
            $('#search').on('input', function() {
                var inputValue = $(this).val().toUpperCase();
                $('#view tbody tr').filter(function() {
                    $(this).toggle($(this).text().indexOf(inputValue) > -1);
                });
            });
            $('#hide-column').click(function() {
                $('.hide').toggle();
            });


            
        })
        function getFilenameFromContentDisposition(contentDisposition) {
            const matches = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
            if (matches && matches[1]) {
                return decodeURIComponent(matches[1]);
            }
            return 'download';
        }
        
    </script>
</x-admin-layout>
