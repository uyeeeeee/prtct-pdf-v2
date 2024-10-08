<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weekly Priorities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ route('teams.index') }}"class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Manage teams</a>
                <a href="{{ route('weekly-maintenance.index') }}"class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Weekly Maintenance</a>   
                @if(session('success'))
                        <div id="success-message" style="background-color: #c6f6d5; border: 1px solid #9ae6b4; color: #2f855a; padding: 0.75rem 1.25rem; border-radius: 0.25rem; margin-top: 0.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Timeline</th>
                                    <th class="px-4 py-2">Green</th>
                                    <th class="px-4 py-2">Yellow</th>
                                    <th class="px-4 py-2">Red</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Team</th>
                                    <th class="px-4 py-2">Weekly Maintenance</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($priorities as $priority)
                                <tr>
                                    <form action="{{ route('priorities.update', $priority) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="border px-4 py-2">
                                            <input type="text" name="description" value="{{ $priority->description }}" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" name="timeline" value="{{ $priority->timeline }}" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="green" value="{{ $priority->green }}" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="yellow" value="{{ $priority->yellow }}" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="red" value="{{ $priority->red }}" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <textarea name="status" class="w-full">{{ $priority->status }}</textarea>
                                        </td>
                                        <td class="border px-4 py-2" style="min-width: 200px;">
                                            <select name="team_id" class="w-full">
                                                @foreach($teams as $team)
                                                    <option value="{{ $team->id }}" {{ $priority->team_id == $team->id ? 'selected' : '' }}>
                                                        {{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <select name="weekly_maintenance_id" class="w-full">
                                                <option value="">None</option>
                                                @foreach($weeklyMaintenances as $maintenance)
                                                    <option value="{{ $maintenance->id }}" {{ $priority->weekly_maintenance_id == $maintenance->id ? 'selected' : '' }}>
                                                        Week {{ $maintenance->week_number }} ({{ $maintenance->date_from->format('Y-m-d') }} - {{ $maintenance->date_to->format('Y-m-d') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="submit"style="color: #d69e2e; text-decoration: none; margin-right: 0.5rem;">Update</a>
                                    </form>
                                    <form action="{{ route('priorities.destroy', $priority) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #e53e3e; background: none; border: none; cursor: pointer; font-size: 1rem;" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <form action="{{ route('priorities.store') }}" method="POST">
                                        @csrf
                                        <td class="border px-4 py-2">
                                            <input type="text" name="description" placeholder="New description" class="w-full" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" name="timeline" class="w-full" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="green" placeholder="Green" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="yellow" placeholder="Yellow" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="red" placeholder="Red" class="w-full">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <textarea name="status" placeholder="Status" class="w-full" required></textarea>
                                        </td>
                                        <td class="border px-4 py-2">
                                        <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    @if($teams->isEmpty())
        <option value="">No teams available</option>
    @else
        @foreach($teams as $team)
            <option value="{{ $team->id }}">{{ $team->name }}</option>
        @endforeach
    @endif
</select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <select name="weekly_maintenance_id" class="w-full">
                                                <option value="">None</option>
                                                @foreach($weeklyMaintenances as $maintenance)
                                                    <option value="{{ $maintenance->id }}">
                                                        Week {{ $maintenance->week_number }} ({{ $maintenance->date_from->format('Y-m-d') }} - {{ $maintenance->date_to->format('Y-m-d') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="submit" style="color: #0000FF; text-decoration: none; margin-right: 0.5rem;">Add This Row</button>
                                        </td>
                                    </form>
                                </tr>
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