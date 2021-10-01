<?php 
if(!function_exists('error_log_var'))
{
	function error_log_var( $object=null )
	{
		ob_start();
		print_r($object);
		$contents = ob_get_contents();
		ob_end_clean();
		error_log($contents);
	} 
}
if(!function_exists('wcGetCurrentPageURL'))
{
  function wcGetCurrentPageURL()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    $url = $url.$query;
    return $url;
  } 
}

add_filter('option_active_plugins','wc_option_active_plugins');
function wc_option_active_plugins($plugins)
{
	$remove_plugins = array( 
                          'advanced-custom-fields-pro/acf.php',
                          'header-footer/plugin.php',
                          'hurrytimer/hurrytimer.php',
                          'mailpoet/mailpoet.php',
                          'menu-image/menu-image.php',
                          'notix/notix.php'
                        );

	$disable_plugins = strpos( wcGetCurrentPageURL(), '/wp-admin/post.php?post=' );
	
	if( $disable_plugins )
	{
		$plugins = array_diff( $plugins, $remove_plugins );
	}
	return $plugins;
}