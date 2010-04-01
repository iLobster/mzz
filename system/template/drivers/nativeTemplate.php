<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class nativeTemplate extends aTemplate
{

    public function render($__resource)
    {
        $__filePath = fileLoader::resolve($__resource);

        extract($this->view->export(), EXTR_REFS);

        ob_start();
        require $__filePath;
	return ob_get_clean();
    }

    //public function __call()
    public function add($files, $join = true, $template = null)
    {
        $this->addMedia($files, $join, $template);
    }
}
?>