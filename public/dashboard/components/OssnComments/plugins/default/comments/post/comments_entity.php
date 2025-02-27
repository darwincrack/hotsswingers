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
$object = $params['entity_guid'];

$comments = new OssnComments;

if($params->full_view !== true){
	$comments->limit = 5;
}
if($params->full_view == true || $params['params']['full_view'] == true){
	$comments->limit = false;
	$comments->page_limit = false;
}
$comments = $comments->GetComments($object, 'entity');
echo "<div class='ossn-comments-list-e{$object}'>";
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
    $inputs = ossn_view_form('entity/comment_add', array(
        'action' => ossn_site_url() . 'action/post/comment',
        'component' => 'OssnComments',
        'id' => "comment-container-e{$object}",
        'class' => 'comment-container comment-container-e',
        'autocomplete' => 'off',
        'params' => array('object' => $object)
    ), false);

$form = <<<html
<div class="comments-item">
    <div class="row">
        <div class="col-md-1">
            <img class="comment-user-img" src="{$iconurl}" />
        </div>
        <div class="col-md-11">
            $inputs
        </div>
    </div>
</div>
html;

$form .= '<script>  Ossn.EntityComment(' . $object . '); </script>';
$form .= '<div class="ossn-comment-attachment" id="comment-attachment-container-e' . $object . '">';
$form .= '<script>Ossn.CommentImage(' . $object . ', "entity");</script>';
$form .= ossn_view_form('comment_image', array(
        'id' => "ossn-comment-attachment-e{$object}",
        'component' => 'OssnComments',
        'params' => array(
			'object' => $object,
			'type' => 'e',
		)
    ), false);
$form .= '</div>';
echo $form;
}
