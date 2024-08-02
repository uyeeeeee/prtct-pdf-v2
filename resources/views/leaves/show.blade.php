<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label for="employee" class="block text-sm font-medium text-gray-700">Employee</label>
                        <input type="text" name="employee" id="employee" class="mt-1 block w-full" value="{{ $leave->employee->name }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full" value="{{ $leave->start_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full" value="{{ $leave->end_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="reason" id="reason" class="mt-1 block w-full" disabled>{{ $leave->reason }}</textarea>
                    </div>
                    <a href="{{ route('leaves.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Back to Leave List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
