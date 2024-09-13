<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>
  
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('priorities.index') }}"class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Back</a>
                    <a href="{{ route('teams.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Add Team</a>
                    @if(session('success'))
                        <div id="success-message" style="background-color: #c6f6d5; border: 1px solid #9ae6b4; color: #2f855a; padding: 0.75rem 1.25rem; border-radius: 0.25rem; margin-top: 0.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="mt-4 w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td class="border px-4 py-2">{{ $team->name }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('teams.edit', $team) }}" style="color: #d69e2e; text-decoration: none; margin-right: 0.5rem;">Edit</a>
                                        <form action="{{ route('teams.destroy', $team) }}"  method="POST" style="display: inline;">
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