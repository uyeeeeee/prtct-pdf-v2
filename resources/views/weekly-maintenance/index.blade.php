<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weekly Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('weekly-maintenance.store') }}" method="POST" class="mb-4">
                        @csrf
                        <table class="w-full">
                            <tr>
                                <td class="font-bold">Week Number</td>
                                <td>
                                    <input type="number" name="week_number" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-bold">Date From</td>
                                <td>
                                    <input type="date" name="date_from" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-bold">Date To</td>
                                <td>
                                    <input type="date" name="date_to" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                </td>
                            </tr>
                        </table>
                        <div class="flex justify-between">
                            
                            <a href="{{ route('priorities.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Back</a>
                       
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Add Weekly Maintenance
                            </button>
                        </div>
                    </form>

                    <table class="w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Week Number</th>
                                <th class="px-4 py-2 text-left">Date From</th>
                                <th class="px-4 py-2 text-left">Date To</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeklyMaintenances as $maintenance)
                                <tr>
                                    <form action="{{ route('weekly-maintenance.update', $maintenance) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="border px-4 py-2">
                                            <input type="number" name="week_number" value="{{ $maintenance->week_number }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" name="date_from" value="{{ $maintenance->date_from->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" name="date_to" value="{{ $maintenance->date_to->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="submit" style="color: #d69e2e; text-decoration: none; margin-right: 0.5rem;">Update</button>
                                    </form>
                                    <form action="{{ route('weekly-maintenance.destroy', $maintenance) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #e53e3e; background: none; border: none; cursor: pointer; font-size: 1rem;" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>