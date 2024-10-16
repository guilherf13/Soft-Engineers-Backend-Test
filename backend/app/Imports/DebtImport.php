<?php

namespace App\Imports;

use App\Models\Debt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class DebtImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithSkipDuplicates, WithBatchInserts
{
    public function model(array $row)
    {
        try {
            return new Debt([
                'name' => $row['name'],
                'governmentId' => $row['governmentid'],
                'email' => $row['email'],
                'debtAmount' => $row['debtamount'],
                'debtDueDate' => $row['debtduedate'],
                'debtID' => $row['debtid'],
                'processed' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao processar a linha', ['error' => $e->getMessage(), 'row' => $row]);
            return null;
        }
    }

    public function chunkSize(): int
    {
        return 20000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}

