<!-- resources/views/email-formatter/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Formatter') }}
        </h2>
    </x-slot>

    <div id="page-content" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="email-form" action="{{ route('email-formatter.preview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="to" class="block text-gray-700 text-sm font-bold mb-2">To:</label>
                            <input type="email" name="to" id="to" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject:</label>
                            <input type="text" name="subject" id="subject" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Body:</label>
                            <textarea name="body" id="body" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                            <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                            <script>
                                CKEDITOR.replace('body');
                            </script>
                        </div>
                       
                        <div class="mb-4">
                            <label for="pdfs" class="block text-gray-700 text-sm font-bold mb-2">PDF Attachments:</label>
                            <input type="file" name="pdfs[]" id="pdfs" multiple accept=".pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" id="preview-button" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Preview
                            </button>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="preview-modal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-75 backdrop-blur-sm">
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-gray-800 p-6 text-white">
                <h3 class="text-lg font-semibold mb-2">To: <span id="preview-to"></span></h3>
                <h3 class="text-lg font-semibold mb-2">Subject: <span id="preview-subject"></span></h3>
                <div class="mb-4">
                    <h4 class="text-md font-semibold mb-2">Body:</h4>
                    <div id="preview-body" class="whitespace-pre-wrap"></div>
                </div>
                <div class="mb-4">
                    <h4 class="text-md font-semibold mb-2">Attachments:</h4>
                    <ul id="preview-attachments" class="list-disc list-inside"></ul>
                </div>
                <div class="flex items-center justify-between">
                    <button id="close-preview" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Close
                    </button>
                    <button form="email-form" type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('preview-button').addEventListener('click', function() {
            document.getElementById('preview-to').innerText = document.getElementById('to').value;
            document.getElementById('preview-subject').innerText = document.getElementById('subject').value;

            // Get CKEditor content
            const editorData = CKEDITOR.instances.body.getData();
            document.getElementById('preview-body').innerHTML = editorData;
            
            const pdfInput = document.getElementById('pdfs');
            const pdfFiles = pdfInput.files;
            const attachmentsList = document.getElementById('preview-attachments');
            attachmentsList.innerHTML = '';
            for (let i = 0; i < pdfFiles.length; i++) {
                const listItem = document.createElement('li');
                listItem.textContent = pdfFiles[i].name;
                attachmentsList.appendChild(listItem);
            }

            document.getElementById('page-content').classList.add('blur');
            document.getElementById('preview-modal').classList.remove('hidden');
        });

        document.getElementById('close-preview').addEventListener('click', function() {
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('page-content').classList.remove('blur');
        });
    </script>

    <style>
        .blur {
            filter: blur(5px);
        }
    </style>
</x-app-layout>
