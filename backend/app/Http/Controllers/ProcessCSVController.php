<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProcessCSVRequest;
use App\Http\Requests\UploadRequest;
use App\Jobs\UploadJob;
use App\Services\ProcessCSVService;
use Illuminate\Http\Request;


class ProcessCSVController extends Controller
{
    protected ProcessCSVService $processCSVService;

    public function __construct(ProcessCSVService $processCSVService)
    {
        $this->processCSVService = $processCSVService;
    }

    // Endpoint para upload de arquivo
    public function ProcessCSVFile(ProcessCSVRequest $request): \Illuminate\Http\JsonResponse
    {
        $fileName = $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('temp', $fileName);

        // Caminho do arquivo para o Job
        UploadJob::dispatch($filePath);

        return response()->json(["message" => "Arquivo Enviado"]);

    }

    // Endpoint para registrar histórico de arquivos csv processados
    public function historyRecordCSV(UploadRequest $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->only(['name', 'uploaded_at']);
        $uploads = $this->uploadService->getUploadHistory($filters);

        return response()->json($uploads->toArray());
    }

    // Endpoint para busca de conteúdo do arquivo
    public function searchContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->only(['TckrSymb', 'RptDt']);
        $results = $this->uploadService->searchFileContent($filters);

        return response()->json($results);
    }

    public function createToken(): array|\Illuminate\Http\JsonResponse
    {
        // Recupera o usuário autenticado
        $user = \App\Models\User::find(1);

        // Verifica se o usuário está autenticado
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Cria o token para o usuário autenticado
        $token = $user->createToken('teste');

        return ['token' => $token->plainTextToken];
    }
}

