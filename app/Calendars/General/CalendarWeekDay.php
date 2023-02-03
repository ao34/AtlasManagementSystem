<?php
namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use Carbon\Carbon;
use Auth;

// その日を出力するためのクラス
class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // CSSを当てることが出来るようにクラス名を出力する
  function getClassName(){
    //「D」を指定すると「Sun」「Mon」などの曜日を省略形式で取得できる
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function pastClassName(){
    return '<p class="past-day">' . $this->carbon->format("j"). '日</p>';
  }

  /**
   * @return
   */

  //  カレンダーの日の内部を出力する
   function render(){
    // 「j」を指定すると先頭にゼロをつけない日付けを取得できる
     return '<p class="day">' . $this->carbon->format("j"). '日</p>';
   }

   function selectPart($ymd){
    // dd($ymd);
    // ReserveSettingsから今日の予約を探す
    // その中の1部の予約を探して格納
     $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    //  dd($one_part_frame);
     $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
     $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    //  もし１部だったら
     if($one_part_frame){
      // 残り人数を格納
       $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first()->limit_users;
     }else{
       $one_part_frame = '20';
     }
     if($two_part_frame){
       $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first()->limit_users;
     }else{
       $two_part_frame = '20';
     }
     if($three_part_frame){
       $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first()->limit_users;
     }else{
       $three_part_frame = '20';
     }

     $html = [];
     $html[] = '<select name="getPart[]" class="border-primary" style="width:70px; border-radius:5px;" form="reserveParts">';
     $html[] = '<option value="" selected></option>';
    //  もし１部の残り人数が０だったら
     if($one_part_frame == "0"){
       $html[] = '<option value="1" disabled>リモ1部(残り0枠)</option>';
     }else{
      // それ以外は残り人数を格納
       $html[] = '<option value="1">リモ1部(残り'.$one_part_frame.'枠)</option>';
     }
     if($two_part_frame == "0"){
       $html[] = '<option value="2" disabled>リモ2部(残り0枠)</option>';
     }else{
       $html[] = '<option value="2">リモ2部(残り'.$two_part_frame.'枠)</option>';
     }
     if($three_part_frame == "0"){
       $html[] = '<option value="3" disabled>リモ3部(残り0枠)</option>';
     }else{
       $html[] = '<option value="3">リモ3部(残り'.$three_part_frame.'枠)</option>';
     }
     $html[] = '</select>';
     return implode('', $html);
   }

   function getData(){
     return '<input type="hidden" value="'. $this->carbon->format('Y-m-d') .'" name="getData[]" form="reserveParts">';
   }

   function everyDay(){
     return $this->carbon->format('Y-m-d');
   }

   function authReserveDay(){
    // 予約した日にちを配列として取り出す
     return Auth::user()->reserveSettings->pluck('setting_reserve')->toArray();
   }

   function authReserveDate($reserveDate){
    // setting_reserveと$reserveDateが一致する日を返す
     return Auth::user()->reserveSettings->where('setting_reserve', $reserveDate);
   }

}
