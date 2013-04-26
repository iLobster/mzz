<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('modules/jip/iJip');

/**
 * jip: класс для работы с jip
 *
 * @package modules
 * @subpackage jip
 * @version 0.2
 */
class jip implements iJip
{
    /**
     * Default template for jip
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'jip/jip.tpl';

    /**
     * JIP object id
     *
     * @var int
     */
    private $objId;

    /**
     * Langs
     *
     * @var array
     */
    private $langs = null;

    /**
     * JIP Object
     *
     * @var simple
     */
    private $jipId;

    /**
     * Результат сборки массива элементов JIP-меню
     *
     * @var array
     */
    private $jipItems = array();

    /**
     * Шаблон JIP-меню
     *
     * @var string
     */
    private $template = null;

    /**
     * Конструктор
     *
     * @param integer $jip_id идентификатор jip
     * @param string $template шаблон JIP-меню
     */
    public function __construct($jip_id, $template = self::DEFAULT_TEMPLATE)
    {
        $this->jipId = $jip_id;
        $this->template = $template;
    }

    public function addItem($action_name, $options)
    {
        $this->jipItems[$action_name] = $options;
    }

    /**
     * Проверяет присутствие элемента в JIP-меню
     *
     * @param string $action_name имя действия
     * @return boolean
     */
    public function hasItem($action_name)
    {
        return isset($this->jipItems[$action_name]);
    }

    /**
     * Возвращает ссылку на массив параметров элемента JIP-меню
     *
     * @param string $action_name имя действия
     * @return array
     */
    public function &getItem($action_name)
    {
        if ($this->hasItem($action_name)) {
            return $this->jipItems[$action_name];
        } else {
            throw new mzzRuntimeException('"' . $action_name . '" is not found in "' . $this->jipId . '" JIP menu.');
        }
    }

    public function setLangs($langs)
    {
        $this->langs = $langs;
    }

    public function getLangs()
    {
        if ($this->langs === null) {
            $this->langs = fLocale::searchAll();
        }
        return $this->langs;
    }

    /**
     * Возвращает идентификатор JIP-меню
     *
     * @return string
     */
    protected function getJipId()
    {
        return $this->jipId;
    }

    /**
     * Возвращает отображение JIP
     *
     * @return string
     */
    public function getJip()
    {
        $view = systemToolkit::getInstance()->getView('smarty');

        $view->assign('langs', $this->getLangs());
        $view->assign('jip', $this->jipItems);
        $view->assign('jipId', $this->getJipId());

        return $view->render($this->template);
    }
}

?>