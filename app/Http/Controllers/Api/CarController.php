<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $is_rent = request()->is_rent;
        $perPage = request()->per_page;
        $items = Car::oldest();
        if (!is_null($search)) {
            $items->search($search);
        }
        if (!is_null($is_rent)) {
            $items->isRent($is_rent);
        }
        if (!is_null($perPage)) {
            return CarResource::collection($items->paginate($perPage));
        } else {
            return CarResource::collection($items->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        $credentials = $request->all();
        try {
            DB::beginTransaction();
            $obj = Car::create($credentials);
            DB::commit();
            return new CarResource($obj);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseNotAccept();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $find = Car::find($id);
        if (is_null($find)) {
            return $this->responseNotFound();
        }
        return new CarResource($find);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, string $id)
    {
        $find = Car::find($id);
        $credentials = $request->all();
        try {
            DB::beginTransaction();
            $find->update($credentials);
            DB::commit();
            return new CarResource($find);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseNotAccept($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $find = Car::find($id);
        try {
            DB::beginTransaction();
            $find->delete();
            DB::commit();
            return $this->responseNoContent();
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseNotAccept($th->getMessage());
        }
    }
}
