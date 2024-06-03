<x-slot name="header">
    <div class="flex justify-between">
        <h2 class="self-center font-semibold text-base text-gray-800 leading-tight lg:text-xl">
            {{ __('QR Records') }}
        </h2>
        <a href="{{ Route::currentRouteName() == 'a-qrView' ? route('a-qrView') : route('u-qrView') }}"
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
                <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">QR RECORDS</p>
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
                    <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                            id="view">
                            <thead
                                class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-2">
                                        ID
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Week ID
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Username
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Name
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Role
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Job
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Timezone
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        IP Address
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Geolocation
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Login
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        Logout
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr
                                        class="text-center text-nowrap odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row"
                                            class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $d->id }}
                                        </th>
                                        <td class="px-3 py-2">
                                            {{ $d->week_id }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->user_name }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->name }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->role }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->job }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->timezone }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $d->ip }}
                                        </td>
                                        <td class="px-3 py-2 text-wrap">
                                            {{ $d->geo }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ Carbon\Carbon::parse($d->created_at)->format('F j, Y, g:i A') }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ Carbon\Carbon::parse($d->updated_at)->format('F j, Y, g:i A') }}
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
