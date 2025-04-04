<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;

class TngImportController extends Controller
{
    public function showForm()
    {
        return view('tng.upload');
    }

    public function parse(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240'
        ]);

        // Parse PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('pdf_file')->getRealPath());
        $text = $pdf->getText();

        // Break into lines and initialize
        $lines = explode("\n", $text);
        $transactions = [];
        $currentBlock = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '')
                continue;

            $currentBlock[] = $line;

            // Detect end of a transaction: amount + balance format
            if (preg_match('/RM[\d.,]+\s+RM[\d.,]+/', $line)) {
                $date = null;
                $type = null;
                $description = null;
                $amount = null;
                $direction = 'outcome';

                // Extract amount from line
                if (preg_match('/RM([\d.,]+)\s+RM[\d.,]+/', $line, $amountMatches)) {
                    $amount = (float) str_replace(',', '', $amountMatches[1]);
                }

                // Extract date and type
                foreach ($currentBlock as $bLine) {
                    if (!$date && preg_match('/(\d{1,2}\/\d{1,2}\/\d{4})/', $bLine, $dateMatch)) {
                        $date = Carbon::createFromFormat('j/n/Y', $dateMatch[1])->format('Y-m-d');
                    }

                    if (!$type && (str_contains($bLine, 'PayDirect') || str_contains($bLine, 'DuitNow'))) {
                        // $type = $bLine;
                        $type = str_contains($bLine, 'PayDirect') ? 'PayDirect' : 'DuitNow QR';
                    }

                    if (
                        !$type && (str_contains($bLine, 'RECEI') || str_contains($bLine, 'Recei') ||str_contains($bLine, 'Reversed' ))
                    ) {
                        $direction = 'income';
                    }
                }

                // Description: skip if first line is the date/type
                $firstLine = $currentBlock[0];
                if (!$description && count($currentBlock) > 5) {
                    $line = $currentBlock[5];
                    $description = $currentBlock[5];
                    // If the line contains letters (A–Z), we keep only the lettered part before any long digits
                    if (preg_match('/^([A-Za-z\s&\-\.]+)(?=\s\d{10,})?/', $line, $matches)) {
                        $description = trim($matches[1]); // Extract merchant name part
                    }
                }
                // Add transaction
                if ($date && $amount !== null) {
                    $transactions[] = [
                        'date' => $date,
                        'type' => $type ?? 'Payment',
                        'description' => $description,
                        'amount' => $amount, // float — format in Blade
                        'direction' => $direction,
                    ];
                }

                // Reset for next transaction
                $currentBlock = [];
            }
        }

        return view('tng.result', compact('transactions'));
    }
}
