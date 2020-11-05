<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContractService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new Contract();
    }

    public function findAll(Request $request) {

        return Contract::with('property')
            ->orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->_limit ?? Contract::RECORDS_PER_PAGE, ['*'], 'page', $request->_page ?? 1);
    }

    public function find(int $id): Model {
        if (!$contract = Contract::with('property')->find($id)) {
            throw new ModelNotFoundException("Contract with id $id doesn't exists!" );
        }

        return $contract;
    }
}
