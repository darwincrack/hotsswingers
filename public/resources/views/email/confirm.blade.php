<div>
<table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
 <tbody>
   <tr>
      <td style=" width: 100%" >
          <strong>@lang('messages.dear') <?=$username?>,</strong><br>
           <br>
           @lang('messages.thankyouforregistering') {{app('settings')['siteName']}} <span class="il">@lang('messages.account') </span>. @lang('messages.inordertoverify') <span class="il">account</span> (<a href="mailto:<?=$email?>" target="_blank"><?=$email?></a>) is <span class="il">@lang('messages.active')</span>, @lang('messages.pleasefollowthe'):<br>

     </td>
   </tr>
   <tr style="margin-bottom: 15px;"><td></td></tr>
   <tr>
      <td>
         <ol>
            <li>
               <a href="<?=URL('verify?token=').$token?>" target="_blank">@lang('messages.clickhere')</a> @lang('messages.tocompleteregistration').
            </li>
            <li>
                @lang('messages.iftheabovelink').<br>
                <a style="white-space:pre-wrap" href="<?=URL('verify?token=').$token?>" target="_blank"><?=URL('verify?token=').$token?></a>
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