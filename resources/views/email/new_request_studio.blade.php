<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0"
         style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      <tr>
        <td style=" width: 100%" >
          <strong>@lang('messages.dear'),</strong><br>
          <br>
          <p>@lang('messages.youhavereceivednewrequest') #{{$studio->id}} - {{$studio->username}}</p>
        </td>
      </tr>
      <tr>
        <td style=" width: 100%">
          <h4>@lang('messages.requestinformation')</h4>

          <p>
            <strong>@lang('messages.fromdate'): </strong> {{$request->dateFrom}}
          </p>
          <p>
            <strong>@lang('messages.todate'): </strong> {{$request->dateTo}}
          </p>
          <p>
            <strong>@lang('messages.toaccountinfo'): </strong> {!! $request->payoutInfo !!}
          </p>
          <div>
            <strong>@lang('messages.comment'): </strong> {!! $request->comment !!}
          </div>
          <div class="clearfix"></div>
          <p>
            <strong>@lang('messages.requestat'): </strong> {{$request->createdAt}}
          </p>
        </td>
      </tr>
      <tr style="margin-bottom: 15px;"><td></td></tr>
      <tr>
        <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
      </tr>
    </tbody>
  </table>
</div>    