<?php
// фабрика конфигуратора

fileResolver::includer('config');

class configFactory
{
    public static $instance;

	public function getInstance()
	{

		if ( !isset( $instance ) ) {
			$instance = new config();
		}
		return $instance;
	}
}

?>