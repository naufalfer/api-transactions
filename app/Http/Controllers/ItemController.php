<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        try {
            $item = Item::with('item_type')->get();

            $res['status'] = 'success';
            $res['message'] = 'Successfully get item';
            $res['data'] = $item;
            return response($res, 200);

        } catch (Exception $exception) {

            $res['status'] = 'error';
            $res['message'] = $exception->getMessage();
            $res['data'] = '';
            return response($res, 400);

        }
    }

    public function itemSearch(Request $request)
    {
        try {
            $item = Item::query()->str($request->str)->get();

            $res['status'] = 'success';
            $res['message'] = 'Successfully get item';
            $res['data'] = $item;
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

            // $request->validate($request->all(), [
            //     'name' 		=> ['required'],
            //     'types_id' 		=> ['required']
            // ]);

            $request->validate([
                'name'  => 'required',
                'types_id'  => 'required',
            ]);

            $input = $request->all();
            Item::create($input);
            DB::commit();

            $res['status'] = 'success';
            $res['message'] = 'Successfully create item';
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

            $item = Item::with('item_type')->where('id', $id)->firstOrFail();
            $res['status'] = 'success';
            $res['message'] = 'Successfully get item';
            $res['data'] = $item;
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
            $item = Item::where('id', $id)->firstOrFail();
            // $rules = [
            //     'id'        => ['required'],
            //     'name' 		=> ['required'],
            //     'types_id' 		=> ['required']
            // ];

            $request->validate([
                'name' 		=> ['required'],
                'types_id' 		=> ['required']
            ]);

            // $this->formValidation($request->all(), $rules);
            
            $item->update($request->all());
            $res['status'] = 'success';
            $res['message'] = 'Successfully update item';
            $res['data'] = $item;
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
            $item = Item::where('id', $id)->firstOrFail();
            $item->delete();

            $res['status'] = 'success';
            $res['message'] = 'Successfully delete item';
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
