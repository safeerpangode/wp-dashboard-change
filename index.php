<?php
/*
 Plugin Name: SPRDH CMS Plugin
 Author: SPRDH
 Description: SPRDH CMS Plugin
 Version: 1.0
 Author URI: http://www.sprdh.com
 */

// changing the login page URL
function sprdh_custom_login_logo() {
	echo '<style type="text/css">
	 h1{
	 	width:213px !important;
		margin:0 auto 30px !important;
	 }
    h1 a { background-image:url(http://dev.sprdh.com/files/wordpress_dashboard/sprdh-logo-wordpress.png) !important;width:213px !important;height:80px !important; background-size: 100% 100% !important;}	
	.login form{padding: 26px 24px 46px 0;}
	#login form p {float: left !important;
	    margin-left: 24px !important;
	    width: 258px !important;
	}
	.login form{
		float:left !important;		
	}
	#login {
	    width: 600px !important;
		padding:60px 0 0 !important;
		height:450px;		
	}
	.login #nav{
		float:left !important;
	}
	.login #backtoblog{
		float:right !important;
	}
    </style>';
}
add_action('login_head', 'sprdh_custom_login_logo');

// changing the login page URL
function put_sprdh_url() {
	return ('http://www.sprdh.com/');
}
add_filter('login_headerurl', 'put_sprdh_url');

// changing the login page URL hover text
function put_sprdh_title() {
	return ('This website is powered by SPRDH');
}
add_filter('login_headertitle', 'put_sprdh_title');

add_action('admin_head', 'sprdh_dashboard_logo');
function sprdh_dashboard_logo() {
   echo '
      <style type="text/css">
         #wp-admin-bar-wp-logo > .ab-item .ab-icon {
         	 background-image: url(http://dev.sprdh.com/files/wordpress_dashboard/sprdh-logo-small-wordpress.png) !important;
         	 background-position:0 0 !important;
          }
      </style>
   ';
}
function sprdh_dashboard_header() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'id'    => 'wp-logo',
		'href'  => 'http://www.sprdh.com',		
		'meta'  => array(
			'title' => __('SPRDH Webs & Apps'),
			'target' => '_blank',
		),
	) );
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'sprdh_dashboard_header' );
// remove widgets
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
function hide_wp_welcome_panel()
{
if ( current_user_can( 'edit_theme_options' ) )
$ah_clean_up_option = update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
}
add_action('wp_dashboard_setup', 'hide_wp_welcome_panel' );

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

//remove theme upgrade option
add_action('admin_menu','wphidenag');
function wphidenag() {
remove_action( 'admin_notices', 'update_nag', 3 );
}

// add widgets
add_action('wp_dashboard_setup', 'sprdh_custom_dashboard_widgets');
function sprdh_custom_dashboard_widgets() {
	global $wp_meta_boxes;	
	wp_add_dashboard_widget('sprdh_help_widget', 'Welcome!! Need Help?', 'sprdh_dashboard_help');
	add_meta_box( 'sprdh_feed_widget', 'Latest News from SPRDH', 'sprdh_dashboard_feed', 'dashboard', 'side', 'high' );
	wp_add_dashboard_widget('sprdh_service_widget', 'Services from SPRDH', 'sprdh_dashboard_services');
	add_meta_box( 'sprdh_work_widget', 'Recent Works from SPRDH', 'sprdh_dashboard_work', 'dashboard', 'side', 'high' );
}

function sprdh_dashboard_help() {
	echo '<p>Welcome !! Need help? Contact the developer <a href="mailto:sprdhapps@gmail.com">here</a>. For more information visit: <a href="http://www.sprdh.com" target="_blank">www.sprdh.com</a></p>';
}
function sprdh_dashboard_services() {
	echo '
		<style type="text/css">
			#sprdh_services li {
				margin-bottom: 15px;
			}
			#sprdh_services li img {
				float: left;
				width: 50px;
				height: 50px;
				margin-right: 20px;
				border: 1px solid #ccc;
			}
			#sprdh_services li b {
				float: left;
				margin-top: 15px;
			}
			a.seemore{
				display:block;
				text-align:center;
				clear:both;
			}
		</style>
		<ul id="sprdh_services">
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/web-design.png" alt="Web Design" /><b>Web Design</b><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/web-development.png" alt="Web Development" /><b>Web Development</b><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/seo.png" alt="SEO" /><b>SEO</b><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/application-development.png" alt="Application Development" /><b>Application Development</b><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/branding.png" alt="Branding & Identity" /><b>Branding & Identity</b><br class="clear" /></li>
		</ul>
		<a class="seemore" href="http://www.sprdh.com" target="_blank">View All</a>
		';
}

function sprdh_dashboard_feed() {
	$feed = fetch_feed( 'http://www.sprdh.com/category/news/feed/' );	
	if ( ! is_wp_error( $feed) ):	
	$maxitems = $feed->get_item_quantity( 3 );
	$items = $feed->get_items( 0, $maxitems );	
	foreach ( $items as $item ):
	?>
	<p class="rss-widget">
		<a href="<?php echo $item->get_permalink(); ?>" target="_blank"><?php echo $item->get_title(); ?></a> <span class="rss-date"><?php echo $item->get_date( 'F j, Y' ); ?></span><br />
		<?php echo $item->get_description(); ?>
	</p>
	<?php
	endforeach;
	else:
	?>
	<p>There was an error fetching the Theme.fm feed, please try again later</p>
	<?php
	endif;
	?>	
	<p class="description">&mdash; Read more on <a href="http://sprdh.com">SPRDH</a></p>
	<?php
	}
	
function sprdh_dashboard_work() {
	echo '
	<style type="text/css">
	#sprdh_works{
		float:left;
	}
	#sprdh_works  li{
		float:left;
		width:160px;
		margin-right:20px;			
	}
		#sprdh_works img{
			width:160px;
			height:94px;	
			border:1px solid #666;		
		}
		a.seemore{
				display:block;
				text-align:center;
				clear:both;
			}
	</style>
	<div>
		<ul id="sprdh_works">
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/1.jpg" alt="1" /><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/2.jpg" alt="2" /><br class="clear" /></li>
			<li><img src="http://dev.sprdh.com/files/wordpress_dashboard/3.jpg" alt="3" /><br class="clear" /></li>
		</ul>
		<a class="seemore" href="http://www.sprdh.com/works/web" target="_blank">View All</a>
		<br class="clear" />
	</div>
     ';
}
	
	function sp_edit_footer()
	{
	    add_filter( 'admin_footer_text', 'sp_edit_text', 11 );
	}
	
	function sp_edit_text($content) {
		echo '
	      <style type="text/css">
	         #footer-upgrade {
	         	 display:none;
	          }
	      </style>
	   ';
		$sp_link = '<a href="http://sprdh.com" target="_blank">SPRDH</a>';
	    return "Powered by $sp_link with Wordpress ";
	}
	add_action( 'admin_init', 'sp_edit_footer' );


?>
