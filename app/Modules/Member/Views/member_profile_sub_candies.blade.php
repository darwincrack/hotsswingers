@extends('Member::member_profile')
@section('title','Funds /Tokens')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="panel panel-default">
  <div class="panel-heading"><h4>@lang('messages.fundsOrTokens')</h4></div>
  <div class="panel-body">
    <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="row fun-show">
       
          <div class="box-grey">
            <div class="row">
              <div class="col-xs-6">
                <strong>@lang('messages.Youhave') {{$getMember->tokens}} tokens</strong>
              </div>
            </div>
          </div>
      </div>

      <h4>@lang('messages.buyMoreTokens')</h4>

      <div class="row">
        <?php 
        if($paymentSetting && $packages){
          foreach ($packages as $item){
            ?>
        <div class="col-sm-6 col-md-3 col-xs-12">
          <div class="box-buy">
            <h2><?php echo $item->tokens;?> Tokens</h2>
            <strong><?php echo $item->price;?> €</strong>



            <a class="btn btn-danger btn-block" href="{{asset('members/payments/'.$item->id)}}">@lang('messages.buy')</a>
          </div>
        </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
@endsection