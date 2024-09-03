<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransacaoTiposService;
use App\Services\ContaService;

class TransacaoTiposController extends Controller
{
    protected $transacaoService;
    protected $contaService;

    public function __construct(TransacaoTiposService $transacaoService, ContaService $contaService)
    {
        $this->transacaoService = $transacaoService;
        $this->contaService = $contaService;
    }

    public function index(Request $request)
    {
        // $userConta = $this->contaService->findUserConta(auth()->id());
        $data = $this->transacaoService->findAllTransacoesTipos($request);
        return response()->json($data);
    }
}