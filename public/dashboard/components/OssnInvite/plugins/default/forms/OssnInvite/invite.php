<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

	$user = ossn_loggedin_user();

	$vuser=ossn_user_by_guid($user->guid); 
	$url = ossn_getbaseurl("r/{$vuser->referral_code}");

?>
<div class="ossn-invite-friends">
    <p><?php echo ossn_print('com:ossn:invite:friends:note');?></p>
    
	<label><?php echo ossn_print('com:ossn:invite:emails:note');?></label>
    <textarea rows="4" name="addresses" placeholder="<?php echo ossn_print("com:ossn:invite:emails:placeholder");?>"></textarea>
    
    <label><?php echo ossn_print('com:ossn:invite:message');?></label>
    <textarea name="message"></textarea>
    
	<input type="submit" class="btn btn-primary" value="<?php echo ossn_print('com:ossn:invite');?>"/> 

<p></p>	 
<p></p>	 


<div class="widget-heading" style="margin-top: 40px; margin-bottom: 20px;"><?php echo ossn_print('com:ossn:invite:a');?></div>


<p><?php echo ossn_print('com:ossn:invite:b');?></p>
<p><?php echo ossn_print('com:ossn:invite:c');?></p>



<div class="input-group">

<input type="text" class="form-control" id="referralLink" readonly value="<?php echo $url; ?>">

    <span class="input-group-btn">
    <button class="btn btn-primary" type="button"  onclick="copyReferralLink()" style="    height: 38px;
    margin-top: -4px;"><i class="fa fa-copy"></i> <?php echo ossn_print('com:ossn:invite:d');?></button>
  </span>
</div>


</div>

<script>
  function copyReferralLink() {
    var input = document.getElementById("referralLink");

    // Select the input
    input.select();
    // For mobile devices
    input.setSelectionRange(0, 99999); 

    // Copy the text inside the input
    document.execCommand("copy");

    // Confirmed copied text
    alert("<?php echo ossn_print('com:ossn:invite:e');?> " + input.value);
}
</script>