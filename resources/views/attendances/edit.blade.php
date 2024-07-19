<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                            <select name="employee_id" id="employee_id" class="mt-1 block w-full" required>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == $attendance->employee_id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full" value="{{ $attendance->date }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="check_in" class="block text-sm font-medium text-gray-700">Check In</label>
                            <input type="time" name="check_in" id="check_in" class="mt-1 block w-full" value="{{ $attendance->check_in }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="check_out" class="block text-sm font-medium text-gray-700">Check Out</label>
                            <input type="time" name="check_out" id="check_out" class="mt-1 block w-full" value="{{ $attendance->check_out }}">
                        </div>
                        <div class="flex justify-between mt-6">
                        <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
    Cancel
</a>
<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
    Update
</button>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
