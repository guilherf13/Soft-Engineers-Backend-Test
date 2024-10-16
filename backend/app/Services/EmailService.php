<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EmailService
{
    public function enviarEmail($email, $nome, $boleto)
    {
        Log::info(
            "E-mail enviado para {$nome},
            destinatario {$email},
            boleto {$boleto->status}"
        );
    }
}

