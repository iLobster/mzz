<?php

interface iTemplate
{
    
    /**
     * Constructor
     *
     * @param view $view
     */
    public function __construct(view $view);

    /**
     *
     * @param string $resource
     */
    public function render($resource);
    public function setActiveTemplate($template_name, $placeholder = 'content');
    public function disableMain();
    public function enableMain();

}
?>
