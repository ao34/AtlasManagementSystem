<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;
use Carbon\Carbon;


class CalendarsController extends Controller
{
    public function show(){
        // 現時刻を渡して今月を表示
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            // dd($request);
            // 部数を取得
            $getPart = $request->getPart;
            // dd($getPart);
            $today = Carbon::today();
            // dd($today); OK
            // 今日以降の日にちを取得
            $getDate = $request->getData;
            // dd($getDate);
            // 配列をフィルタリング$getDataをキー,$getPartを値として配列を生成
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // dd($reserveDays);

            // 日にち=>部数でforeachできる
            foreach($reserveDays as $key => $value){

                $reserveDays = new ReserveSettings;
                $reserveDays->setting_reserve = $key;
                $reserveDays->setting_part = $value;
                $reserveDays->save();

                // ReserveSettingsモデルのsetting_reserveと$getDate,setting_partと$getPartが一致する値を探す->idを取得
                // 誰が何日に何部かの配列ができる
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // dd($reserve_settings);
                // limit_usersをデクリメントする
                $reserve_settings->decrement('limit_users');
                // usersリレーションでAuthuserを追加する
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }


    public function delete(Request $request)
    {
        // dd($request);
            $deletePart = $request->part;
            $today = Carbon::today();
            $deleteDate = $request->data;
            // $reserveDays = array_filter(array_combine($getDate, $getPart));
            // dd($reserveDays);

            $delete_settings = ReserveSettings::where('setting_reserve', $deleteDate)->where('setting_part', $deletePart)->first();

            \DB::table('reserve_settings')
                ->where('id' , $delete_settings->id)
                ->delete();

            $delete_settings->increment('limit_users');
            $delete_settings->users()->detach(Auth::id());

        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}
