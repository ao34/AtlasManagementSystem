@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <!-- カレンダータイトル -->
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
      <!-- カレンダー表示 -->
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<div class="modal js-modal">
<div class="modal__bg js-modal-close"></div>
<div class="modal__content">
<form action="/delete/calendar" method="post" id="deleteParts">
<p >予約日：
<span class="modal_day" name="data" value=""></span>
<input type="hidden" class="modal_day" name="data" value="" form="deleteParts">
</p>
<p>時間：リモ
<span class="modal_part" name="part" value=""></span>
<input type="hidden" class="modal_part" name="part" value="" form="deleteParts">
部</p>
<p>上記の予約をキャンセルしてよろしいですか？</p>
<button type="" class="js-modal-close btn btn-primary p-0 w-75" style="font-size:12px">閉じる</button>
<button type="submit" class="btn btn-danger p-0 w-75" style="font-size:12px">キャンセル</button>
{{ csrf_field() }}
</form>
</div>
</div>

@endsection

<!-- @section('modal_window')
  <div class="modal js-modal">
    @parent
  </div>

@endsection -->

    <!-- $html[] = '';
    $html[] = '<div class="modal__bg js-modal-close"></div>';
    $html[] = '<div class="modal__content">';
    $html[] = '<form action="'. route('deleteParts') .'" method="post" id="deleteParts">'.csrf_field().
    $html[] = '<input type="hidden" class="id" name="id" value="">';
    $html[] = '<p >予約日：';
    $html[] = '<span class="modal_day" value=""></span>';
    $html[] = '</p>';
    $html[] = '<p>時間：</p>';
    $html[] = '<p>上記の予約をキャンセルしてよろしいですか？</p>';
    $html[] = '<button type="" class="js-modal-close btn btn-primary p-0 w-75" style="font-size:12px">閉じる</button>';
    $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" style="font-size:12px">キャンセル</button>';
    $html[] = '</form>';
    $html[] = '</div>';
    $html[] = ''; -->
