@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="row">
  <div class="col-sm-4 col-md-2">
    <ul class="menu-message">
      <li><a {{ Request::is('models/dashboard/messages/new-thread') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/new-thread')}}">@lang('messages.newMessage')</a></li>
      <li><a {{ Request::is('models/dashboard/messages') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages')}}">@lang('messages.inbox')</a></li>
      <li><a {{ Request::is('models/dashboard/messages/sent') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/sent')}}">@lang('messages.Sent')</a></li>
      <li><a {{ Request::is('models/dashboard/messages/trash') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/trash')}}">@lang('messages.trash')</a></li>
    </ul>
  </div>
  {{Widget::CreateMessage('',isset($toModel)? $toModel->username :'',URL('models/dashboard'))}}
</div>
@endsection