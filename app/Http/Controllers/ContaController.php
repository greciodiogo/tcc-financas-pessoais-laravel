<?php

namespace App\Http\Controllers;

use App\Services\ContaService;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    protected $contaService;

    public function __construct(ContaService $contaService)
    {
        $this->contaService = $contaService;
    }

    public function index(Request $request)
    {
        $contas = $this->contaService->findAllContas($request);
        return response()->json($contas);
    }

    // Outros métodos...
}
