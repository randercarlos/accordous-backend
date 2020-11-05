<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PropertyService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new Property();
    }

    public function findAll(Request $request) {

        if ($request->filled('available') && $request->get('available') == 'true') {
            return ['data' => Property::doesntHave('contract')->orderBy('id')->get()];
        }

        return Property::with('contract')
            ->orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->_limit ?? Property::RECORDS_PER_PAGE, ['*'], 'page', $request->_page ?? 1);
    }

    public function find(int $id): Model {
        if (!$property = Property::with('contract')->find($id)) {
            throw new ModelNotFoundException("Property with id $id doesn't exists!" );
        }

        return $property;
    }
}
