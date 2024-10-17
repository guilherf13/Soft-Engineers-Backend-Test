<?php

namespace Tests\Feature;

use App\Jobs\ProcessarDebitosJob;
use App\Imports\DebtImport;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ProcessarDebitosJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_import_debts()
    {
        // Simula a importação com Laravel Excel
        Excel::fake();

        // Simula a ação de um usuário autenticado enviando o formulário de importação
        $user = User::factory()->create(); // Se precisar de autenticação
        $this->actingAs($user)
            ->post('/debts/import', [
                'file' => UploadedFile::fake()->create('import.csv', 100, 'text/csv'),
            ]);

        // Verifica se o arquivo CSV foi importado no disco 'local'
        Excel::assertImported('import.csv', 'local', function (DebtImport $import) {
            // Verifica se a classe DebtImport foi usada para a importação
            return true;
        });

        // Verifica se o débito foi adicionado no banco de dados
        $this->assertDatabaseCount('debts', 1);
        $this->assertDatabaseHas('debts', [
            'name' => 'John Doe', // Altere de acordo com os dados reais do arquivo CSV
        ]);
    }

    protected function givenUser()
    {
        return User::factory()->create();
    }

    /** @test */
    public function it_executes_process_debts_job()
    {
        // Criar 10 registros de dívida para o teste
        Debt::factory()->count(10)->create(['processed' => false]);

        // Mocks de serviços
        Queue::fake();

        // Executa o job
        $job = new ProcessarDebitosJob();
        $job->handle();

        // Verifica se as dívidas foram processadas
        foreach (Debt::all() as $debt) {
            $this->assertTrue($debt->processed);
        }
    }
}
