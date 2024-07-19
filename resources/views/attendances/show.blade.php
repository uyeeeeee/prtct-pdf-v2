<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label for="employee" class="block text-sm font-medium text-gray-700">Employee</label>
                        <input type="text" name="employee" id="employee" class="mt-1 block w-full" value="{{ $attendance->employee->name }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full" value="{{ $attendance->date }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="check_in" class="block text-sm font-medium text-gray-700">Check In</label>
                        <input type="time" name="check_in" id="check_in" class="mt-1 block w-full" value="{{ $attendance->check_in }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="check_out" class="block text-sm font-medium text-gray-700">Check Out</label>
                        <input type="time" name="check_out" id="check_out" class="mt-1 block w-full" value="{{ $attendance->check_out }}" disabled>
                    </div>
                    <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
    Back to Attendance List
</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
