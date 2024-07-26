<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1a202c;">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div style="padding-top: 3rem; padding-bottom: 3rem;">
        <div style="max-width: 80rem; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.375rem;">
                <div style="padding: 1.5rem; background-color: white; border-bottom: 1px solid #e2e8f0;">
                    <a href="{{ route('employees.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Add Employee
                    </a>
                    @if(session('success'))
                        <div id="success-alert" style="background-color: #c6f6d5; border: 1px solid #9ae6b4; color: #2f855a; padding: 0.75rem 1.25rem; border-radius: 0.25rem; margin-top: 0.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div style="overflow-x: auto;">
                        <table style="min-width: 100%; border-collapse: collapse;">
                            <thead style="background-color: #f7fafc;">
                                <tr>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Name</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Email</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Phone</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Position</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Work Hours</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Grace Period</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #4a5568; text-transform: uppercase;">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr style="border-top: 1px solid #e2e8f0;">
                                        <td style="padding: 0.75rem 1rem;">{{ $employee->name }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $employee->email }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $employee->phone }}</td>
                                        <td style="padding: 0.75rem 1rem;">{{ $employee->position }}</td>
                                        <td style="padding: 0.75rem 1rem;">
                                        {{ $employee->work_start_time ? $employee->work_start_time->format('H:i') : 'N/A' }} - 
                                        {{ $employee->work_end_time ? $employee->work_end_time->format('H:i') : 'N/A' }}
                                    </td>
                                    <td style="padding: 0.75rem 1rem;">{{ $employee->grace_period_minutes }} minutes</td>
                                    <td style="padding: 0.75rem 1rem;">
                                            <a href="{{ route('employees.show', $employee->id) }}" style="color: #3182ce; text-decoration: none; margin-right: 0.5rem;">View</a>
                                            <a href="{{ route('employees.edit', $employee->id) }}" style="color: #d69e2e; text-decoration: none; margin-right: 0.5rem;">Edit</a>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;">
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
        // Hide the modal alert after 3 seconds (3000 milliseconds)
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 3000);
        });
    </script>
</x-app-layout>
