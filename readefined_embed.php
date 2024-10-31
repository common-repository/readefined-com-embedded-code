<?php
	/*
	Plugin Name: Readefined.com Embedded Code
	Plugin URI:  https://readefined.com/t/wordpress
	Description: For Readefined.com users: Install this plugin to insert the Readefined reading engagement monitoring script in your property. Don't have an account? Create one at https://readefined.com
	Version:     1.01
	Author:      Readefined.com
	Author URI:  https://readefined.com
	License:     GPL2
	License URI: https://www.gnu.org/licenses/gpl-2.0.html
	*/
		
	function rewordly_readefined_code() {
		
		$args = array(
		    'body' => array('host' => $_SERVER['HTTP_HOST']),
		    'timeout' => '5',
		    'redirection' => '5',
		    'httpversion' => '1.0',
		    'blocking' => true,
		    'headers' => array(),
		    'cookies' => array()
		);
		 
		$response = wp_remote_post('https://readefined.com/t/getcode',$args);
		$handle = wp_remote_retrieve_body($response);
		
		// Handle is not empty, and handle is only letters, numbers, dashes
		if(!empty($handle) && !preg_match('/[^A-Za-z0-9-]/', $handle)) {
			
			// If not found, comment error
			if($handle == "404") {
				?>
					<!-- No property found on Readefined matching domain <?php echo $_SERVER['HTTP_HOST']; ?> -->
				<?php
			} 
			// Otherwise echo code
			else {
			    ?>
			        <script type="text/javascript" id="rwrd-reading-<?php echo $handle; ?>">(function(){var a=window;function b(){var e=document.createElement("script"),c="https://publisher.knld.gr/t/<?php echo $handle; ?>",d=document.getElementById("rwrd-reading-<?php echo $handle; ?>");e.type="text/javascript";e.async=true;e.src=c+(c.indexOf("?")>=0?"&":"?")+"rwref="+encodeURIComponent(a.location.href)+"&v=1";d.parentNode.insertBefore(e,d)}if(a.attachEvent){a.attachEvent("onload",b)}else{a.addEventListener("load",b,false)}})();
					</script>
			    <?php
			}
		}
	}
	add_action('wp_head', 'rewordly_readefined_code');
	
?>