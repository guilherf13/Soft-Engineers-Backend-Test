# Documentação das APIs

## Um breve resumo de como ultilizalas. 
APIs são acessadas na url http://localhost:80/

## 1. Registro

**Endpoint:** POST /api/register
**Request:** 
Exemplo do body:

{

	"name": "Guilherme",
	"email": "guilherme@example.com",
	"password": "password"

}

**Descrição:** Parametros obrigatorios. Registra para obter o token de acesso
**Response: ** json
{

	"access_token": "1|AxDHe0wWfMSQW4WTJ6Ub6TASTyBAjKyqBQ2xhG6l0bf58218",
	"token_type": "Bearer",
	"user": {
	"name": "Guilherme",
	"email": "guilherme@example.com",
	"updated_at": "2024-10-16T21:20:38.000000Z",
	"created_at": "2024-10-16T21:20:38.000000Z",
	"id": 1
}

**Codigo:** success (200 OK):
**Erro:** (422 Error)
{

	"message":  "Error da validação"
}

## 2. Login

**Endpoint:** POST /api/login
**Request:** Parâmetros obrigatorio.
Exemplo do body:

{

	"email": "guilherme@example.com",
	"password": "password"

}
**Descrição:** Descrição: Obtém um novo bearer token.
**Response: ** json
{

	"access_token": "2|aidtz3z9IN8yIccUMFL6iWpV9mCqxQ4h7jk8M2nGee3df104",
	"token_type": "Bearer"

}
**Codigo:** success (200 OK):
**Erro:** (401 error)
{

	'message' => 'Credenciais inválidas'

}

## 3. Import

**Endpoint:** POST v1/debts/import
**Request:** Parâmetros obrigatorio.
Exemplo do body: imput do tipo file
**Descrição:** Descrição: Executa o import do arquivo enviado. 
**Response: ** json
{

    "message": "Arquivo importado e processamento iniciado com sucesso.",
    "file_name": "input - import.csv",
    "file_size": 9446

}
**Codigo:** success (200 OK):
**Erro:** (500 error)
{

	'error' => 'Ocorreu um erro ao importar o arquivo.',
    'details' => tipo do error,

}	