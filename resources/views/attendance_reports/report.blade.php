<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Report for {{ $startDate }} to {{ $endDate }}</h3>
                    
                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Summary</h4>
                        <p>Present: {{ $summary['present'] }}</p>
                        <p>Late: {{ $summary['late'] }}</p>
                        <p>Absent: {{ $summary['absent'] }}</p>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($attendances as $attendance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->employee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($attendance->status) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>