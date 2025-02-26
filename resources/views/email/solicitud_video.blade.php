<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      
      <tr>
        <td style=" width: 100%" >
          <strong>@lang('messages.Hello'),</strong><br>
          <br>
            <p>El usuario {{ $username }}, ha creado un video.</p>

            El video:  <strong>{{$video->name}}</strong> <br>

           ver video para aprobar o rechazar: <a style="white-space:pre-wrap" href="<?=URL('media/video/watch/'.$video->seo_url)?>" target="_blank"><?=URL('media/video/watch/'.$video->seo_url)?></a>

          <br>
        </td>
      </tr>
      <tr style="margin-bottom: 15px;"><td></td></tr>
      <tr>
          <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>    
      </tr>
    </tbody>
  </table> 
</div>