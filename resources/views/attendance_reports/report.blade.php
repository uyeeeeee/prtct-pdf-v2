<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company-wide Attendance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <div>
                <a href="{{ route('attendance-reports.export') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-100 transition ease-in-out duration-150">
    Export to Excel
</a>


                            <a href="{{ route('attendance-reports.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Export to PDF
                            </a>
                        </div>
                    <h3 class="text-lg font-semibold mb-4">Report Summary</h3>
                   
                    <p>Total Employees: {{ $summary['total_employees'] }}</p>
                    <p>Period: {{ $summary['start_date'] }} to {{ $summary['end_date'] }}</p>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                                
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reportData as $employeeId => $data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['present'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['late'] }}</td>
                                   
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['missing'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>