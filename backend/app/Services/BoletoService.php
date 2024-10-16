<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BoletoService
{
    public function gerarBoleto($id, $valor, $dataVencimento)
    {
        Log::info("Boleto gerado para dívida {$id} com valor de {$valor}");
    }
}

