<?php
namespace App\Calendars\General;

// 前月、次月を出力するためのクラス
// 日カレンダーをカスタマイズして、クラス名とHTMLだけ別の処理になるようなクラスを作成
class CalendarWeekBlankDay extends CalendarWeekDay{
  function getClassName(){
    return "day-blank";
  }

  /**
   * @return
   */

  //  何も出力しないように上書き
   function render(){
     return '';
   }

   function selectPart($ymd){
     return '';
   }

   function getDate(){
     return '';
   }

   function cancelBtn(){
     return '';
   }

   function everyDay(){
     return '';
   }

}
