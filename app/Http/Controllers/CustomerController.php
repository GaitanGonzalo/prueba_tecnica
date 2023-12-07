<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $params = $request->query();
        $where = [];
        if(!empty($params)){
            $where = $params;
            $where['status'] = 'A';
        }else{
            $where['status'] = 'A';
        }
        $customers = Customer::select('name', 'last_name', 'address', 'id_com', 'id_reg')->where($where)->get();
        if(!count($customers)) return response()->json(['message'=>'Record does not exist', 'success'=>false], 404);
        $customers->load(['communes'=>fn($q)=>$q->select('id_com', 'description'),'regions'=>fn($q)=>$q->select('id_reg', 'description')]);
        $customers->each(function ($customer) {
            $customer->makeHidden(['id_com', 'id_reg']);
        });
        return response()->json(['customers'=>$customers, 'success'=>true]);
    }

    public function store(CustomerRequest $request){
        try {
            $resp = Customer::create($request->all());
            return response()->json(['customer'=>$resp, 'success'=>true], 201);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'Something went wrong', 'success'=>false], 400);
        }
    }

    public function destroy(Request $request, $customer){
        try {
            $customer = Customer::where('dni', $customer)->first();
            if(!$customer) return response()->json(['message'=>'Record does not exist', 'success'=>false], 404);
            if($customer->status === 'trash') return response()->json(['message'=>'Record does not exist', 'success'=>false], 404);
            Customer::where('dni', $customer)->update(['status'=>'trash']);
            
            return response()->json(['message'=>'Deleted record', 'success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'Could not delete record', 'success'=>false]);
        }
        
    }
}
