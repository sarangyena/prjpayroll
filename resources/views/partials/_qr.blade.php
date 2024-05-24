<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    <th scope="row" class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
</div>
