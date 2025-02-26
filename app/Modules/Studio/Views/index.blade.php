@extends('Studio::studioDashboard')
@section('title','Studio Profile')
@section('contentDashboard')
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
            <a class="btn btn-dark" href="">@lang('messages.performersOnline')</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!--user header end-->
<div class="studio-cont"> <!--user's info-->
  <div class="user-mailbox-folder-name">
    @lang('messages.performersOnline')
  </div>
  <div class="row form-group">
    <div class="col-xs-12">
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="filter-col" for="pref-search"><i class="fa fa-search"></i> @lang('messages.search'):</label>
          <input type="text" class="form-control" id="pref-search">
        </div><!-- form group [search] -->
        <div class="form-group">
          <label class="filter-col" for="pref-perpage">@lang('messages.onlineStatus'):</label>
          <select id="pref-perpage" class="form-control">
            <option value="2">@lang('messages.all')</option>
            <option value="3">@lang('messages.active')</option>
            <option value="3">@lang('messages.suspended')</option>
          </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
          <label class="filter-col" for="pref-orderby">@lang('messages.sortBy'):</label>
          <select id="pref-orderby" class="form-control">
            <option>@lang('messages.onlineStatus')</option>
            <option>@lang('messages.username')</option>
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
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> @lang('messages.model')</a></p>
          <p> 22 / @lang('messages.female') / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>@lang('messages.details')</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>@lang('messages.commission')</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>@lang('messages.memberChat')</strong>&nbsp;(offline)</div>
          <p><strong>@lang('messages.since'):</strong> 13-05-2014 5:19 PM</p>
          <div><strong>@lang('messages.membersOnly')</strong></div>
          <p><strong>@lang('messages.lastLogin'):</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>@lang('messages.memberChat')</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#">@lang('messages.model')</a></p>
          <p> 22 / @lang('messages.female') / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>@lang('messages.details')</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>@lang('messages.commission')</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>@lang('messages.memberChat')</strong>&nbsp;(offline)</div>
          <p><strong>@lang('messages.since'):</strong> 13-05-2014 5:19 PM</p>
          <div><strong>@lang('messages.membersOnly')</strong></div>
          <p><strong>@lang('messages.lastLogin'):</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>@lang('messages.memberChat')</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> @lang('messages.model')</a></p>
          <p>22 / @lang('messages.female') / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>@lang('messages.details')</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>@lang('messages.commission')</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>@lang('messages.memberChat')</strong>&nbsp;(offline)</div>
          <p><strong>@lang('messages.since'):</strong> 13-05-2014 5:19 PM</p>
          <div><strong>@lang('messages.membersOnly')</strong></div>
          <p><strong>@lang('messages.lastLogin'):</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>@lang('messages.memberChat')</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#">@lang('messages.model')</a></p>
          <p>@lang('messages.faceid')22 / Female / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>@lang('messages.details')</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>@lang('messages.commission')</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>@lang('messages.memberChat')</strong>&nbsp;(offline)</div>
          <p><strong>@lang('messages.since'):</strong> 13-05-2014 5:19 PM</p>
          <div><strong>@lang('messages.membersOnly')</strong></div>
          <p><strong>@lang('messages.lastLogin'):</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>@lang('messages.memberChat')</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
    </table>
    <nav>
      <ul class="pagination">
        <li>
          <a href="#" aria-label="Previous" class="disabled">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div> <!--user's info end-->
@endsection