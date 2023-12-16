<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use App\Traits\Responser;

class ItemTypeController extends Controller
{
    // use Responser;
    public function index(Request $request)
    {
        try {
            $itemType = ItemType::all();

            // $itemType1 = ItemType::select('items.*')
            // ->join('items', 'items.types_id', '=', 'item_types.id')
            // ->get();

            // print_r(json_encode($itemType1));die;


            $res['status'] = 'success';
            $res['message'] = 'Successfully get categories';
            $res['data'] = $itemType;
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
            
            $validatedData = $request->validate([
                'type_name' => ['required', 'max:255'],
            ]);

            $input = $request->all();
            ItemType::create($input);
            DB::commit();
            $res['status'] = 'success';
            $res['message'] = 'Successfully create item type';
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

            $itemType = ItemType::where('id', $id)->firstOrFail();
            $res['status'] = 'success';
            $res['message'] = 'Successfully get category';
            $res['data'] = $itemType;
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
            $itemType = ItemType::where('id', $id)->firstOrFail();

            $validatedData = $request->validate([
                'type_name' => ['required']
            ]);
            
            $itemType->update($request->all());
            $res['status'] = 'success';
            $res['message'] = 'Successfully update item type';
            $res['data'] = $itemType;
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
            $itemType = ItemType::where('id', $id)->firstOrFail();
            $itemType->delete();

            $res['status'] = 'success';
            $res['message'] = 'Successfully delete category';
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
