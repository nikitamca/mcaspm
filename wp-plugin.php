<?php
/*
Plugin Name: My Plugin
Plugin URI: http://localhost/wordpress/wp-admin/plugins.php
Description: This is sample plugin to test basic concepts of the plugin in wordpress CMS based website.
Version: 1.0
Author: Niku
Author URI: parmarnikita119@gmail.com

*/
function genShortcode()
{
	echo "This is short code<br>";
	echo "Hello<br>";
	echo "<input type='text' name='txt'/>";
}
add_shortcode('short','genShortcode');

function addMyPluginMenu()
{
	add_menu_page('My Plugin Configuration','My Plugin','manage_options','my-plugin-menu','myPluginFunction','',5);
}
add_action('admin_menu','addMyPluginMenu');

//-------------------------------Add Meta Box---------------------------------

add_action('add_meta_boxes','create_meta-box');
function create_meta_box()
{
	add_meta_box('meta_box_price','Add Price','meta_box_gui','post','side','default');
}
function meta_box_gui()
{
	?>
	<DIV>
		<input type='text',id='meta_price' name='meta_price'/>
	</DIV>
<?php
}
//---------------------------------------action hook to store meta value at the time of saving post


add_action('save-post','saveMetaPrice');

function saveMetaPrice($post_id)
{
	global $post;
	if(isset($_POST['meta_price']))
	{
		update_post_meta($post_id,'_meta_price',$_POST['meta_price']);
	}
}

//------------------------------Fetch meta value using short code

function getMetaPrice()
{
	global $post;
	echo "Price:". get_post_meta($post->ID,'_meta_price',true);
}
add_shortcode('price','getMetaPrice');

//------------------add short code widgets

add_action(wp_dashboard_setup,'customwidget');
function customwidget()
{
	wp_add_dashboard_widget('custom_widget','The Latest Post Title','createcustomwidget');
}
function createcustomwidget()
$data=new WP_QUERY('posts_per_page=3');
{
	?>
	<div>
		<h3>Title</h3>
		<br>
		<table>
		<?php
			while($data->have_posts()):
			$data->the_post();
		?>
			<tr><td><?=the_title()?></td></tr>
<?php
	endwhile;
?>
		</table>
	</div>
	<?php
}
?>
