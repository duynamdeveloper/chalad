<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\StockMovement;
use App\Model\Item;
use App\Model\Reason;
class StockController extends Controller
{
    function index(){
    	$stock_movement = new StockMovement();
    	$data['menu'] = 'sales';
     	$data['sub_menu'] = 'shipment/list';
    	$data['items'] = Item::all();
    	$data['reasons'] = Reason::all();
    	$data['stock_movements'] = $stock_movement->getAllStockMoves();
    	return view('admin.stockMovements.index',$data);
    }
    function create(Request $request){
    	$stock_movement = new StockMovement();
    	if($request->reason == "create_new"){
    		$reason = new Reason();
    		$reason->name = $request->new_reason;
    		$reason->save();
    		$stock_movement->reason_id = $reason->id;
    	}else{
    		$stock_movement->reason_id = $request->reason;
    	}
    	$stock_movement->stock_id = $request->stock_id;
    	$stock_movement->quantity = $request->quantity;
    	$stock_movement->save();
    	//var_dump($request);
    	return redirect('/stock/movement');
    }
    function getStockMovementsById(Request $request){
    	$id = $request->id;
    	//$id=2;
    	$stock_movement = new StockMovement();
    	$data = $stock_movement->getStockMovementsById($id);
    	return response()->json($data[0]);
    }
    function update(Request $request){
    	$stock_movement = StockMovement::find($request->stock_movement_id);
    	if($request->reason == "create_new"){
    		$reason = new Reason();
    		$reason->name = $request->new_reason;
    		$reason->save();
    		$stock_movement->reason_id = $reason->id;
    	}else{
    		$stock_movement->reason_id = $request->reason;
    	}
    	$stock_movement->stock_id = $request->stock_id;
    	$stock_movement->quantity = $request->quantity;
    	$stock_movement->update();
    	//var_dump($request);
    	return redirect('/stock/movement');
    }
    function delete(Request $request){
    	$id = $request->id;
    	$stock_movement = StockMovement::find($id);
    	$stock_movement->delete();
    	return response()->json(['state'=>true]);
    }
}
