<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnTransactionRequest;
use App\Http\Resources\ReturnTransactionResource;
use App\Http\Resources\TransactionResource;
use App\Models\Car;
use App\Models\ReturnTransaction;
use App\Models\Transaction;
use App\Traits\ApiTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnTransactionController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $plat_number = request()->plat_number;
        $perPage = request()->per_page;
        $items = ReturnTransaction::with(['transaction','transaction.car', 'user'])->where('user_id',auth()->user()->id)->latest();
        if (!is_null($perPage)) {
            return ReturnTransactionResource::collection($items->paginate($perPage));
        } else {
            return ReturnTransactionResource::collection($items->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReturnTransactionRequest $request)
    {
        $credentials = $request->all();
        $plat_number = $credentials['plat_number'];
        // get user
        $user = auth()->user();
        $transaction = Transaction::with('car')->whereHas('car', function (Builder $query) use ($plat_number) {
            $query->where('plat_number', $plat_number);
        })->whereHas('user', function (Builder $queryUser) use ($user) {
            $queryUser->where('user_id', $user->id);
        })->where('status', 'running')->first();

        // cek apakah ada transaksi atau tidak
        if (!$transaction) {
            return $this->responseNotFound('Transaksi tidak ditemukan');
        }
        // get car
        $car = Car::where('plat_number', $plat_number)->first();

        try {
            $start_date = Carbon::parse($transaction->start_date);
            $end_date = Carbon::parse($transaction->end_date);
            // dapatkan hari pinjaman
            $total_day = $end_date->diffInDays($start_date) + 1;
            DB::beginTransaction();
            $obj = ReturnTransaction::create([
                "date" => $credentials['date'],
                "start_date" => $transaction->start_date,
                "end_date" => $transaction->end_date,
                "car_id" => $transaction->car_id,
                "rental_fee" => $car->rental_fee,
                "total_day" => $total_day,
                "total_payment" => $total_day * $car->rental_fee,
                "transaction_id" => $transaction->id,
                "user_id" => $user->id
            ]);

            // update status mobil menjadi ready
            $car->update([
                "is_rent" => 0
            ]);
            // update transaksi menjadi sukses
            $transaction->update([
                'status' => 'success',
            ]);
            DB::commit();
            return new ReturnTransactionResource($obj);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return $this->responseNotAccept();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $transaction = Transaction::with('car')->whereHas('car', function (Builder $query) use ($id) {
            $query->where('plat_number', $id);
        })->whereHas('user', function (Builder $queryUser) use ($user) {
            $queryUser->where('user_id', $user->id);
        })->where('status', 'running')->first();

        // cek apakah ada transaksi atau tidak
        if (!$transaction) {
            return $this->responseNotFound('Transaksi tidak ditemukan');
        }
        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $find = ReturnTransaction::find($id);
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
