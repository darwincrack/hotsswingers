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

$object = $params->guid;

$comments = new OssnComments;

if($params->full_view !== true){
	$comments->limit = 5;
}
if($params->full_view == true){
	$comments->limit = false;
	$comments->page_limit = false;
}
$comments = $comments->GetComments($object);

echo "<div class='ossn-comments-list-p{$object}'>";
if ($comments) {
    foreach ($comments as $comment) {
            $data['comment'] = get_object_vars($comment);
            echo ossn_comment_view($data);
    }
}
echo '</div>';
if (ossn_isLoggedIn()) {
	
	$user = ossn_loggedin_user();
	$iconurl = ossn_getimagenes($user->guid,'small'); 
    $inputs = ossn_view_form('post/comment_add', array(
        'action' => ossn_site_url() . 'action/post/comment',
        'component' => 'OssnComments',
        'id' => "comment-container-p{$object}",
        'class' => 'comment-container comment-container-p',
        'autocomplete' => 'off',
        'params' => array('object' => $object)
    ), false);

$form = <<<html
<div class="comments-item">
    <div class="row">
        <div class="col-md-1">
            <img class="comment-user-img darwin" src="{$iconurl}" />
        </div>
        <div class="col-md-11">
            $inputs
        </div>
    </div>
</div>
html;

$form .= '<script>  Ossn.PostComment(' . $object . '); </script>';
$form .= '<div class="ossn-comment-attachment" id="comment-attachment-container-p' . $object . '">';
$form .= '<script>Ossn.CommentImage(' . $object . ',  "post");</script>';
$form .= ossn_view_form('comment_image', array(
        'id' => "ossn-comment-attachment-p{$object}",
        'component' => 'OssnComments',
        'params' => array(
			'object' => $object,
			'type' => 'p',
		)    
	), false);
$form .= '</div>';
echo $form;
}
