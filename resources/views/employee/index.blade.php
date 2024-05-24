<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">DASHBOARD</p>
                    <div class="columns-3 mt-3">
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <p class="text-2xl text-center border-b-2 border-green-300 mx-5">GROSS PAY</p>
                            <p class="text-4xl text-center py-10">₱ {{ $gross }}</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <p class="text-2xl text-center border-b-2 border-green-300 mx-5">DEDUCTIONS</p>
                            <p class="text-4xl text-center py-10">₱ {{ $deduction }}</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <p class="text-2xl text-center border-b-2 border-green-300 mx-5">NET PAY</p>
                            <p class="text-4xl text-center py-10">₱ {{ $net }}</p>
                        </div>
                    </div>

                    <p class="font-bold text-2xl border-b-2 border-green-300 mt-10">QR LOGIN</p>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                        @if ($qr->isEmpty())
                            <div class="flex items-center p-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">No Data to be Displayed.</span>
                                </div>
                            </div>
                        @else
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                id="payroll">
                                <thead
                                    class="text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Username
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Job
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Timezone
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            IP Address
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Geolocation
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Login
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Logout
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($qr as $data)
                                        <tr data-id="{{ $data->id }}"
                                            class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->id }}
                                            </th>
                                            <td class="px-6 py-1">
                                                {{ $data->role }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->userName }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->name }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->job }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->timezone }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->ip }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->geo }}
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ $data->created_at }}
                                            </td>
                                            @if ($data->created_at->eq($data->updated_at))
                                                <td class="px-6 py-1">

                                                </td>
                                            @else
                                                <td class="px-6 py-1">
                                                    {{ $data->updated_at }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-employee-layout>
