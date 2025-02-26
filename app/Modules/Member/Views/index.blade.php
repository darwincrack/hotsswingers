@extends('frontend')
@section('title','Login')
@section('content')

<div class="container">
  <div class="content">
    <div class="title">Laravel 5</div>
    {{ Widget::run('createFeed') }}

    <?php if (!isset($_GET['id'])) : ?>
      <h4>@lang('messages.missingRoomGoToHome')</h4>
    <?php else : ?>
      <div ng-include="'{{URL('app/views/chat-room.html')}}'"></div>
    <?php endif; ?>
  </div>
</div>

@endsection
