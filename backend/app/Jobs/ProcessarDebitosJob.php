<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Debt;
use App\Services\BoletoService;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class ProcessarDebitosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $boletoService = new BoletoService();
        $emailService = new EmailService();

        // Processa as dívidas em lotes de 1000 registros por vez
        Debt::query()
            ->select('name', 'email', 'debtAmount', 'debtDueDate', 'debtID')
            ->where('processed', false)
            ->chunk(1000, function ($debts) use ($boletoService, $emailService) {
                foreach ($debts as $debt) {
                    try {
                        // Gera o boleto
                        $boletoService->gerarBoleto($debt->debtID, $debt->debtAmount, $debt->debtDueDate);

                        // Envia o e-mail
                        $emailService->enviarEmail($debt->email, $debt->name, $debt->debtAmount);

                        // Marca a dívida como processada
                        $debt->processed = true;
                        $debt->save();
                    } catch (\Exception $e) {
                        Log::error('Erro ao processar dívida: ' . $debt->id, ['error' => $e->getMessage()]);
                    }
                }
            });
    }
}
