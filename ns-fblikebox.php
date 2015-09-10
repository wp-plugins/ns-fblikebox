<?php
    /*
     * Plugin Name: NS Facebook Likebox
     * Plugin URI: http://netscripter.info
     * Author: NetScripter
     * Author URI: http://netscripter.info
     * Description: This is Facebook Likebox Widget for WordPress.
     * Version: 1.1
     */

    add_action('widgets_init','register_netscripter_fblikebox');

    function register_netscripter_fblikebox()
    {
    	register_widget('netscripter_Fblikebox');
    }

    class netscripter_Fblikebox extends WP_Widget{

    	function netscripter_Fblikebox()
    	{
    		parent::__construct( 'netscripter_fblikebox','Netscripter Facebook Likebox',array('description' => 'This is Facebook Likebox Widget for WordPress.'));
    	}

/**
 * Front-End Display.
 */

	function widget( $args, $instance )
	{
		extract( $args );

		add_action( 'wp_enqueue_scripts', function(){
			wp_enqueue_style( 'facebook_like',plugins_url('css/facebook.css',__FILE__) );
		});

		global $post;
		$temp_result = $post;

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		
		$like_url 			= $instance['like_url'];
		$apps_id	 		= $instance['apps_id'];
		$like_width 		= $instance['like_width'];
		$like_height 		= $instance['like_height'];
		$like_show_face     = empty($instance['like_show_face']) ? 0 : $instance['like_show_face'];
		$color 				= $instance['color'];
		$like_stream     	= empty($instance['like_stream']) ? 0 : $instance['like_stream'];
		$like_border     	= empty($instance['like_border']) ? 0 : $instance['like_border'];
		$like_header     	= empty($instance['like_header']) ? 0 : $instance['like_header'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		echo '<div id="fb-root"></div>';
		echo '<script>';
		echo '(function(d, s, id) {';
			echo 'var js, fjs = d.getElementsByTagName(s)[0];';
			echo 'if (d.getElementById(id)) return;';
			echo 'js = d.createElement(s); js.id = id;';
			echo 'js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$apps_id.'";';
			echo 'fjs.parentNode.insertBefore(js, fjs);';
			echo '}(document, "script", "facebook-jssdk"));';
echo '</script>';
echo '<div class="fb-like-box" data-href="'.$like_url.'" data-width="'.$like_width.'" data-height="'.$like_height.'" data-show-faces="'.$like_show_face.'" colorscheme="'.$color.'" data-stream="'.$like_stream.'" data-show-border="'.$like_border.'" data-header="'.$like_header.'"></div>';

echo $after_widget;
}

/**
 * Sanitize data.
 */

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['like_url'] 			= $new_instance['like_url'];
		$instance['apps_id'] 			= $new_instance['apps_id'];
		$instance['like_width'] 		= $new_instance['like_width'];
		$instance['like_height'] 		= $new_instance['like_height'];
		$instance['like_show_face'] 	= $new_instance['like_show_face'];
		$instance['color'] 				= $new_instance['color'];
		$instance['like_stream'] 		= $new_instance['like_stream'];
		$instance['like_border'] 		= $new_instance['like_border'];
		$instance['like_header'] 		= $new_instance['like_header'];

		return $instance;
	}


/**
 * Back-End Display.
 */
	
	function form( $instance )
	{

		$defaults = array(  
			'title' 			=> 'Be Our Fan',
			'apps_id'			=> '',
			'like_url' 			=> '',
			'like_width' 		=> '200px',
			'like_height' 		=> '300px',
			'like_show_face' 	=> 1,
			'color' 			=> 'light',
			'like_stream' 		=> 1,
			'like_border' 		=> 1,
			'like_header' 		=> 1

			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'apps_id' ); ?>"><?php _e('Apps Id:'); ?></br>
			</label><a href="https://www.facebook.com/help/community/question/?id=529591157094317" target="_blank">FB-ID Help</a>
			<input class="widefat" id="<?php echo $this->get_field_id('apps_id');?>" name="<?php echo $this->get_field_name('apps_id'); ?>" value="<?php echo $instance['apps_id']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'like_url' ); ?>"><?php _e('Facebook Page URL:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('like_url');?>" name="<?php echo $this->get_field_name('like_url'); ?>" value="<?php echo $instance['like_url']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'like_width' ); ?>"><?php _e('Width:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('like_width');?>" name="<?php echo $this->get_field_name('like_width'); ?>" value="<?php echo $instance['like_width']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'like_height' ); ?>"><?php _e('Height:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('like_height');?>" name="<?php echo $this->get_field_name('like_height'); ?>" value="<?php echo $instance['like_height']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('like_show_face'); ?>"><?php _e('Show Face:'); ?></label>
			<input type="checkbox" class="" id="<?php echo $this->get_field_id('like_show_face'); ?>" name="<?php echo $this->get_field_name('like_show_face'); ?>" value="1" <?php checked( $instance['like_show_face'],1 ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Color Scheme:'); ?></label>

			<select class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>">
				<option value="dark" <?php if($instance['color'] == "dark") echo 'selected="selected"'; ?>>Dark</option>
				<option value="light" <?php if($instance['color'] == "light") echo 'selected="selected"'; ?>>Light</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('like_stream'); ?>"><?php _e('Show stream:'); ?></label>
			<input type="checkbox" class="" id="<?php echo $this->get_field_id('like_stream'); ?>" name="<?php echo $this->get_field_name('like_stream'); ?>" value="1" <?php checked( $instance['like_stream'],1 ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('like_border'); ?>"><?php _e('Show Border:'); ?></label>
			<input type="checkbox" class="" id="<?php echo $this->get_field_id('like_border'); ?>" name="<?php echo $this->get_field_name('like_border'); ?>" value="1" <?php checked( $instance['like_border'],1 ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('like_header'); ?>"><?php _e('Show Header:'); ?></label>
			<input type="checkbox" class="" id="<?php echo $this->get_field_id('like_header'); ?>" name="<?php echo $this->get_field_name('like_header'); ?>" value="1" <?php checked( $instance['like_header'],1 ); ?> />
		</p>

		<?php
	}
}