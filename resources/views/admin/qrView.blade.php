<x-app-layout>
    @include('partials._log')

    <div class="py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-bold text-2xl border-b-2 border-green-300">QR RECORDS</p>
                    @if ($data->isEmpty())
                        <x-info-alert />
                    @else
                        <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$d->id}}
                                            </th>
                                            <td class="px-4 py-3">
                                                {{$d->week_id}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->user_name}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->name}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->role}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->job}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->timezone}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->ip}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->geo}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->created_at}}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{$d->updated_at}}
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
</x-app-layout>
