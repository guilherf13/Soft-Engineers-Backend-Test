<?php

namespace App\Http\Controllers;

use App\Imports\DebtImport;
use Illuminate\Http\Request;
use App\Jobs\ProcessarDebitosJob;
use Maatwebsite\Excel\Facades\Excel;

class DebtController extends Controller
{
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls,txt',
        ]);

        try {
            $file = $request->file('file');

            // Coloca a importação na fila
            Excel::queueImport(new DebtImport, $file);

            //Coloca o envio de boletos e emails na fila
            ProcessarDebitosJob::dispatch();

            // Retorna uma resposta informativa
            return response()->json([
                'message' => 'Arquivo importado e processamento iniciado com sucesso.',
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao importar o arquivo.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}

