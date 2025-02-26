<div>
<table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
 <tbody>
   
   <tr>
      <td style=" width: 100%" >
          <strong>@lang('messages.dear') <?=$email?>,</strong><br>
           <br>
           <span class="il">@lang('messages.youraccountpassword') </span> <strong><?=$newPassword?></strong> , @lang('messages.pleasefollowtheinstructions')<br>

     </td>
   </tr>
   <tr style="margin-bottom: 15px;"><td></td></tr>
   <tr>
      <td>
         <ol>
            <li>
               <a href="<?=URL('verifypassword?token=').$token?>" target="_blank">@lang('messages.clickhere')</a> @lang('messages.tocomplete').
            </li>
            <li>
                @lang('messages.iftheabovelink')<br>
                <a style="white-space:pre-wrap" href="<?=URL('verifypassword?token=').$token?>" target="_blank"><?=URL('verifypassword?token=').$token?></a>
            </li>
         </ol>
      </td>    
   </tr>
  <tr>
      <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
  </tr>
</tbody>
</table>
</div>