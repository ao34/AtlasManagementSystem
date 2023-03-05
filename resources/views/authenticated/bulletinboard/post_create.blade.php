@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0 title">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
          @foreach($main_categories as $main_category)
            <optgroup label="{{$main_category->main_category}}"></optgroup>
                @foreach($main_category->subCategories as $sub_category)
                  <option label="{{ $sub_category->sub_category }}" value="{{ $sub_category->id }}" ></option>
                @endforeach
          @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <p class="m-0">メインカテゴリー</p>
        @if($errors->first('main_category'))
          <span class="error_message">{{ $errors->first('main_category') }}</span>
        @endif
        <input type="text" class="w-100" name="main_category" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
        <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      </div>
      <!-- サブカテゴリー追加 -->
      <div class="">
        <p class="m-0">サブカテゴリー</p>
        @if($errors->first('sub_category'))
          <span class="error_message">{{ $errors->first('sub_category') }}</span>
        @endif
        <form action="/create/sub_category" method="post" id="subCategoryRequest">
          <select class="w-100" name="main_category_id">
            @foreach($main_categories as $main_category)
              <option hidden >---</option>
              <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
            @endforeach
          </select>
          <input type="text" class="w-100" name="sub_category">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0">
        {{ csrf_field() }}
        </form>
      </div>
    </div>
  </div>
  @endcan
</div>
@endsection
