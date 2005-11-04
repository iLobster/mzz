<?php
// фабрика конфигуратора

fileResolver::includer('config');

class configFactory
{
	function get()
	{
		static $instance;
		if ( !isset( $instance ) ) {
			$instance = new config();
		}
		return $instance;
	}
}

?>