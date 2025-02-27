<?php use App\Helpers\Helper as AppHelper; ?>
  <div class="row">
    <div class="col-sm-4 col-md-2">
      <ul class="menu-message">
        <li><a href="{{URL($routing.'/messages/new-thread')}}">@lang('messages.newMessage')</a></li>
        <li><a href="{{URL($routing.'/messages')}}">@lang('messages.inbox')</a></li>
        <li> <a class="active" href="{{URL($routing.'/messages/sent')}}">@lang('messages.sent')</a></li>
        <li> <a href="{{URL($routing.'/messages/trash')}}">@lang('messages.trash')</a></li>
      </ul>
    </div>
    <div class="col-sm-8 col-md-10">   
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.sent')</h4></div>
        <div class="panel-body">
          <table class="table table-main messages">
            <thead>
              <tr>
                <th class="hidden-xs"><input type="checkbox" name="checklist" class="check-all"></th>
                <th>@lang('messages.to')</th>
                <th>@lang('messages.subject')</th>
                <th class="hidden-xs"></th>
                <th>@lang('messages.action')</th>
              </tr>
            </thead>
            <tbody>
                @if(count($msgSent) > 0)
                    @foreach($msgSent as $msg)
                    <tr id="message-{{$msg->id}}">
                        <td class="hidden-xs"><input type="checkbox" name="checklist[]" value="{{$msg->id}}" class="case" autocomplete="off"></td>
                      <td><a href="{{URL($routing.'/messages/private-thread&thread_id=')}}{{$msg->id}}?tab=sent" >{{$msg->username}}</a><span class="date-message visible-xs">{{AppHelper::getDateFormat(AppHelper::formatTimezone($msg->sentDate), 'M d, Y h:i A')}}</span></td>
                      <td>
                          <a href="{{URL($routing.'/messages/private-thread&thread_id=')}}{{$msg->id}}?tab=sent" >
                              <strong>{{str_limit($msg->subject, 40)}}</strong> - <span>{{str_limit(strip_tags($msg->message), 40)}}</span>

                        </a>
                      </td>
                      <td class="hidden-xs"><span class="date-message">{{AppHelper::getDateFormat(AppHelper::formatTimezone($msg->sendTime), 'M d, Y h:i A')}}

                          </span></td>
                      <td><a onclick="return confirm('Are you sure you want to delete this ?')" href="<?=URL($routing.'/messages/private-thread&thread_id=').$msg->id."&sub-action=trash&reid=".$msg->reId.""?>"><i style="font-size: 20px; color: #FF9361" class="fa fa-trash-o"></i></a></td>
                    </tr>
                    @endforeach
                    @else 
                    <tr>
                      <td colspan="5" class="text-center">@lang('messages.Nomessagehere')</td>
                    </tr>
                    @endif
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4 hidden-xs">
          @if(count($msgSent))
          <a onclick="deleteAllMessage('sent')" class="btn btn-default">@lang('messages.deletemessage')</a>
          @endif
        </div>
        <div class="col-sm-8 text-right">
          {{$msgSent->links()}}
        </div>
      </div>


    </div>

  </div>