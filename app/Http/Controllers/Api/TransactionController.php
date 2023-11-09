<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Car;
use App\Models\Transaction;
use App\Traits\ApiTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $perPage = request()->per_page;
        $items = Transaction::with(['car'])->where('user_id', auth()->user()->id)->latest();
        if (!is_null($perPage)) {
            return TransactionResource::collection($items->paginate($perPage));
        } else {
            return TransactionResource::collection($items->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $credentials = $request->all();
        // cek mobil apakah ada
        $car = Car::find($credentials['car_id']);
        if (!$car) {
            return $this->responseNotFound('Mobil tidak ditemukan');
        }
        // cek apakah mobil sedang dipinjam
        if ($car->is_rent !== 0) {
            return $this->responseNotAccept('Sedang di sewa');
        }
        try {
            DB::beginTransaction();
            $obj = Transaction::create([
                "date" => Carbon::now()->format('Y-m-d'),
                "start_date" => $credentials['start_date'],
                "end_date" => $credentials['end_date'],
                "car_id" => $credentials['car_id'],
                "user_id" => auth()->user()->id,
            ]);

            // update status mobil menjadi sedang dipinjam
            $car->update([
                "is_rent" => 1
            ]);
            DB::commit();
            return new TransactionResource($obj);
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
        $find = Transaction::find($id);
        if (is_null($find)) {
            return $this->responseNotFound();
        }
        return new TransactionResource($find);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $find = Transaction::find($id);
        // update status mobil yang sudah dipinjam sebelumnya
        $carTransaction = Car::find($find['car_id']);
        $carTransaction->update([
            "is_rent" => 0
        ]);

        $credentials = $request->all();
        // cek mobil apakah ada
        $car = Car::find($credentials['car_id']);
        if (!$car) {
            return $this->responseNotFound('Mobil tidak ditemukan');
        }
        // cek apakah mobil sedang dipinjam
        if ($car->is_rent !== 0) {
            return $this->responseNotAccept('Sedang di sewa');
        }
        try {
            DB::beginTransaction();
            $find->update([
                "date" => $credentials['date'],
                "start_date" => $credentials['start_date'],
                "end_date" => $credentials['end_date'],
                "car_id" => $credentials['car_id'],
                "user_id" => auth()->user()->id,
            ]);
            // update status mobil menjadi sedang dipinjam
            $car->update([
                "is_rent" => 1
            ]);
            DB::commit();
            return new TransactionResource($find);
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
        $find = Transaction::find($id);
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
