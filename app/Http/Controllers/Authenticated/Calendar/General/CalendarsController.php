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
            $today = Carbon::today();
            // 今日以降の予約した日にちを取得
            $getDate = $request->where('getDate', '>=', $today)->getDate;
            // 配列をフィルタリング$getDataをキー,$getPartを値として配列を生成
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // 日にち=>部数でforeachできる
            foreach($reserveDays as $key => $value){
                // ReserveSettingsモデルのsetting_reserveと$getDate,setting_partと$getPartが一致する値を探す->idを取得
                // 誰が何日に何部かの配列ができる
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
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
}
