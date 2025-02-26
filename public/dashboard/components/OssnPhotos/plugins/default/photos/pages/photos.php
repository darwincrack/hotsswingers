<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
echo '<div class="ossn-photos">';
$albums = new OssnAlbums;
$profile = new OssnProfile;

$photos = $albums->GetAlbums($params['user']->guid);

$albums->count = true;
$count = $albums->GetAlbums($params['user']->guid);
$profiel_photo = $params['user']->iconURL()->larger;
$pphotos_album = ossn_site_url("album/profile/{$params['user']->guid}");

$profile_covers_url = ossn_site_url("album/covers/profile/{$params['user']->guid}");
$profile_cover = $profile->getCoverURL($params['user']);
//show profile pictures album
/*echo "<li>
	<a href='{$pphotos_album}'><img src='{$profiel_photo}' class='pthumb' />
	 <div class='ossn-album-name'>" . ossn_print('profile:photos') . "</div></a>
	</li>";
//show profile cover photos	
echo "<li>
	<a href='{$profile_covers_url}'><img src='{$profile_cover}' class='pthumb' />
	 <div class='ossn-album-name'>" . ossn_print('profile:covers') . "</div></a>
	</li>";*/	
if ($photos) {
    foreach ($photos as $photo) {
        if (ossn_access_validate($photo->access, $photo->owner_guid)) {
            $images = new OssnPhotos;
            $image = $images->GetPhotos($photo->guid);
            if (isset($image->{0}->value)) {
                $image = str_replace('album/photos/', '', $image->{0}->value);
                $image = ossn_site_url() . "album/getphoto/{$photo->guid}/{$image}?size=album";

            } else {
                $image = ossn_site_url() . 'components/OssnPhotos/images/nophoto-album.png';
            }

            $view_url = ossn_site_url() . 'album/view/' . $photo->guid;
            if (ossn_access_validate($photo->access, $photo->owner_guid)) {
                echo "<li>
	<a href='{$view_url}'><img src='{$image}' class='pthumb' />
	 <div class='ossn-album-name'>{$photo->title}</div></a>
	</li>";
            }
        }
    }
}
?>
</div>
<?php
echo ossn_view_pagination($count);
?>




<br>
<br>
<div class="module-title">
    <div class="title"><?php echo ossn_print('photos:imagenesventa'); ?> </div>
        <div class="controls">


        </div>


</div>

<!--<div class="pull-right">
                  <a class="btn btn-link pull-left" href="<?php //echo ossn_getbaseurl('media/image-galleries')?>">Todas la galeria <i class="fa fa-caret-right"></i></a>


              </div>

              <div style="clear: both;"></div> -->

<?php 

$dataImages=$albums->GetImagesbuy($params['user']->guid);

if ($dataImages) {
echo "<div class='ossn-photos'>";
    foreach ($dataImages as $dataImage) {
        $url_galeria = ossn_getbaseurl('media/image-gallery/preview/').$dataImage->slug;
        $img_url    = ossn_getbaseurl(getImageMeta($dataImage->subImage,'thumbnail230'));
         echo "<li>
            <a href='{$url_galeria}'><img src='{$img_url}' class='pthumb' />
             <div class='ossn-album-name'>{$dataImage->name}</div></a>
            </li>";


    }
echo '</div>';


}?>
    




<div class="module-title">
    <div class="title"><?php echo ossn_print('photos:videosventa'); ?></div>
        <div class="controls">


        </div>


</div>

<div class=" ossn-photos profile-compra-videos" style="    margin-top: 10px;">


<?php 
  $dataVideos=$albums->GetVideosbuy($params['user']->guid);


                    if ($dataVideos) {


                 
                        foreach ($dataVideos as $dataVideo) {
                           $url = ossn_getbaseurl('media/video/watch/').$dataVideo->seo_url;
                           $url_img    = ossn_getbaseurl(getImageMeta($dataVideo->posterMeta,'thumbnail230'));
                            $titulo= $dataVideo->title;
                            $img_default = ossn_getbaseurl('images/videodefault.jpg');

                              echo "<div class='item-video'>";
                                    echo "<img src='{$url_img}' onerror=\"this.src='{$img_default}';\" style='    width: auto;'/><a href='{$url}' class='play-video' style='top: 33%;'><i class='fa fa-caret-right'></i>
                                    </a>
                                    <div class='details'>
                                      <a href='{$url}' style='font-size: 16px;
    font-weight: bold;'>{$titulo}</a>
                                    </div>";
                     
                              echo "</div>";

                        }

                    }else {
                        echo '<h3>' . ossn_print('photos:novideos') . '</h3>';
                    }?>
</div>













  <?php function getImageMeta($meta = null, $key = null) {

    if (is_serialized($meta)) {
        $imageMeta = unserialize($meta);

      if ($key && isset($imageMeta[$key])) {
        return $imageMeta[$key];
      }
 
      return null;
    }
  }





   
  function is_serialized($data, $strict = true) {
    // if it isn't a string, it isn't serialized.
    if (!is_string($data)) {
      return false;
    }
    $data = trim($data);
    if ('N;' == $data) {
      return true;
    }
    if (strlen($data) < 4) {
      return false;
    }
    if (':' !== $data[1]) {
      return false;
    }
    if ($strict) {
      $lastc = substr($data, -1);
      if (';' !== $lastc && '}' !== $lastc) {
        return false;
      }
    } else {
      $semicolon = strpos($data, ';');
      $brace = strpos($data, '}');
      // Either ; or } must exist.
      if (false === $semicolon && false === $brace)
        return false;
      // But neither must be in the first X characters.
      if (false !== $semicolon && $semicolon < 3)
        return false;
      if (false !== $brace && $brace < 4)
        return false;
    }
    $token = $data[0];
    switch ($token) {
      case 's' :
        if ($strict) {
          if ('"' !== substr($data, -2, 1)) {
            return false;
          }
        } elseif (false === strpos($data, '"')) {
          return false;
        }
      // or else fall through
      case 'a' :
      case 'O' :
        return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
      case 'b' :
      case 'i' :
      case 'd' :
        $end = $strict ? '$' : '';
        return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }
    return false;
  }

?>