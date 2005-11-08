<?php

require_once SYSTEM . 'core/resolver/fileResolver.php';

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