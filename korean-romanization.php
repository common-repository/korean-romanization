<?php
/*
Plugin Name: korean-romanization(한글-로마자)
Plugin URI: http://www.xuewp.com/korean-romanization/
Description: 불변링크과 슬러그를 한글-로마자변환.Convert Korean to Latin alphabets Permalinks.
Author: Chao Wang<webmaster@xuewp.com>
Version: 1.0
Author URI: http://www.xuewp.com/
*/
/*Copyright 2012 Chao Wang (email: webmaster@xuewp.com )

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
define('KOREAN_ROMANIZATION_VERSION', '1.0');
 if ( ! defined( 'WP_CONTENT_DIR' ) )
       define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
 if ( ! defined( 'WP_PLUGIN_DIR' ) )
       define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$korean_romanization_option_defaults=array('korean_romanization_separator'=>'-','korean_romanization_format'=>'lower','korean_romanization_slugs'=>'true');
if(!get_option('korean_romanization')){
add_option('korean_romanization', $korean_romanization_option_defaults, '', 'yes');}
$korean_romanization_options=get_option('korean_romanization');
$korean_romanization_options= array_merge($korean_romanization_option_defaults, $korean_romanization_options);
$korean_romanization_separator=$korean_romanization_options['korean_romanization_separator'];
$korean_romanization_format=$korean_romanization_options['korean_romanization_format'];

function KoreanRomanization($korean){
$chos = array(
"g", "kk", "n", "d", "tt", "r", "m", 
"b", "pp", "s", "ss", "", "j", "jj", 
"ch", "k", "t", "p", "h");
$jungs = array(
"a", "ae", "ya", "yae", "eo", "e", "yeo", 
"ye", "o", "wa", "wae", "oe", "yo", "u", 
"wo", "we", "wi", "yu", "eu", "ui", "i");
$jongs = array(
"", "k", "k", "ks", "n", "nj", "nh", 
"t", "l", "lg", "lm", "lp", "ls", "lt", 
"lp", "lh", "m", "p", "bs", "s", "ss", 
"ng", "j", "ch", "k", "t", "p", "h");
if (get_bloginfo('charset')!="UTF-8") {
	$korean= iconv(get_bloginfo('charset'), "UTF-8", $korean);
	}
	$retitle='';
	$korean=trim($korean);
	for($i=0;$i<strlen($korean);$i++){
    if(ord($korean[$i])>127){
	   if(ord($korean[$i])>223){
	   $code = ((ord($korean[$i])%16)*4096) + ((ord($korean[$i+1])%64)*64) + (ord($korean[$i+2])%64);
	      if ($code>=44032 && $code<=55203) {
          $tmp = $code-44032;
          $cho = (int)($tmp/588);
          $jung = (int)(($tmp%(588)/28));
          $jong = (int)($tmp%28);
          $retitle.='-'.$chos[$cho].$jungs[$jung].$jongs[$jong].'-';
          }
	   $i+=2;}
	   else
	   {$i+=1;}
	}
	else if( preg_match('/[a-z0-9]/i',$korean[$i]) ){
    $retitle .= $korean[$i];
    }
    else{
    $retitle .= '-';
    }
}	
    $retitle =trim(preg_replace('/-+/', '-', $retitle),'-');
	return $retitle ;
}

function korean_romanization_specials($title)
 {
    global $korean_romanization_format,$korean_romanization_separator;
	if($korean_romanization_format=='ucwords'){
	$title=str_replace('-',' ',$title);
	$title=ucwords($title);
	$title=str_replace(' ','-',$title);
	}
	if($korean_romanization_format=='upper'){
	$title=strtoupper($title);
	}
	if($korean_romanization_separator=='_'){
	$title=str_replace('-','_',$title);
	}
	if($korean_romanization_separator=='no'){
	$title=str_replace('-','',$title);
	}
    return $title; 
}

function korean_romanization_slugs($slug) {
	if ($slug) return $slug;
	$title = $_POST['post_title'];
	$title = KoreanRomanization($title);
	return $title;
}


if ($korean_romanization_options['korean_romanization_slugs']=='true'){
add_filter('sanitize_title', 'KoreanRomanization', 1);}
else{
add_filter('name_save_pre', 'korean_romanization_slugs', 0);}
if ($korean_romanization_separator!='-' || $korean_romanization_format!='lower'){
add_filter('sanitize_title', 'korean_romanization_specials',99);}
add_action('admin_menu', 'KoreanRomanization_menu');

function KoreanRomanization_menu(){
add_options_page('한글-로마자','한글-로마자', 'manage_options', 'korean_romanization', 'KoreanRomanization_options');
}
function KoreanRomanization_options() {
global $korean_romanization_options,$korean_romanization_option_defaults;
 require_once('korean-romanization-admin.php');
}
function delete_KoreanRomanization_options() {
      delete_option('korean_romanization');
}
register_deactivation_hook(__FILE__, 'delete_KoreanRomanization_options');
?>