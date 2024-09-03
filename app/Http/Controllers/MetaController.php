<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MetaService;
use App\Services\ContaService;

class MetaController extends Controller
{
    protected $metaService;
    protected $contaService;

    public function __construct(MetaService $metaService, ContaService $contaService)
    {
        $this->metaService = $metaService;
        $this->contaService = $contaService;
    }

    public function index(Request $request)
    {
        // $userConta = $this->contaService->findUserConta(auth()->id());
        $data = $this->metaService->findAllMetas($request);
        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->metaService->findById($id);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $data = $this->metaService->create($request);
        return response()->json($data);
    }


    // Demais métodos...
}
