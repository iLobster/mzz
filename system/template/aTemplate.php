<?php
fileLoader::load('template/iTemplate');

abstract class aTemplate implements iTemplate
{
    /**
     * @var view
     */
    protected $view = null;
    
    /**
     * Включена вставка в main шаблон?
     *
     * @var boolean
     */
    protected $withMain = true;

    public function __construct(view $view) {
        $this->view = $view;
    }

    /**
     * Отключает вставку шаблона в main шаблон
     *
     */
    public function disableMain()
    {
        $this->withMain = false;
    }

    /**
     * Включает вставку шаблона в main шаблон
     *
     */
    public function enableMain()
    {
        $this->withMain = true;
    }
}
?>
