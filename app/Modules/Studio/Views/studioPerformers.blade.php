@extends('Studio::studioDashboard')
@section('title','Performers')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">@lang('messages.performers')</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>@lang('messages.yourPerformers')</span>
        </div>
        <div class="dashboard_tabs_wrapper">
          <div class="pull-left">
            <!-- <a class="btn btn-dark pull-left" href="">All Performers</a>
            <a class="btn btn-dark pull-left" href="">Performers Online</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!--user header end-->
<div class="studio-cont" ng-controller="ModelOnlineCtrl"> <!--user's info-->
  <div class="user-mailbox-folder-name">
    @lang('messages.performersOnline')
  </div>
  <div class="row form-group">
    <div class="col-xs-12">
      <form class="form-inline" action="{{URL('studio/performers')}}" role="form">
        <div class="form-group">
          <label class="filter-col"  for="pref-search"><i class="fa fa-search"></i> @lang('messages.search'):</label>
          <input type="text" name="modelSearch" class="form-control" id="pref-search">
        </div><!-- form group [search] -->
        <div class="form-group">
          <label class="filter-col" for="pref-perpage">@lang('messages.onlineStatus'):</label>
          <select id="pref-perpage" name="modelOnlineStatus" style="max-width:100% " class="form-control">
            <option value="all">@lang('messages.all')</option>
            <option value="active">@lang('messages.active')</option>
            <option value="suspend">@lang('messages.suspended')</option>
          </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
          <label class="filter-col"  for="pref-orderby">Sort by:</label>
          <select id="pref-orderby" name="modelSort" style="max-width:100% " class="form-control">
            <option value="online">@lang('messages.onlineStatus')</option>
            <option value="username">@lang('messages.username')</option>
          </select>
        </div> <!-- form group [order by] -->
        <div class="form-group">
          <button type="submit" class="btn btn-rose filter-col">
            @lang('messages.search')
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table_online">
      <tr>
        <th>@lang('messages.image')</th>
        <th>@lang('messages.info')</th>
        <th>@lang('messages.onlineStatus')</th>
        <th>@lang('messages.chatStatus')</th>
      </tr>
      @if(!empty($models))
      @foreach($models as $result)
      <tr>
        <td>
          <img src="<?=AppHelper::modelCheckThumb($result->avatar,IMAGE_SMALL)?>" alt=""/>
        </td>
        <td>
          <p><a href="{{URL('profile')}}/{{$result->username}}"> <?=$result->username?></a></p>
          <p><?=$result->age.'/'.$result->gender.'/'.$result->countryName?></p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>@lang('messages.paid')Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>@lang('messages.paid')Commission</a>
          </div>
        </td>
        <td>
          <div>{{ ($result->isStreaming) ? 'Online' : 'Offline' }}</div>
          <p><strong>@lang('messages.since'):</strong> <?=AppHelper::getModelSince($result->createdAt)?></p>
          <div><strong>@lang('messages.membersOnly')</strong></div>
          <p><strong>@lang('messages.lastLogin'):</strong> <?php echo AppHelper::formatTimezone($result->logoutTime); ?></p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>@lang('messages.memberChat')</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      @endforeach
      @else
      <tr>
      <td align="center" colspan="4">@lang('messages.noResultFound')</td>
      </tr>
      @endif
    </table>
    <nav>
      {!!$models->render()!!}
    </nav>
  </div>
</div> <!--user's info end-->
@endsection