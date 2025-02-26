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
echo '<div class="ossn-profile-module-albums">';
$albums = new OssnAlbums;
$photos = $albums->GetAlbums($params['user']->guid);
if ($photos) {
    foreach ($photos as $photo) {
        $images = new OssnPhotos;
        $image = $images->GetPhotos($photo->guid);

        if (isset($image->{0}->value)) {
            $image = str_replace('album/photos/', '', $image->{0}->value);
            $image = ossn_site_url() . "album/getphoto/{$photo->guid}/{$image}?size=small";

        } else {
            $image = ossn_site_url() . 'components/OssnPhotos/images/nophoto-album.png';
        }

        $view_url = ossn_site_url() . 'album/view/' . $photo->guid;
        if (ossn_access_validate($photo->access, $photo->owner_guid)) {
            echo "<a href='{$view_url}'><img src='{$image}' /></a>";
        }
    }
} else {
    echo '<h3>' . ossn_print('no:albums') . '</h3>';
}
echo '</div>';
?>

</div>
</div>

<div class="ossn-widget">
    <div class="widget-heading">
        <?php echo ossn_print('photos:imagenesventa'); ?>
    </div>
        <div class="widget-contents">
            <div class="ossn-profile-module-albums">
                <?php 


                    $dataImages=$albums->GetImagesbuy($params['user']->guid);

                    if ($dataImages) {


                 
                        foreach ($dataImages as $dataImage) {
                            $url_galeria = ossn_getbaseurl('media/image-gallery/preview/').$dataImage->slug;
                            $img_url    = ossn_getbaseurl(getImageMeta($dataImage->subImage,'thumbnail230'));


                                    echo "<a href='{$url_galeria}'><img src='{$img_url}' /></a>";

                            


                        }

                    } else {
                        echo '<h3>' . ossn_print('no:albums') . '</h3>';
                    }?>
            </div>
            
        </div>
        
    
    
</div>












<div class="ossn-widget">
    <div class="widget-heading">
      <?php echo ossn_print('photos:videosventa'); ?>
    </div>
        <div class="widget-contents">
            <div class="ossn-profile-module-albums profile-compra-videos">
                <?php 


                    $dataVideos=$albums->GetVideosbuy($params['user']->guid);

                    if ($dataVideos) {


                 
                        foreach ($dataVideos as $dataVideo) {
                            $url = ossn_getbaseurl('media/video/watch/').$dataVideo->seo_url;
                           $url_img    = ossn_getbaseurl(getImageMeta($dataVideo->posterMeta,'thumbnail230'));
                            $titulo= $dataVideo->title;
                            $img_default = ossn_getbaseurl('images/videodefault.jpg');

                              echo "<div class='item-video'>";
                                    echo "<img src='{$url_img}' onerror=\"this.src='{$img_default}';\"    /><a href='{$url}' class='play-video'><i class='fa fa-caret-right'></i>
                                    </a>
                                    <div class='details'>
                                      <a href='{$url}'>{$titulo}</a>
                                    </div>";
                     
                              echo "</div>";

                        }

                    } else {
                        echo '<h3>' . ossn_print('photos:novideos') . '</h3>';
                    }?>
            </div>
            
        </div>
        
    
    
</div>



</div>

<?php 



  function getImageMeta($meta = null, $key = null) {

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