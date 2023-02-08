<?php
namespace App\Calendars\General;

use Carbon\Carbon;

// カレンダーの週を出力するためのクラス

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }
  // CSSを当てることが出来るようにクラス名を出力する
  function getClassName(){
    return "week-" . $this->index;
  }

  /**
   * @return
   */
  // 週の開始日〜終了日までを作成する
   function getDays(){
     $days = [];

    // 開始日〜終了日
     $startDay = $this->carbon->copy()->startOfWeek();
     $lastDay = $this->carbon->copy()->endOfWeek();
    //  作業用
     $tmpDay = $startDay->copy();
    //  月〜日までのループ
     while($tmpDay->lte($lastDay)){
      // 前の月、もしくは後ろの月の場合は空白を表示
      // 違う月の場合は余白用のカレンダー日オブジェクトを追加
      // 同じ月の場合は通常のカレンダー日オブジェクトを追加
       if($tmpDay->month != $this->carbon->month){
         $day = new CalendarWeekBlankDay($tmpDay->copy());
         $days[] = $day;
         $tmpDay->addDay(1);
         continue;
        }
        // 今月
        $day = new CalendarWeekDay($tmpDay->copy());
        $days[] = $day;
        // dd($days);
        // 翌月に移動
        $tmpDay->addDay(1);
      }
      return $days;
    }
  }
