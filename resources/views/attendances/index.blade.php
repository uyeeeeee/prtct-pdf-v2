<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1a202c;">
            {{ __('Attendances') }}
        </h2>
    </x-slot>

    <div style="padding-top: 3rem; padding-bottom: 3rem;">
        <div style="max-width: 80rem; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.375rem;">
                <div style="padding: 1.5rem; background-color: white; border-bottom: 1px solid #e2e8f0;">
                    <a href="{{ route('attendances.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Add Attendance
                    </a>
                    @if(session('success'))
                        <div id="success-message" style="background-color: #c6f6d5; border: 1px solid #9ae6b4; color: #2f855a; padding: 0.75rem 1.25rem; border-radius: 0.25rem; margin-top: 0.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div style="overflow-x: auto;">
                        <table style="min-width: 100%; border-collapse: collapse;">
                            <thead style="background-color: #f7fafc;">
                                <tr>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Employee</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Date</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Check In</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Check Out</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr style="border-top: 1px solid #e2e8f0;">
                                        <td style="padding: 0.75rem 1rem;">{{ $attendance->employee->name }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $attendance->date }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $attendance->check_in }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $attendance->check_out }}</td>
                                        <td style="padding: 0.75rem 1rem;">
                                            <a href="{{ route('attendances.show', $attendance->id) }}" style="color: #3182ce; text-decoration: none; margin-right: 0.5rem;">View</a>
                                            <a href="{{ route('attendances.edit', $attendance->id) }}" style="color: #d69e2e; text-decoration: none; margin-right: 0.5rem;">Edit</a>
                                            <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" style="display: inline;">
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
    </div>

    <script>
        // Script to hide success message after 3 seconds
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>

</x-app-layout>
