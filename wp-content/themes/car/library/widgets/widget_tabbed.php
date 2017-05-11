<?php
/*
 */

/**
 * tabd function to widgets_init that'll lotab our widget.
 */
add_action( 'widgets_init', 'uxde_Tab_Widget' );

/**
 * Register widget.
 */
function uxde_Tab_Widget() {
	register_widget( 'uxde_Tab_Widget' );
}

/*
 * Widget class.
 */
class uxde_Tab_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function uxde_Tab_Widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'tab_widget', 'description' => __('A tabbed widget that display popular posts, recent posts and comments.', 'uxde') );

		/* Widget control settings */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tab_widget' );

		/* Create the widget */
		$this->WP_Widget( 'tab_widget', __('ITFS - Tabbed Widget', 'uxde'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$tab1 = $instance['tab1'];
		$tab2 = $instance['tab2'];
		$posts = $instance['posts'];
		
		echo $before_widget;


		$tab = array();
		
		?>
        <div class="tabsview">
            <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active first" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><i class="fa fa-rocket"></i> <?php echo $tab1; ?></a></li>
                    <li class="ui-state-default ui-corner-top last" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><i class="fa fa-eye"></i> <?php echo $tab2; ?></a></li>
                </ul>
                <div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                    <div class="list-posts">
                        <ul>
            			<?php 
							$recentPosts = new WP_Query(array(
								'ignore_sticky_posts' => 1,
								'posts_per_page' 	  => $posts,
								'tax_query' => array(
			                        array(
								        'taxonomy' => 'post_format',
								        'field'    => 'slug',
								        'terms'    => array('post-format-video'),
								        'operator' => 'NOT IN'
				                    ),
								),
							));							
							if ($recentPosts->have_posts()) : $count = 0;
							while ($recentPosts->have_posts()) : $recentPosts->the_post(); 
							global $post; $count++; ?> 

                            <li class="first">
                                <span class="number"><?php echo $count; ?></span>
                                  <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </li>

                        	<?php endwhile; endif; ?>
                       
                        <?php wp_reset_query(); ?>                            
                        </ul>
                    </div>
                </div>
                <div id="tabs-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                    <div class="list-posts">
                        <ul>
            			<?php
							$popPosts = new WP_Query(array(
								'ignore_sticky_posts' => 1,
								'posts_per_page' 	  => $posts,
								'orderby'			  => 'comment_count',
								'tax_query' => array(
			                        array(
								        'taxonomy' => 'post_format',
								        'field'    => 'slug',
								        'terms'    => array('post-format-video'),
								        'operator' => 'NOT IN'
				                    ),
								),
							));
						
							if ($popPosts->have_posts()) : $count = 0; 
							while ($popPosts->have_posts()) : $popPosts->the_post(); global $post; $count++; ?>   

                            <li class="first">
                                <span class="number"><?php echo $count; ?></span>
                                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </li> 

                        	<?php endwhile; endif; ?>                       
                        	<?php wp_reset_query(); ?>                                                         
                        </ul>
                    </div>
                </div>
            </div>
            <script>
                jQuery(function() {
                     jQuery( "#tabs" ).tabs();
                });
            </script>
        </div>        
        
        
		<?php		
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['tab1'] = $new_instance['tab1'];
		$instance['tab2'] = $new_instance['tab2'];
		$instance['posts'] = $new_instance['posts'];
		
		return $instance;
	}
	
	function form( $instance ) {
	
		$defaults = array(
		'title' => '',
		'tab1' => 'Popular',
		'tab2' => 'Recent',
		'posts' => '4',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- tab 1 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Tab 1 Title:', 'uxde') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $instance['tab1']; ?>" />
		</p>
		
		<!-- tab 2 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e('Tab 2 Title:', 'uxde') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $instance['tab2']; ?>" />
		</p>

		<!-- Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'posts' ); ?>"><?php _e('Number of Posts:', 'uxde') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts' ); ?>" name="<?php echo $this->get_field_name( 'posts' ); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
		
	
	<?php
	}
}
?>