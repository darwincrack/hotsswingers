@extends('Member::member_profile')
@section('title','My Favorites')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>@lang('messages.myFavoritesMemberControl')</h4></div>

    <div class="panel-body">
      <ul class="list-model row">
        @foreach($favorites as $result)
        <li class="col-sm-4 col-md-3" id="model-{{$result->id}}">
          <div class="box-model">
            <div class="img-model">
              <a href="{{URL('profile/'.$result->username)}}"><img src="{{AppHelper::getProfileAvatar($result->smallAvatar)}}"></a>
              <a class="a-favoured active" onclick="setFavorite({{$result->ownerId}}, {{$result->id}})"><i class="fa fa-heart"></i></a>
            </div>
            <div class="text-box-model">
              <a href="{{URL('dashboard/u/'.$result->username)}}" class="name-model"><i class="fa fa-user"></i> {{$result->username}}</a>
              <p>@lang('messages.age'): {{$result->age}}</p>
              <p>@lang('messages.sex'): {{$result->gender}}</p>
              <p>@lang('messages.country'): {{$result->countryName}}</p>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
      @if(count($favorites) == 0)
      <p>@lang('messages.yourfavoriteisempty')</p>
      @endif
    </div>

    {!!$favorites->render()!!}
  </div>
@endsection