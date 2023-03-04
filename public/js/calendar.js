$(function () {
  // 編集ボタン(class="js-modal-open")が押されたら発火
  $('.js-modal-open').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから取得し変数へ格納
    var day = $(this).attr('day');
    var part = $(this).attr('part');
    // モーダルの中身へ渡す
    $('.modal_day').text(day);
    $('.modal_part').text(part);
    $('.modal_day').val(day);
    $('.modal_part').val(part);

    return false;
  });

  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });

});
