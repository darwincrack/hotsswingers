<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0"
         style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      <tr>
        <td style=" width: 100%; text-align: center;  font-size: 14px;" >
         <p><strong>{{$user->username}} </strong> está emitiendo</p> 
         <br> 
        </td>
      </tr>


       <tr>
        <td style=" width: 100%; font-size: 14px;" >

          <p style="text-align: center;">¡{{$data->username}}, míralo antes que termine!</p>
        </td>
      </tr>

      <tr>
        <td style=" width: 100%;" >
         
          <br>
          <p style="    text-align: center;
    font-size: 20px; ;
    font-weight: bold;"><a href="https://implik-2.com/profile/{{$user->username}}">Ver su cam</a> </p>
        </td>
      </tr>

      <tr style="margin-bottom: 15px;"><td><br><br></td></tr>
      <tr>
        <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
      </tr>
    </tbody>
  </table>
</div>