<?php
/**
 * Plugin Name: Koha Login Widget
 * Plugin URI: http://www.koha-community.org
 * Description: Adds a login box for your Koha catalog
 * Version: 1.2
 * Author: Liz Rea
 * Author URI: http://www.koha-community.org
 */

/**
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'koha_login_load_widgets' );

/**
 * Register our widget.
 */
function koha_login_load_widgets() {
	register_widget( 'Koha_Login_Widget' );
}

/**
 * Load Internationalization
 */
load_plugin_textdomain('koha', false, dirname(plugin_basename(__FILE__)).'/lang');


class Koha_Login_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Koha_Login_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'koha', 'description' => __('Easily adds Koha Login boxes to your blog', 'koha') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'koha-login-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'koha-login-widget', __('Koha Login', 'koha'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$url = $instance['name'];
	
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $url )
			echo '<form action="' . $url . '/cgi-bin/koha/opac-user.pl" method="post" name="auth" id="auth">
    <input type="hidden" name="koha_login_context" value="opac" />
		<ol>
		<li><label for="userid">'. __('Login:', 'koha') .'</label><input type="text" id="userid" size="10" name="userid" /></li>
		<li><label for="password">'. __('Password:', 'koha') .'</label><input type="password" id="password" size="10" name="password" /></li>
		</ol>	 
	 <input type="submit" value="'. __('Log In', 'koha') .'" class="submit" />
	</form>
';



		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Log In to the Catalog', 'koha'), 'name' => __('http://catalog.nexpresslibrary.org', 'koha'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('URL of your catalog (ex: http://catalog.nexpresslibrary.org):', 'koha'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>
		</p>

	<?php
	}
}

?>
