<?php
/**
 * @package KSTNewsticker
 */
/*
Plugin Name: KST News Ticker Plugin
Plugin URI: https://www.facebook.com/ksthannan
Description: You can use it easily in your news, blog, magazine or any website. Use this shortcode &nbsp;&nbsp;&nbsp;[kst_news_ticker] 
Version: 1.0.0
Author: Hannan
Author URI: https://www.facebook.com/ksthannan
License: GPLv2 or later
Text Domain: kst_ticker
*/




/*
Requiring File
*/
require_once('wordpress-settings-api-class-master/plugin.php');

// functions for style register and calling
 function newsticker_script(){
	define('TICKER_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

	wp_enqueue_script('jquery');
	
	wp_enqueue_style('bootstrap', TICKER_PLUGIN_URL . 'css/style.css');

	wp_enqueue_script('newsticker_custom', TICKER_PLUGIN_URL . 'js/custom.js' );
	wp_enqueue_script('newsticker_ticker', TICKER_PLUGIN_URL . 'js/jquery.webticker.js');

	
}

add_action('init','newsticker_script');


add_shortcode('kst_news_ticker','news_ticker_shortcode');
function news_ticker_shortcode(){
	ob_start();
	$data_ticker_color = get_option( 'kst_ticker_color' );
	?>
	
	<style type="text/css">
		.webnewsticker {
		  background: <?php if(isset($data_ticker_color['kst_total_background_color'])){echo $data_ticker_color['kst_total_background_color'];} else {echo "#fff";}?>
		}	

		.head_line_text::after{
			background: <?php if(isset($data_ticker_color['kst_total_background_color'])){echo $data_ticker_color['kst_total_background_color'];} else {echo "#fff";}?>;
		}

		ul#webTicker{list-style: square url("<?php if(isset($data_ticker_color['kst_bullet_file'])){echo $data_ticker_color['kst_bullet_file'];} else{echo TICKER_PLUGIN_URL.'img/bullet.png';}?>");}

		ul#webTicker li a{color:<?php if(isset($data_ticker_color['kst_text_fonts_color'])){echo $data_ticker_color['kst_text_fonts_color'];} else {echo "#3B94CF";}?>}

		ul#webTicker li a:hover{color: <?php if(isset($data_ticker_color['kst_text_hover_color'])){echo $data_ticker_color['kst_text_hover_color'];} else {echo "#266290";}?>}

		.head_line_text h2 {
		  border-right: 3px solid <?php if(isset($data_ticker_color['background_color'])){echo $data_ticker_color['background_color'];} else {echo "#fff";}?>;
		  background: <?php if(isset($data_ticker_color['background_color'])){echo $data_ticker_color['background_color'];} else {echo "#3B94CF";}?>;
		  color: <?php if(isset($data_ticker_color['headline_fonts_color'])){echo $data_ticker_color['headline_fonts_color'];} else {echo "#fff";}?>;
		}
	</style>
		<div class="webnewsticker">
			<div class="head_line_text"><h2>
			<?php 
				$data_ticker_basic = get_option( 'kst_ticker_basics' );
					if(isset($data_ticker_basic['text_val']) && $data_ticker_basic['number_input'] && $data_ticker_basic['head_text_none'] && $data_ticker_basic['head_text']){ 
						$kst_header = $data_ticker_basic['head_text'];
						$kst_post_type = $data_ticker_basic['text_val'];
						$kst_number = $data_ticker_basic['number_input'];
						$kst_none = $data_ticker_basic['head_text_none'];
						} 
					else{
						$kst_post_type =  "post";
						$kst_number = 10;
						$kst_none = "<h2>Opps, No content available.</h2>";
						$kst_header = "Headline";
						}	
						
					_e($kst_header,'kst_ticker');
				
					
					?>	
				</h2></div>
			<div class="new_ticker">
				<ul id="webTicker">
				<?php 		

					$args_ticker = array(
						'post_type' => $kst_post_type,
						'posts_per_page' => $kst_number,
					);
					$query_ticker = new WP_Query($args_ticker);
					if($query_ticker ->have_posts()): while($query_ticker ->have_posts()): $query_ticker ->the_post();
					?>
					<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
					
					<?php endwhile;
					else: 
					_e($kst_none,'kst_ticker');
					endif;
					
					?>
					
				</ul>							
			</div>						
		</div>		
	
	<?php 

	$clean_code = ob_get_clean();
	return $clean_code;

}





