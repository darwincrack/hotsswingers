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

define('__OSSN_SEARCH__', ossn_route()->com . 'OssnSearch/');
require_once(__OSSN_SEARCH__ . 'classes/OssnSearch.php');

function ossn_search() {
    ossn_register_page('search', 'ossn_search_page');
    ossn_add_hook('search', "left", 'search_menu_handler');

    ossn_extend_view('css/ossn.default', 'css/search');
}

function search_menu_handler($hook, $type, $return) {
    $return[] = ossn_view_menu('search');
    return $return;
}

function ossn_search_page($pages) {
    $page = $pages[0];
    if (empty($page)) {
        $page = 'search';
    }
    ossn_trigger_callback('page', 'load:search');
    switch ($page) {
        case 'search':
            //buscador desde aqui
            $etnia[1] = input('etnico1');
            $etnia[2] = input('etnico2');
            $etnia[3] = input('etnico3');
            $etnia[4] = input('etnico4');
            $etnia[5] = input('etnico5');
            $etnia[6] = input('etnico6');
            $etnia[7] = input('etnico7');
            $localidad = input('pais');
            $rangoedad[1] = input('rangoellamenos');
            $rangoedad[2] = input('rangoellamas');
            $rangoedad[3] = input('rangoelmenos');
            $rangoedad[4] = input('rangoelmas');
            $foto         = input('foto');
            $estatus         = input('validado');
            $preferencia[1] = input('preferencia1');
            $preferencia[2] = input('preferencia2');
            $preferencia[3] = input('preferencia3');
            $preferencia[4] = input('preferencia4');
            $preferencia[5] = input('preferencia5');
            $preferencia[6] = input('preferencia6');
            $preferencia[7] = input('preferencia7');
            $preferencia[8] = input('preferencia8');
            $preferencia[9] = input('preferencia9');
            $preferencia[10] = input('preferencia10');
            $preferencia[11] = input('preferencia11');
            $preferencia[12] = input('preferencia12');
    
            $gustos[1]  = input('gustos1');
            $gustos[2]  = input('gustos2');
            $gustos[3]  = input('gustos3');
            $gustos[4]  = input('gustos4');
            $gustos[5]  = input('gustos5');
            $gustos[6]  = input('gustos6');
            $gustos[7]  = input('gustos7');
            $gustos[8]  = input('gustos8');
            $gustos[9]  = input('gustos9');
            $gustos[10] = input('gustos10');
            $gustos[11] = input('gustos11');
            $gustos[12] = input('gustos12');
            $gustos[13] = input('gustos13');
            $gustos[14] = input('gustos14');
            $gustos[15] = input('gustos15');
            $gustos[16] = input('gustos16');
            $gustos[17] = input('gustos17');
            $gustos[18] = input('gustos18');
            $gustos[19] = input('gustos19');
            $gustos[20] = input('gustos20');
            $gustos[21] = input('gustos21');
            $gustos[22] = input('gustos22');
            $gustos[23] = input('gustos23');


            $fisionomiaella[1] = input('ellaDelgada');
            $fisionomiaella[2] = input('ellaAtletica');
            $fisionomiaella[3] = input('ellaNormal');
            $fisionomiaella[4] = input('ellaKilosextras');
            $fisionomiaella[5] = input('ellaRellenoa');

            $fisionomiael[1] = input('elDelgada');
            $fisionomiael[2] = input('elAtletica');
            $fisionomiael[3] = input('elNormal');
            $fisionomiael[4] = input('elKilosextras');
            $fisionomiael[5] = input('elRellenoa');

            $alturael[1] = input('alturamenosel');
            $alturael[2] = input('alturamasella');

            $alturaella[1] = input('alturamenosella');
            $alturaella[2] = input('alturamasella');


            $experiencia[1] = input('Novatoa');
            $experiencia[2] = input('Ocasional');
            $experiencia[3] = input('Experimentadoa');
            $experiencia[4] = input('Descubriendo');



            $gender[1] = input('gender1');
            $gender[2] = input('gender2');
            $gender[3] = input('gender3');
            $gender[4] = input('gender4');
            
            /*
            print_r($alturaella);
            die;
            */
            $online = input('online');
          //  print_r($gender);
          //  die();

            if(!empty(input('q'))){
                $cadena =input('q');
            }
            else
            {
                $cadena ="";

            }

            $query = input('q');
            $type = input('type');
            $title = ossn_print("search:result", array($query));
            if (empty($type)) {
                $params['type'] = 'users';
            } else {
                $params['type'] = $type;
            }
            $type = $params['type'];
            if (ossn_is_hook('search', "type:{$type}")) {
                $contents['contents'] = ossn_call_hook('search', "type:{$type}", array('q' => $cadena ,'etnia' => $etnia, 'localidad'=> $localidad , 'rangoedad'=> $rangoedad, 'foto'=> $foto, 'validado'=> $estatus , 'preferencia' => $preferencia, 'gustos'=> $gustos , 'alturaella' => $alturaella , 'alturael'=> $alturael , 'fisionomiaella' => $fisionomiaella, 'fisionomiael' => $fisionomiael , 'online' => $online, 'experiencia' => $experiencia, 'gender'=>$gender ));
            }




            $contents = array('content' => ossn_plugin_view('search/pages/search', $contents),);
            $content = ossn_set_page_layout('search', $contents);
            echo ossn_view_page($title, $content);
            break;
        default:
            ossn_error_page();
            break;
    }
}

ossn_register_callback('ossn', 'init', 'ossn_search');
 