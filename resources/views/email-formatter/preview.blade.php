<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Preview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">To: {{ $validated['to'] }}</h3>
                    <h3 class="text-lg font-semibold mb-2">Subject: {{ $validated['subject'] }}</h3>
                    <div class="mb-4">
                     <h4 class="text-md font-semibold mb-2">Body:</h4>
                    <div id="preview-content" class="ck-content">{!! $validated['body'] !!}</div>
                        </div>
                    <div class="mb-4">
                        <h4 class="text-md font-semibold mb-2">Attachments:</h4>
                        <ul class="list-disc list-inside">
                            @foreach($pdfNames as $pdfName)
                                <li>{{ $pdfName }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <form action="{{ route('email-formatter.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="to" value="{{ $validated['to'] }}">
                        <input type="hidden" name="subject" value="{{ $validated['subject'] }}">
                        <input type="hidden" name="body" value="{{ $validated['body'] }}">
                        @foreach($validated['pdfs'] as $key => $pdf)
                            <input type="hidden" name="pdfs[]" value="{{ $pdf }}">
                        @endforeach
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
    /* Base styles for CKEditor content */
    .ck-content {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        word-wrap: break-word;
    }

    /* Headings */
    .ck-content h1 { font-size: 2em; }
    .ck-content h2 { font-size: 1.5em; }
    .ck-content h3 { font-size: 1.3em; }
    .ck-content h4 { font-size: 1em; }
    .ck-content h5 { font-size: 0.8em; }
    .ck-content h6 { font-size: 0.7em; }
    
    /* Paragraph spacing */
    .ck-content p { margin-bottom: 1em; }

    /* Lists */
    .ck-content ul, .ck-content ol { margin-left: 2em; margin-bottom: 1em; }
    .ck-content li { margin-bottom: 0.5em; }

    /* Links */
    .ck-content a { color: #0000FF; text-decoration: underline; }

    /* Tables */
    .ck-content table { border-collapse: collapse; margin-bottom: 1em; }
    .ck-content table td, .ck-content table th { border: 1px solid #ccc; padding: 0.4em; }

    /* Images */
    .ck-content img { max-width: 100%; height: auto; }

    /* Blockquotes */
    .ck-content blockquote { 
        margin-left: 2em; 
        margin-right: 2em; 
        font-style: italic; 
        border-left: 5px solid #ccc;
        padding-left: 1em;
    }

    /* Code blocks */
    .ck-content pre { 
        background-color: #f0f0f0; 
        padding: 1em; 
        border-radius: 4px; 
        font-family: monospace;
    }

    /* Inline code */
    .ck-content code { 
        background-color: #f0f0f0; 
        padding: 0.2em 0.4em; 
        border-radius: 4px; 
        font-family: monospace;
    }
</style>
</x-app-layout>
