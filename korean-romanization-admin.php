<?php
/*
korean-romanization(한글-로마자)
http://www.xuewp.com/korean-romanization/
불변링크과 슬러그를 한글-로마자변환.Convert Korean to Latin alphabets Permalinks.
Author: Chao Wang
http://www.xuewp.com/
*/
if (isset($_POST['submit'])) {
      if ( function_exists('current_user_can') && !current_user_can('manage_options') )
            die(__('No hacking please.', 'korean_romanization'));
        check_admin_referer( 'korean_romanization-options_update');
        $korean_romanization_update=array(
         'korean_romanization_format' =>(trim($_POST['korean_romanization_format']) != '' ) ? trim($_POST['korean_romanization_format']) : $korean_romanization_option_defaults['korean_romanization_format'],
		 'korean_romanization_slugs' =>(trim($_POST['korean_romanization_slugs']) != '' ) ? trim($_POST['korean_romanization_slugs']) : $korean_romanization_option_defaults['korean_romanization_slugs'],
		 'korean_romanization_separator' =>(trim($_POST['korean_romanization_separator']) != '' ) ? trim($_POST['korean_romanization_separator']) : $korean_romanization_option_defaults['korean_romanization_separator']);
		  update_option('korean_romanization', $korean_romanization_update);
		  $korean_romanization_options=get_option('korean_romanization');
		    if (function_exists('wp_cache_flush')) {
	     wp_cache_flush();
	}
}
?>
<?php if ( !empty($_POST['submit'] ) ) : ?>
<div id="message" class="updated"><p><strong><?php _e('/(已更新)/Updated', 'korean_romanization') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2>Korean Romanization설정:(default is the best setting,just set once)</h2>
버션/Version:<?php _e(KOREAN_ROMANIZATION_VERSION, 'korean_romanization') ?> 제작:<a href="http://www.xuewp.com/korean-romanization/" title="제작자 홈페">xuewp</a>

<form method="post">
 <?php wp_nonce_field('korean_romanization-options_update'); ?>
<table class="form-table">
         <tr valign="top">
          <th scope="row"><strong>설정:</strong></th>
        
          </tr>
		  <tr valign="top">
          <th scope="row">분리/separator:</th>
     <td>
          <input type="radio" name="korean_romanization_separator" value="-" <?php if( $korean_romanization_options['korean_romanization_separator']=='-')echo 'checked';?> >하이픈(hypen)-  포맷/format: dae-han-min-guk （추천/推薦/recommended）（default）
    </td>
	<tr valign="top"><td></td><td><input type="radio" name="korean_romanization_separator" value="_" <?php if( $korean_romanization_options['korean_romanization_separator']=='_')echo 'checked';?>  >Underline_  포맷/format: dae_han_min_guk </td></tr>
          </tr>    
		  <tr valign="top"><td></td><td><input type="radio" name="korean_romanization_separator" value="no" <?php if( $korean_romanization_options['korean_romanization_separator']=='no')echo 'checked';?>  >불사용/none  포맷/format: daehanminguk</td></tr>
          </tr>
		  		  <tr valign="top">
          <th scope="row">대소문자</th>
     <td>
          <input type="radio" name="korean_romanization_format" value="lower" <?php if( $korean_romanization_options['korean_romanization_format']=='lower')echo 'checked';?> >소문자/lowercase 예:han （deault） 
    </td>
	<tr valign="top"><td></td><td><input type="radio" name="korean_romanization_format" value="ucwords" <?php if( $korean_romanization_options['korean_romanization_format']=='ucwords')echo 'checked';?>  >ucwords 예:Han (uppercase for the first letter)</td></tr>
          </tr>    
		  <tr valign="top"><td></td><td><input type="radio" name="korean_romanization_format" value="upper" <?php if( $korean_romanization_options['korean_romanization_format']=='upper')echo 'checked';?>  >대문자/uppercase 예:HAN</td></tr>
          </tr>
		  		  <tr valign="top">
          <th scope="row">카테고리과 태그 설정/Using this plugin for categories and tags:</th>
     <td>
          <input type="radio" name="korean_romanization_slugs" value="true" <?php if( $korean_romanization_options['korean_romanization_slugs']=='true')echo 'checked';?>  />사용/enable（default)
    </td>
	<tr valign="top"><td></td><td><input type="radio" name="korean_romanization_slugs" value="false" <?php if( $korean_romanization_options['korean_romanization_slugs']=='false')echo 'checked';?> >불사용/disable </td></tr>
          </tr>  
          </table>
        <p class="submit">
         <input type="submit" name="submit" value=" 갱신(更新)/Update&raquo; " />
       </p>
     </form>
	<p>Thanks for using this plugin!</p>
<p>other plugins of xuewp.com:<a href="http://www.xuewp.com/chinese-captcha/">wordpress chinese catpcha</a></p>
  </div>
