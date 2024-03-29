<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // カレンダータイトル取得
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダー出力
  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    // 週の情報を取得
    $weeks = $this->getWeeks();
    // dd($weeks);
    // 週カレンダーオブジェクトを一週ずつ処理
    foreach($weeks as $week){
      // 週カレンダーオブジェクトを使ってHTMLのクラス名を出力
      $html[] = '<tr class="'.$week->getClassName().'">';
      // 週カレンダーオブジェクトから、日カレンダーオブジェクトの配列を取得
      $days = $week->getDays();
      // dd($days);
      // 日カレンダーオブジェクトをループさせる
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");
        // dd($toDay);　今日
        // もし１日が$day(foreachしている日)以前かつ今日が$day以降なら
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          // 過去
          $html[] = '<td class="calendar-td past-day">';

        }else{
          // それ以外の未来日はクラス名を出力し、<td>の中に日カレンダーを出力
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();
        // 第一引数には、検索する値を渡し（foreachで回してる日）、第二引数には、検索対象の配列を渡す（予約した日にち）
        // 予約日を検索してあったら
        if(in_array($day->everyDay(), $day->authReserveDay())){
          // 予約日を取得し予約した部数を格納
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          // dd($reservePart);
          // 表示
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
        // もし予約日が１日が$day(foreachしている日)以前かつ今日が$day以降なら
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            // (予約が入っていない日は)部数を受け取って予約する
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'. $reservePart.'参加</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            // dd($html);
          }else{
            // 予約が入っている日は予約している部を表示
            // キャンセルボタン→モーダルを表示させる
            // dd($id);
            $html[] = '<button type="submit" class="js-modal-open btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" day="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'" part="'. $day->authReserveDate($day->everyDay())->first()->setting_part .'">'. $reservePart .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }

          // 検索して予約日がなかったら
          }else{
            // 予約をしていないのが過去の場合
            if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="calendar-td">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            }else{
            $html[] = $day->selectPart($day->everyDay());
            }
          }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    return implode('', $html);
  }

  // 週の情報を取得
  protected function getWeeks(){
    $weeks = [];
    // 初日
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 月末まで
    $lastDay = $this->carbon->copy()->lastOfMonth();
    // 一週目
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    // 作業用の日
    // +7日した後、週の開始日に移動する
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    // 月末までループさせる
    while($tmpDay->lte($lastDay)){
      // 週カレンダーViewを作成
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      // 次週+7日する
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
