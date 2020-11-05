<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractFormRequest;
use App\Services\ContractService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    private $contractService;

    public function __construct(ContractService $contractService) {
        $this->contractService = $contractService;
    }

    public function index(Request $request)
    {
        return response()->json($this->contractService->findAll($request));
    }

    public function show(int $id)
    {
        return response()->json($this->contractService->find($id));
    }

    public function store(ContractFormRequest $request)
    {
        return response()->json($this->contractService->save($request), 201);
    }

    public function update(ContractFormRequest $request, int $id)
    {
        return response()->json($this->contractService->save($request, $id));
    }

    public function destroy(int $id)
    {
        return response()->json($this->contractService->delete($id));
    }

}
