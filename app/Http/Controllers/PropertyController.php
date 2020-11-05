<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyFormRequest;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private $propertyService;

    public function __construct(PropertyService $propertyService) {
        $this->propertyService = $propertyService;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->propertyService->findAll($request));
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->propertyService->find($id));
    }

    public function store(PropertyFormRequest $request): JsonResponse
    {
        return response()->json($this->propertyService->save($request), 201);
    }

    public function update(PropertyFormRequest $request, int $id): JsonResponse
    {
        return response()->json($this->propertyService->save($request, $id));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->propertyService->delete($id));
    }

}
