<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Item;
use DB;
use Config;
class StockMovement extends Model
{
	protected $table="stock_movements";
	protected $fillable = ['product_code','shipment_id','quantity','created_at','updated_at'];
	public function item(){
		return $this->belongsTo('App\Model\Item','stock_id','stock_id');
	}
	public function reason(){
		return $this->belongsTo('App\Model\Reason','reason_id','id');
	}
	public function updateStockMoveWithShipment($shipment_id)
	{
		$shipment_details = DB::table('shipment_details')->where('shipment_id', $shipment_id)->get();
		if(!empty($shipment_details)){
			foreach($shipment_details as $detail){

				$packed_qty = $detail->packed_qty;
				$shipped_qty = $detail->shipped_qty;
				$stock_id = $detail->stock_id;
				$condition = true;

				if($packed_qty > 0 && $shipped_qty == 0){
					$quantity = -$packed_qty;
					$reason = Config::get('constants.REASON.READY_TO_SHIP');
				}else if($packed_qty == 0 && $shipped_qty>0){
					$quantity = -$shipped_qty;
					$reason = Config::get('constants.REASON.SHIPPED');
				}else{
					$condition = false;
				}

				if($condition){
					$stock_move = StockMovement::where('shipment_id',$shipment_id)->where('stock_id',$stock_id)->first();
					if(empty($stock_move)){
						$stock_move = new StockMovement();
						$stock_move->shipment_id = $shipment_id;
						$stock_move->stock_id = $stock_id;
						$stock_move->quantity = $quantity;
						$stock_move->reason_id = $reason;
						$stock_move->save();
					}else{
						$stock_move->quantity = $quantity;
						$stock_move->reason_id = $reason;
						$stock_move->update();
					}
				}

			}
		}
	}
	public function removeShipment($shipment_id){
		$stock_moves = StockMovement::where('shipment_id', $shipment_id)->delete();
		

	}
	public function getAllStockMoves()
	{
		$sql = "select stock_movements.*, item_code.description as item_name, stock_move_reasons.name as reason from stock_movements left join item_code on stock_movements.stock_id = item_code.stock_id left JOIN stock_move_reasons on stock_movements.reason_id = stock_move_reasons.id order by stock_movements.id";
		$data = DB::select(DB::raw($sql));
		return $data;
	}
	public function getStockMovementsById($id)
	{
		$sql = "select stock_movements.*, item_code.description as item_name, stock_move_reasons.name as reason from stock_movements left join item_code on stock_movements.stock_id = item_code.stock_id left JOIN stock_move_reasons on stock_movements.reason_id = stock_move_reasons.id where stock_movements.id=".$id;
		$data = DB::select(DB::raw($sql));
		return $data;
	}
}
