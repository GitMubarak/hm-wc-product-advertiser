<?php
/**
*	Front Parent Class
*/
class HMWPA_Front 
{	
	private $hmwpa_version;

	function __construct( $version ){
		$this->hmwpa_version = $version;
		$this->hmwpa_assets_prefix = substr(HMWPA_PRFX, 0, -1) . '-';
	}
	
	function hmwpa_front_assets(){
		$hmwpa_settings = stripslashes_deep(unserialize(get_option('hmwpa_settings')));
		wp_enqueue_style(	'hmwpa-front-style',
							HMWPA_ASSETS . 'css/' . $this->hmwpa_assets_prefix . 'front-style.css',
							array(),
							$this->hmwpa_version,
							FALSE );
		if(is_array($hmwpa_settings)){
			$hmwpaTitleColor = (esc_attr($hmwpa_settings['hmwpa_post_title_color'])!='') ? esc_attr($hmwpa_settings['hmwpa_post_title_color']) : '#242424';
			$hmwpaParentBorderColor = (esc_attr($hmwpa_settings['hmwpa_parent_border_color'])!='') ? esc_attr($hmwpa_settings['hmwpa_parent_border_color']) : '#242424';
			$hmwpaBgColor = (esc_attr($hmwpa_settings['hmwpa_background_color'])!='') ? esc_attr($hmwpa_settings['hmwpa_background_color']) : '#F2F2F2';
		} else{
			$hmwpaTitleColor = "#242424";
			$hmwpaParentBorderColor = "#242424";
			$hmwpaBgColor = "#F2F2F2";
		}
		$hmwpaCustomCss = "	#hmwpa_scroll_box{
								border-left: 1px solid {$hmwpaParentBorderColor};
								border-top: 1px solid {$hmwpaParentBorderColor};
								-moz-box-shadow: 0 0 15px {$hmwpaParentBorderColor};
								-webkit-box-shadow: 0 0 15px {$hmwpaParentBorderColor};
								box-shadow: 0 0 15px {$hmwpaParentBorderColor};
								background: {$hmwpaBgColor};
							}
							.hmwpa-content-parent .hmwpa-content a.hmwpa-title{
								color: {$hmwpaTitleColor}!important;
							}
							";
		wp_add_inline_style( 'hmwpa-front-style', $hmwpaCustomCss );

		// =======================================
		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}
		wp_enqueue_script(  'hmwpa-front-script',
							HMWPA_ASSETS . 'js/hmwpa-front-script.js',
							array('jquery'),
							$this->hmwpa_version,
							TRUE );
		
		wp_localize_script( 'hmwpa-front-script', 'wsAjaxObject', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}

	function hmwpa_load_shortcode(){
		add_shortcode( 'wp_scroll_post', array( $this, 'hmwpa_load_shortcode_view' ) );
	}
	
	function hmwpa_load_shortcode_view($hmwpaAttr){
		$output = '';
		ob_start();
		include HMWPA_PATH . 'front/view/' . $this->hmwpa_assets_prefix . 'front-view.php';
		$output .= ob_get_clean();
		return $output;
	}

	function hmwpa_load_view(){
		include HMWPA_PATH . 'front/view/' . $this->hmwpa_assets_prefix . 'front-view.php';
	}

	function hmwpa_load_scroll_post(){
		if(is_array(stripslashes_deep(unserialize(get_option('hmwpa_settings'))))){
			$hmwpa_settings = stripslashes_deep(unserialize(get_option('hmwpa_settings')));
			$displayCategory = (isset($hmwpa_settings[ 'hmwpa_post_category' ])) ? $hmwpa_settings[ 'hmwpa_post_category' ] : "";
		} else{
			$displayCategory = "";
		}
		$hmwpaArgs = array(
							'post_type' 		=> 'product',
							'orderby'   		=> 'rand',
							'posts_per_page'	=> 1
							);
		if($displayCategory != ""){
			$hmwpaArgs['tax_query'] = array(
											array(
												'taxonomy'	=> 'product_cat',
												'field' 	=> 'term_id',
												'terms'     =>  $displayCategory,
												'operator'  => 'IN'
												)
											);
		}
		$hmwpaTheQuery = new WP_Query( $hmwpaArgs );
		 
		if ( $hmwpaTheQuery->have_posts() ) { ?>
		 
			<div class="hmwpa-content-parent">
			<?php while ( $hmwpaTheQuery->have_posts() ) { $hmwpaTheQuery->the_post(); global $product; ?>
				<div class="hmwpa-thumbnail">
					<?php 
					if(has_post_thumbnail()):
						the_post_thumbnail( 'thumbnail' ); 
					else: ?>
						<img src="<?php echo HMWPA_ASSETS . 'img/wp-default.png'; ?>">
					<?php endif; ?>
				</div>
				<div class="hmwpa-content">
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="hmwpa-title">
						<?php the_title(); ?>
					</a>
					<p class="hmwpa-time-category">
						Price: <?php echo $product->get_price() . ' ' . get_option('woocommerce_currency'); ?> | <?php echo $product->get_categories(); ?>
					</p>
				</div>
			<?php } ?>
			</div>
			<?php
			wp_reset_postdata();
		} else {
			echo "no prodcuts found";
		}
		die();
	}
}
?>