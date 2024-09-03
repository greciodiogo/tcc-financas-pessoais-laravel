<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransacaoService;
use App\Services\ContaService;

class TransacaoController extends Controller
{
    protected $transacaoService;
    protected $contaService;

    public function __construct(TransacaoService $transacaoService, ContaService $contaService)
    {
        $this->transacaoService = $transacaoService;
        $this->contaService = $contaService;
    }

    public function index(Request $request)
    {
        // $userConta = $this->contaService->findUserConta(auth()->id());
        $data = $this->transacaoService->findAllTransacoes($request);
        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->transacaoService->findById($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        print("cheguei");
        $data = $this->transacaoService->create($request);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = $this->transacaoService->update(1, $request);
        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $data = $this->transacaoService->delete($request);
        return response()->json($data);
    }


    // Demais métodos...
}
