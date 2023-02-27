<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // dd($subjects);  ここ！
    if(is_null($gender)){
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }
    $users = User::with('subjects')
    ->where(function($q) use ($keyword){
      // 複数カラムでどれかの検索条件に一致
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    ->where(function($q) use ($role, $gender){
      // 特定カラムで複数の検索条件に一致
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    // リレーション先テーブルも検索条件に含む
    ->whereHas('subjects', function($q) use ($subjects){
      // dd($subjects);
      $q->whereIn('subjects.id', $subjects);
    })
    ->orderBy('over_name_kana', $updown)->get();
    return $users;
  }

}
// 複数のカラムで複数の検索条件に一致
// whereIn→orWhere
