@extends('Member::member_profile')
@section('title','Funds /Tokens')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="panel panel-default">
  <div class="panel-heading"><h4>@lang('messages.promocion') </h4></div>
  <div class="panel-body">
    <div class="col-sm-12 col-md-12 col-xs-12">


      <h4><i class="fa fa-link"></i> @lang('messages.ganadinero')</h4>

      <p>@lang('messages.1299') </p>

      <p>@lang('messages.1300') </p>




<div class="input-group">

<input type="text" class="form-control" id="referralLink" readonly value="{{route('referral.link', ['referralCode' => $getMember->referral_code])}}">

    <span class="input-group-btn">
    <button class="btn btn-primary" type="button"  onclick="copyReferralLink()" style="height: 34px;"><i class="fa fa-copy"></i> @lang('messages.1301')</button>
  </span>
</div>

    </div>
  </div>
</div>

<script>
  function copyReferralLink() {
    var input = document.getElementById("referralLink");

    // Select the input
    input.select();
    // For mobile devices
    input.setSelectionRange(0, 99999); 

    // Copy the text inside the input
    document.execCommand("copy");

    // Confirmed copied text
    alert("@lang('messages.1302') " + input.value);
}
</script>

@endsection