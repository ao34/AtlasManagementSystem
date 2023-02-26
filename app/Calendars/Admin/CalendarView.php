<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\Calendars\ReserveSettings;

class CalendarView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();

    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="past-day border">';
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">';
        }
        $html[] = $day->render();
        // $html[] = $day->dayPartCounts($day->everyDay());

  // 追加
        $html[] = '<div class="">';
        if($day->everyDay()){
          if($startDay <= $day->everyDay() || $toDay <= $day->everyDay()){
            $countOne = ReserveSettings::where('setting_part', 1)->count();
            $countTwo = ReserveSettings::where('setting_part', 2)->count();
            $countThree = ReserveSettings::where('setting_part', 3)->count();
            $part = ReserveSettings::first();
            // dd($part->setting_part);
            // id,data,partを渡す
            dd($day->date);

            $html[] = '<p class="d-flex m-0 p-0"><a href="/calendar/'. $day .'/'.$part->setting_part .'">1部</a></p>';
            $html[] = '<span class="d-flex m-0 p-0">'. $countOne .'</span>';

            $html[] = '<p class="d-flex m-0 p-0"><a href="/calendar">2部</a></p>';
            $html[] = '<span class="d-flex m-0 p-0">'. $countTwo .'</span>';

            $html[] = '<p class="d-flex m-0 p-0"><a href="/calendar">3部</a></p>';
            $html[] = '<span class="d-flex m-0 p-0">'. $countThree .'</span>';
          }
        }
        $html[] = '</div>';
  // ここまで

        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    return implode("", $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
