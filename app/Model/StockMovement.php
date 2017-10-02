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
	protected $appends = ['type_label'];
	public function item(){
		return $this->belongsTo('App\Model\Item','stock_id','stock_id');
	}
	public function getTypeLabelAttribute(){
		if($this->type == 'in'){
			return '<span class="glyphicon glyphicon-arrow-right text-success"></span>';
		}else if($this->type == 'out'){
			return '<span class="glyphicon glyphicon-arrow-left text-danger"></span>';
		}else{
			return 'Unknown';
		}
	}
	public function updateStockMoveWithShipment($shipment_id)
	{
		$shipment_details = DB::table('shipment_details')->where('shipment_id', $shipment_id)->get();
		if(!empty($shipment_details)){
			foreach($shipment_details as $detail){

				$quantity = $detail->quantity;
				$status = $detail->status;
				$stock_id = $detail->stock_id;
				$condition = true;

				$reason = 'Sale Orders';

				
				$stock_move = StockMovement::where('shipment_id',$shipment_id)->where('stock_id',$stock_id)->first();
				if(empty($stock_move)){
					$stock_move = new StockMovement();
					$stock_move->shipment_id = $shipment_id;
					$stock_move->stock_id = $stock_id;
					$stock_move->quantity = $quantity;
					$stock_move->type = 'out';
					$stock_move->reason = $reason;
					$stock_move->save();
				}else{
					$stock_move->quantity = $quantity;
					$stock_move->type = 'out';
					$stock_move->reason = $reason;
					$stock_move->update();
				}
				

			}
		}
	}
	public function removeShipment($shipment_id){
		$stock_moves = StockMovement::where('shipment_id', $shipment_id)->delete();
		

	}
	public function getAllStockMoves()
	{
		$sql = "select stock_movements.*, item_code.description as item_name from stock_movements left join item_code on stock_movements.stock_id = item_code.stock_id left JOIN stock_move_reasons on stock_movements.reason_id = stock_move_reasons.id order by stock_movements.id";
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
