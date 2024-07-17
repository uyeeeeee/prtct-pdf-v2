<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormattedEmail;

class EmailFormatterController extends Controller
{
    public function index()
    {
        return view('email-formatter.index');
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
            'pdfs' => 'required|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240', // 10MB max per file
        ]);

        $pdfs = $request->file('pdfs');
        $pdfNames = array_map(function ($pdf) {
            return $pdf->getClientOriginalName();
        }, $pdfs);

        return view('email-formatter.preview', compact('validated', 'pdfNames'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
            'pdfs' => 'required|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240', // 10MB max per file
        ]);

        $pdfs = $request->file('pdfs');

        Mail::to($validated['to'])->send(new FormattedEmail($validated['subject'], $validated['body'], $pdfs));

        return redirect()->route('email-formatter.index')->with('success', 'Email sent successfully!');
    }
}