<?php
/*-----------------------------------------------------------------------------------*/
/*	Video Widget Class
/*-----------------------------------------------------------------------------------*/

class THR_Video_Widget extends WP_Widget { 

	function THR_Video_Widget() {
		$widget_ops = array( 'classname' => 'thr_video_widget', 'description' => __('You can easily place YouTube or Vimeo video here', THEME_SLUG) );
		$control_ops = array( 'id_base' => 'thr_video_widget' );
		$this->WP_Widget( 'thr_video_widget', __('Throne Video', THEME_SLUG), $widget_ops, $control_ops );
	}

	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		
		echo $before_widget;

		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		?>
		<div class="video-widget-inside">
		<?php if(!empty($instance['video_id'])) : ?>
			<?php if($instance['type'] == 'youtube') : ?>
			
				<iframe width="100%" height="<?php echo absint($instance['height']); ?>" src="http://www.youtube.com/embed/<?php echo esc_attr($instance['video_id']); ?>?showinfo=0;controls=0" frameborder="0" allowfullscreen></iframe>
			
			<?php elseif($instance['type'] == 'vimeo') : ?>
			
				<iframe width="100%" height="<?php echo absint($instance['height']); ?>" src="http://player.vimeo.com/video/<?php echo esc_attr($instance['video_id']);?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php endif; ?>
			
		<?php endif; ?>
		
		<?php if(!empty($instance['content'])) : ?>
			<?php echo wpautop($instance['content']);?>
		<?php endif; ?>
		
		<div class="clear"></div>
		
		</div>
		
		<?php
		echo $after_widget;
	}

	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['video_id'] = strip_tags( $new_instance['video_id'] );
		$instance['type'] = $new_instance['type'];
		$instance['height'] = absint($new_instance['height']);
		$instance['content'] = $new_instance['content'];
		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 
				'title' => __('Video', THEME_SLUG),
				'video_id' => '',
				'type' => 'youtube',
				'height' => 180,
				'content' => ''
			);
			
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', THEME_SLUG); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
		
		<p>
			<label><?php _e('Video type', THEME_SLUG); ?>:</label><br/>
			<input type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="youtube" <?php checked($instance['type'],'youtube'); ?>/>
			<label><?php _e('YouTube', THEME_SLUG); ?></label><br/>
			<input type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="vimeo" <?php checked($instance['type'],'vimeo'); ?>/>
			<label><?php _e('Vimeo', THEME_SLUG); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'video_id' ); ?>"><?php _e('Video ID', THEME_SLUG); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'video_id' ); ?>" type="text" name="<?php echo $this->get_field_name( 'video_id' ); ?>" value="<?php echo esc_attr($instance['video_id']); ?>" class="widefat" />
			<small><?php _e('ID example', THEME_SLUG); ?>: XsEMu5UCy0g</small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', THEME_SLUG); ?>: </label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" type="text" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo absint($instance['height']); ?>" class="small-text" /> px
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Description (optional)', THEME_SLUG); ?>:</label>
			<textarea id="<?php echo $this->get_field_id( 'content' ); ?>" rows="5" name="<?php echo $this->get_field_name( 'content' ); ?>" class="widefat"><?php echo $instance['content']; ?></textarea>
		</p>
		
	<?php
	}
}

?>