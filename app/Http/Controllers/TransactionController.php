<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $transaction = Transaction::select('transactions.*', 'items.name', 'item_types.type_name')
            ->join('items', 'items.id', '=', 'transactions.items_id')
            ->join('item_types', 'item_types.id', '=', 'items.types_id')
            ->dateSort($request->date_sort)
            ->nameSort($request->name_sort)
            ->str($request->str)
            ->get();

            $res['status'] = 'success';
            $res['message'] = 'Successfully get transaction';
            $res['data'] = $transaction;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function indexTransactionSold(Request $request)
    {
        try {
            // $transaction = Transaction::selectRaw('item_types.type_name, SUM(transactions.sold) as total_terjual')
            // ->join('items', 'items.id', '=', 'transactions.items_id')
            // ->join('item_types', 'item_types.id', '=', 'items.types_id')
            // ->whereBetween('transactions.dates', [$request->from, $request->to])
            // ->groupBy('item_types.id')
            // ->get();

            $requestFrom = $request->from ? $request->from : '2019-01-01' ;
            $requestTo = $request->to ? $request->to : now() ;

            $transaction = DB::select('select it.type_name, SUM(transactions.sold) as total_terjual from transactions
            join items i on i.id = transactions.items_id 
            join item_types it on it.id = i.types_id 
            where transactions.dates between ? and ?
            group by it.id', [$requestFrom, $requestTo]);

            $res['status'] = 'success';
            $res['message'] = 'Successfully get transaction';
            $res['data'] = $transaction;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function transactionSearch(Request $request)
    {
        try {
            $transaction = Transaction::query()->str($request->str)->get();

            $res['status'] = 'success';
            $res['message'] = 'Successfully get transaction';
            $res['data'] = $transaction;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'items_id' 		=> ['required'],
                'sold' 		=> ['required'],
                'dates' 		=> ['required']
            ]);

            $input = $request->all();
            Transaction::create($input);
            DB::commit();

            $res['status'] = 'success';
            $res['message'] = 'Successfully create transaction';
            $res['data'] = '';
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function show($id)
    {
        try {
            $transaction = Transaction::select('transactions.*', 'items.name', 'item_types.type_name', 'item_types.id as types_id')
            ->join('items', 'items.id', '=', 'transactions.items_id')
            ->join('item_types', 'item_types.id', '=', 'items.types_id')
            ->where('transactions.id', $id)
            ->firstOrFail();

            $res['status'] = 'success';
            $res['message'] = 'Successfully get transaction';
            $res['data'] = $transaction;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::where('id', $id)->firstOrFail();

            $request->validate([
                'items_id' 		=> ['required'],
                'sold' 		=> ['required'],
                'dates' 		=> ['required']
            ]);
            
            $transaction->update($request->all());
            $res['status'] = 'success';
            $res['message'] = 'Successfully update transaction';
            $res['data'] = $transaction;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::where('id', $id)->firstOrFail();
            $transaction->delete();

            $res['status'] = 'success';
            $res['message'] = 'Successfully delete transaction';
            $res['data'] = '';
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }
}
