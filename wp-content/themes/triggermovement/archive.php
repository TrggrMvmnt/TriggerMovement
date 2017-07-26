<?php get_header(); ?>

<div id="page-header-wrap" data-midnight="light" style="height: 350px;">	 
	<div id="page-header-bg" data-animate-in-effect="none" data-text-effect="" data-bg-pos="center" data-alignment="left" data-alignment-v="center" data-parallax="0" data-height="350" style="height: 350px; overflow: visible;">

		<div class="page-header-bg-image" style="background-image: url(/wp/wp-content/uploads/2014/04/questions.jpg);"></div> 

		<div class="container">
			<div class="row" style="top: 0px; visibility: visible;">
				<div class="col span_6" style="top: 163.25px;">
                    <div class="inner-wrap">
                        <span class="subheader" style="transform: rotateX(0deg) translate(0px, 0px); opacity: 1;">
							Category:
						</span>
						<h1 style="transform: rotateX(0deg) translate(0px, 0px); opacity: 1;"><?php echo get_cat_name( $cat ); ?></h1>
					
					</div>
                    					
				</div>
			</div>
					
		</div>
	</div>

</div>

<div class="container-wrap">
		
	<div class="container main-content">
		
		<div class="row">

			<?php echo do_shortcode('[vc_row type="full_width_content" full_screen_row_position="middle" equal_height="yes" scene_position="center" text_color="light" text_align="left" bottom_padding="50" id="cat-cols" overlay_strength="0.3"][vc_column centered_text="true" column_padding="padding-2-percent" column_padding_position="all" background_color="#303AB2" background_color_opacity="1" background_color_hover="#0f9fff" background_hover_color_opacity="1" column_shadow="none" width="1/4" tablet_text_alignment="default" phone_text_alignment="default" column_border_width="none" column_border_style="solid" column_link="/category/strategy/"][vc_column_text]Strategy[/vc_column_text][/vc_column][vc_column centered_text="true" column_padding="padding-2-percent" column_padding_position="all" background_color="#CE0037" background_color_opacity="1" background_color_hover="#cc2a2a" background_hover_color_opacity="1" column_shadow="none" width="1/4" tablet_text_alignment="default" phone_text_alignment="default" column_border_width="none" column_border_style="solid" column_link="/category/leadership/"][vc_column_text]Leadership[/vc_column_text][/vc_column][vc_column centered_text="true" column_padding="padding-2-percent" column_padding_position="all" background_color="#39815A" background_color_opacity="1" background_color_hover="#5c995a" background_hover_color_opacity="1" column_shadow="none" width="1/4" tablet_text_alignment="default" phone_text_alignment="default" column_border_width="none" column_border_style="solid" column_link="/category/digital/"][vc_column_text]Digital[/vc_column_text][/vc_column][vc_column centered_text="true" column_padding="padding-2-percent" column_padding_position="all" background_color="#cccc00" background_color_opacity="1" background_color_hover="#E0CC39" background_hover_color_opacity="1" column_shadow="none" width="1/4" tablet_text_alignment="default" phone_text_alignment="default" column_border_width="none" column_border_style="solid" column_link="/category/web-development/"][vc_column_text]Web Development[/vc_column_text][/vc_column][/vc_row]'); ?>



			<?php $options = get_nectar_theme_options(); 
			
			$blog_type = $options['blog_type'];
			if($blog_type == null) $blog_type = 'std-blog-sidebar';
			
			$masonry_class = null;
			$masonry_style = null;
			$infinite_scroll_class = null;
			$load_in_animation = (!empty($options['blog_loading_animation'])) ? $options['blog_loading_animation'] : 'none';
			$blog_standard_type = (!empty($options['blog_standard_type'])) ? $options['blog_standard_type'] : 'classic';

			//enqueue masonry script if selected
			if($blog_type == 'masonry-blog-sidebar' || $blog_type == 'masonry-blog-fullwidth' || $blog_type == 'masonry-blog-full-screen-width') {
				$masonry_class = 'masonry';
			}
			
			if($blog_type == 'masonry-blog-full-screen-width') {
				$masonry_class = 'masonry full-width-content';
			}
			
			if(!empty($options['blog_pagination_type']) && $options['blog_pagination_type'] == 'infinite_scroll'){
				$infinite_scroll_class = ' infinite_scroll';
			}

			if($masonry_class != null) {
				$masonry_style = (!empty($options['blog_masonry_type'])) ? $options['blog_masonry_type']: 'classic';
			}

			if($blog_standard_type == 'minimal' && $blog_type == 'std-blog-fullwidth')
				$std_minimal_class = 'standard-minimal full-width-content';
			else if($blog_standard_type == 'minimal' && $blog_type == 'std-blog-sidebar')
				$std_minimal_class = 'standard-minimal';
			else
				$std_minimal_class = '';
			
			if($blog_type == 'std-blog-sidebar' || $blog_type == 'masonry-blog-sidebar'){
				echo '<div id="post-area" class="col '.$std_minimal_class.' span_9 '.$masonry_class.' '.$masonry_style.' '. $infinite_scroll_class.'"> <div class="posts-container"  data-load-animation="'.$load_in_animation.'">';
			} else {
				echo '<div id="post-area" class="col '.$std_minimal_class.' span_12 col_last '.$masonry_class.' '.$masonry_style.' '. $infinite_scroll_class.'"> <div class="posts-container"  data-load-animation="'.$load_in_animation.'">';
			}
	
				if(have_posts()) : while(have_posts()) : the_post(); ?>
					
					<?php 
		
					if ( floatval(get_bloginfo('version')) < "3.6" ) {
						//old post formats before they got built into the core
						 get_template_part( 'includes/post-templates-pre-3-6/entry', get_post_format() ); 
					} else {
						//WP 3.6+ post formats
						 get_template_part( 'includes/post-templates/entry', get_post_format() ); 
					} ?>
	
				<?php endwhile; endif; ?>
				
				</div><!--/posts container-->
				
			<?php nectar_pagination(); ?>
				
			</div><!--/span_9-->
			
			<?php  if($blog_type == 'std-blog-sidebar' || $blog_type == 'masonry-blog-sidebar') { ?>
				<div id="sidebar" class="col span_3 col_last">
					<?php get_sidebar(); ?>
				</div><!--/span_3-->
			<?php } ?>
		
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>