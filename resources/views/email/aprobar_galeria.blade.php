<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      
      <tr>
        <td style=" width: 100%" >
          <strong>@lang('messages.Hello') {{ $username }},</strong><br>
          <br>
          Su galería o imagen <strong>{{$name_galeria}}</strong> ha sido aprobada.<br>

           ver galería: <a style="white-space:pre-wrap" href="<?=URL('models/dashboard/media/image-gallery/'.$id_galeria)?>" target="_blank"><?=URL('models/dashboard/media/image-gallery/'.$id_galeria)?></a>
        </td>
      </tr>

      <tr style="margin-bottom: 15px;"><td></td></tr>
      <tr>
          <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>    
      </tr>
    </tbody>
  </table> 
</div>