<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PDF Protector') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="pdfProtectorForm" action="{{ url('/pdf-protector') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="pdfs" class="block font-medium text-sm text-gray-700">{{ __('Select PDFs') }}</label>
                            <input id="pdfs" class="block mt-1 w-full" type="file" name="pdfs[]" required multiple accept=".pdf">
                        </div>

                        <div class="mt-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                            <input id="password" class="block mt-1 w-full" type="password" name="password" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                                {{ __('Protect and Download PDFs') }}
                            </button>
                        </div>
                    </form>
                    <script>
                        document.getElementById('pdfProtectorForm').addEventListener('submit', function() {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000); // adjust the delay to your needs
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

   
</x-app-layout>