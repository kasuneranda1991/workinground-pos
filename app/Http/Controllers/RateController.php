<?php

namespace App\Http\Controllers;

use App\Rate;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function DoUpdateShopRate(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin') {
                if ($request['create_rate']) {
                    $staterCount = Rate::where('plan_name','stater')->count();
                    $advanceCount = Rate::where('plan_name','advance')->count();
                    $economyCount = Rate::where('plan_name','economy')->count();
                    // --------start payment plan
                    if($request['stater_rate']){
                        if($staterCount === 0){
                            $rate = new Rate();
                            $rate->plan_name = 'stater';
                            $rate->rate = $request['stater_rate'];
                            $rate->user_id = Auth::user()->id;
                            $rate->save();
                        }else if($staterCount === 1){
                            $previousRate = Rate::where('plan_name','stater')->value('rate');

                            if($previousRate > $request['stater_rate']){
                                Rate::where('plan_name','stater')->update([
                                    'rate' => $request['stater_rate'],
                                    'remark' => 'Rate Decreased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]);
                            }else if($previousRate === $request['stater_rate']){
                                Rate::where('plan_name','stater')->update([
                                    'rate' => $request['stater_rate'],
                                    'remark' => 'NO Change of Rate |=>'.Carbon::now(),
                                ]);
                            }else if($previousRate < $request['stater_rate']){
                               Rate::where('plan_name','stater')->update([
                                    'rate' => $request['stater_rate'],
                                    'remark' => 'Rate increased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]); 
                            }
                        }
                    }
                    // --------end payment plan 

                    // --------start payment plan
                    if($request['advance_rate']){
                        if($staterCount === 0){
                            $rate = new Rate();
                            $rate->plan_name = 'advance';
                            $rate->rate = $request['advance_rate'];
                            $rate->user_id = Auth::user()->id;
                            $rate->save();
                        }else if($advanceCount === 1){
                            $previousRate = Rate::where('plan_name','advance')->value('rate');

                            if($previousRate > $request['advance_rate']){
                                Rate::where('plan_name','advance')->update([
                                    'rate' => $request['advance_rate'],
                                    'remark' => 'Rate Decreased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]);
                            }else if($previousRate === $request['advance_rate']){
                                Rate::where('plan_name','advance')->update([
                                    'rate' => $request['advance_rate'],
                                    'remark' => 'NO Change of Rate |=>'.Carbon::now(),
                                ]);
                            }else if($previousRate < $request['advance_rate']){
                               Rate::where('plan_name','advance')->update([
                                    'rate' => $request['advance_rate'],
                                    'remark' => 'Rate increased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]); 
                            }
                        }
                    }
                    // --------end payment plan 
// enterprice_rate
                    // --------start payment plan
                    if($request['enterprice_rate']){
                        if($staterCount === 0){
                            $rate = new Rate();
                            $rate->plan_name = 'economy';
                            $rate->rate = $request['enterprice_rate'];
                            $rate->user_id = Auth::user()->id;
                            $rate->save();
                        }else if($economyCount === 1){
                            $previousRate = Rate::where('plan_name','economy')->value('rate');

                            if($previousRate > $request['enterprice_rate']){
                                Rate::where('plan_name','economy')->update([
                                    'rate' => $request['enterprice_rate'],
                                    'remark' => 'Rate Decreased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]);
                            }else if($previousRate === $request['enterprice_rate']){
                                Rate::where('plan_name','economy')->update([
                                    'rate' => $request['enterprice_rate'],
                                    'remark' => 'NO Change of Rate |=>'.Carbon::now(),
                                ]);
                            }else if($previousRate < $request['enterprice_rate']){
                               Rate::where('plan_name','economy')->update([
                                    'rate' => $request['enterprice_rate'],
                                    'remark' => 'Rate increased by '.Auth::user()->username.'(ID:'.Auth::user()->id.').Previous rate was '.$previousRate.'|=>'.Carbon::now(),
                                ]); 
                            }
                        }
                    }
                    // --------end payment plan
                    return redirect()->back()->with('success','Rate Created Successfull');
                }else if( $request['requestToUpdateRate'] == 1){
                    $staterCurrentRate = Rate::where('plan_name','stater')->value('rate');
                    $advanceCurrentRate = Rate::where('plan_name','advance')->value('rate');
                    $economyCurrentRate = Rate::where('plan_name','economy')->value('rate');

                    $newStater =$staterCurrentRate + ($staterCurrentRate/100)*$request['update_rate'];
                    $newAdvance =$advanceCurrentRate + ($advanceCurrentRate/100)*$request['update_rate'];
                    $newEconomy =$economyCurrentRate + ($economyCurrentRate/100)*$request['update_rate'];

                    Rate::where('plan_name','stater')->update(['rate' => sprintf('%0.2f', $newStater),]);
                    Rate::where('plan_name','advance')->update(['rate' => sprintf('%0.2f', $newAdvance),]);
                    Rate::where('plan_name','economy')->update(['rate' => sprintf('%0.2f', $newEconomy),]);

                    $shops = Shop::where('payment_plan','!=','demo')->get();
                    if ($shops) {
                        foreach ($shops as $shop) {
                            $newShopRate =$shop->monthly_rate + ($shop->monthly_rate/100)*$request['update_rate'];
                            Shop::where('id',$shop->id)->update([ 'monthly_rate' => $newShopRate ]);
                        }
                    }
                    return redirect()->back()->with('success','Rate Updated of all shops and Payment Plan'); 
                }
            }else{
                return redirect('/sri-lanka-web-based-pos-software-signup')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetSystemRates($plan)
    {
        $rates = Rate::where('plan_name',$plan)->value('rate');
        return $rates;
    }
}
