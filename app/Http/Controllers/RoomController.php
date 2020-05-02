<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;  
use App\Shop;
use App\Room;
use App\RoomRate;

class RoomController extends Controller
{
    public function CreateNewRoom(Request $request)
    {
        $room_type = $request['room_type'];
        $room_count = $request['room_count'];
        $room_specification = $request['room_specification'];

        // start create room
        for ($room_count; 0 < $room_count ; $room_count--) { 
            $new_room = new Room();
            $new_room->type = $room_type;
            $new_room->user_id = Auth::user()->id;
            $new_room->shop_id = Auth::user()->shop_id;
            $new_room->description = $room_specification;
            $new_room->save();
        }
        // end create room
        return redirect()->back()->with('success','Room Successfully Created');
    }
    public function EditRoom(Request $request)
    {
        $room_specification = $request['room_specification'];
        $edit_room_type = $request['edit_room_type'];
        $edit_room_no = $request['edit_room_No'];
        $room_id = $request['room_id'];

        Room::where('shop_id',Auth::user()->shop_id)->where('id',$room_id)->update([
                'type' => $edit_room_type,
                'user_id' => Auth::user()->id,
                'room_no' => $edit_room_no,
                'description' => $room_specification,
            ]);
        
        return redirect()->back()->with('success','Room Successfully Created');
    }

    public function EditHotelRates(Request $request)
    {
        $editedNewRate = $request['editedNewRate'];
        $edit_local_rate = $request['edit_local_rate'];
        $edit_foreign_rate = $request['edit_foreign_rate'];
        $edit_rate_id = $request['edit_rate_id'];
        $rateChecker = RoomRate::where('shop_id',Auth::user()->shop_id)->where('id','!=',$edit_rate_id)->where('rateCode',$editedNewRate)->count(); 
        if($rateChecker != 0){
            return redirect()->back()->with('error','You already have created rate like this,Please check');
        }else{
            RoomRate::where('shop_id',Auth::user()->shop_id)->where('id',$edit_rate_id)->update([
                'rateCode' => $editedNewRate,
                'user_id' => Auth::user()->id,
                'local_rate' => $edit_local_rate,
                'foreign_rate' => $edit_foreign_rate,
            ]);
            return redirect()->back()->with('success','Room Successfully Created');
        }
    }
    public function DeleteHotelRates(Request $request)
    {
        {

            RoomRate::where('shop_id',Auth::user()->shop_id)->where('id',$request['delete_rate_id'])->delete();
            return redirect()->back()->with('success','Rate Successfully Deleted');
        }
    }

    public function DeleteHotelRoom(Request $request)
    {
        {
            Room::where('shop_id',Auth::user()->shop_id)->where('id',$request['delete_room_id'])->delete();
            return redirect()->back()->with('success','Room Successfully Deleted');
        }
    }
}
