@extends('Studio::studioDashboard')
@section('title','Helps And Support')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">@lang('messages.helpAndSupport')</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>@lang('messages.haveProblemHereIsWhatYouNeedToSolveIt')</span>
          <div class="help-block">@lang('messages.weWantYouToFeelComfortableWithUsing') {{app('settings')->siteName}}. @lang('messages.toMakeItEasierForYou')
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="row form-group">
      <div class="col-xs-12">
         <form action="{{URL('studio/helps')}}" class="form-inline" role="form">
          <div class="form-group help_srch">
            <label class="filter-col" for="pref-search"><i class="fa fa-search"></i> @lang('messages.search'):</label>
            <input type="text" name="helpSearch" class="form-control" id="pref-search">
          </div><!-- form group [search] -->
          <div class="form-group  help_srch">
            <button type="submit" class="btn btn-rose">
              @lang('messages.search')
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
    @if(isset($helpSearch))
        <div class="col-sm-6 col-lg-12">
            <ul class="list-group">
          @foreach($helpSearch as $result)
              <li class="list-group-item list-group-item-warning">
                <i class="fa fa-question-circle"></i> <a  style="color :#000;" href="<?=URL('studio/helps/categories').'_'.$result->catId.'_'.$result->id.'/'.str_slug($result->helpName)?>">{{$result->helpName}}</a>
              </li>
          @endforeach
            </ul>
        </div>
    @else
        @foreach($helps as $resultCat)
        @if(count(AppHelper::getHelpItems($resultCat->id))>0)
          <div class="col-sm-6 col-lg-4">
            <div class="panel">
              <div class="panel-heading">
                <div class="panel-title">
                  <strong>{{$resultCat->titleName}}</strong>
                </div>
              </div>
              <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                  @foreach(AppHelper::getHelpItems($resultCat->id) as $resultItem)
                  <li><a href="<?=URL('studio/helps/categories').'_'.$resultCat->id.'_'.$resultItem->id.'/'.str_slug($resultItem->helpName)?>">{{$resultItem->helpName}}</a></li>
                  @endforeach
                </ul>
                <div class="text-right help-block">
                  <a href="<?=URL('studio/helps/categories_').$resultCat->id?>">@lang('messages.viewAllArticles')</a>
                </div>
              </div>
            </div>
          </div>
          @endif
        @endforeach
    @endif
    </div>
  </div>
</div> <!--user's info end-->
<style type="text/css" media="screen">
ul{
  margin: 0;
}
</style>
@endsection