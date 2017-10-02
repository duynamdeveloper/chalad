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
    	
    	$data['menu'] = 'sales';
     	$data['sub_menu'] = 'shipment/list';
    	$data['items'] = Item::all();
    	$data['stock_movements'] = StockMovement::all();
    	return view('admin.stockMovements.index',$data);
    }
    function create(Request $request){
    	$stock_movement = new StockMovement();
    	
    		
    	$stock_movement->reason = $request->reason;
    	$stock_movement->type = $request->type;
    	$stock_movement->stock_id = $request->stock_id;
    	$stock_movement->quantity = $request->quantity;
    	$stock_movement->save();
    	//var_dump($request);
    	return redirect('/stock/movement');
    }
    function getStockMovementsById(Request $request){
    	$id = $request->id;
    	//$id=2;
    	$stock_movement = StockMovement::find($id);
    	
    	return response()->json($stock_movement);
    }
    function update(Request $request){
    	$stock_movement = StockMovement::find($request->stock_movement_id);
    	
    	$stock_movement->reason = $request->reason;
    	$stock_movement->type = $request->type;
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
