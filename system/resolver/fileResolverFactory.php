<?php

require_once SYSTEM . 'resolver/fileResolver.php';

class fileResolverFactory
{
	function get()
	{
		static $instance;
		if ( !isset( $instance ) ) {
			$instance = new fileResolver();
		}
		return $instance;
	}
}

?>