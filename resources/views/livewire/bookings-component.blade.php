<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    <!-- Search & Filter Header -->
    <div class="flex items-center justify-between">
        <input 
            type="text" 
            placeholder="Search bookings..." 
            class="w-full max-w-xs rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        >
        <button 
            class="ml-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Add Booking
        </button>
    </div>

    <!-- Bookings Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">1</td>
                    <td class="px-6 py-4 text-gray-900">John Doe</td>
                    <td class="px-6 py-4 text-gray-700">john@example.com</td>
                    <td class="px-6 py-4 text-gray-700">Apr 24, 2025</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-blue-600 hover:underline">View</button> |
                        <button class="text-indigo-600 hover:underline">Edit</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">2</td>
                    <td class="px-6 py-4 text-gray-900">Jane Smith</td>
                    <td class="px-6 py-4 text-gray-700">jane@example.com</td>
                    <td class="px-6 py-4 text-gray-700">Apr 25, 2025</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">Approved</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-blue-600 hover:underline">View</button> |
                        <button class="text-indigo-600 hover:underline">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination (Static for now) -->
    <div class="mt-4 flex justify-end">
        <nav class="inline-flex space-x-2">
            <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded hover:bg-gray-100">Prev</button>
            <button class="px-3 py-1 text-sm text-white bg-blue-600 border border-blue-600 rounded">1</button>
            <button class="px-3 py-1 text-sm text-gray-700 border border-gray-300 rounded hover:bg-gray-100">2</button>
            <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded hover:bg-gray-100">Next</button>
        </nav>
    </div>

</div>
