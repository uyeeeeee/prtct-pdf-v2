<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Storage;
use PhpZip\ZipFile;

class PdfProtectorController extends Controller
{
    public function index()
    {
        return view('pdf-protector');
    }

    public function protect(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'required|mimes:pdf|max:10240', // 10MB max per file
            'password' => 'required|min:6',
        ]);
    
        $password = $request->input('password');
        $protectedFiles = [];
    
        foreach ($request->file('pdfs') as $pdf) {
            $originalName = $pdf->getClientOriginalName();
            $protectedName = 'protected_' . $originalName;
    
            $fpdi = new Fpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
            $fpdi->SetProtection(['print', 'copy'], $password, null, 3);
    
            $pageCount = $fpdi->setSourceFile($pdf->getRealPath());
    
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($templateId);
            }
    
            $protectedContent = $fpdi->Output($protectedName, 'S');
    
            $protectedFiles[] = [
                'name' => $protectedName,
                'content' => $protectedContent
            ];
        }

        if (count($protectedFiles) == 1) {
            // If only one file, send it as a download with no-cache headers
            return response($protectedFiles[0]['content'])
                ->header('Content-Type', 'application/pdf')
                ->header('Cache-Control', 'no-cache, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0')
                ->header('Content-Disposition', 'attachment; filename="' . $protectedFiles[0]['name'] . '"');
        } else {
            // If multiple files, create a zip using PhpZip with no-cache headers
            $zipFile = new ZipFile();
            $zipFileName = 'protected_pdfs_' . time() . '.zip';
            $zipFilePath = storage_path('app/public/' . $zipFileName);
    
            foreach ($protectedFiles as $file) {
                $zipFile->addFromString($file['name'], $file['content']);
            }

            $zipFile->saveAsFile($zipFilePath)->close();

            return response()->download($zipFilePath, $zipFileName, [
                'Content-Type' => 'application/zip',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ])->deleteFileAfterSend(true);
        }
    }
}
