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

fileLoader::load("forms/formElement");

/**
 * form: хелпер для работы с формами
 *
 * @package system
 * @subpackage forms
 * @version 0.1.3
 */
class form
{
    static public $CSRFField = '_csrf_token';
    static protected $xhtml = true;

    /**
     * Массив, используемый для индексирования элементов форм, в именах которых используется []
     *
     * @var array
     */
    static public $counts = array();

    public function open($params, $smarty)
    {
        fileLoader::load('forms/formTag');
        $element = new formTag();
        return $element->toString($params);
    }

    public function text($params, $smarty = null)
    {
        return $this->createField('text', $params);
    }

    public function password($params, $smarty)
    {
        $params['type'] = 'password';
        return $this->createField('text', $params);
    }

    public function hidden($params, $smarty)
    {
        return $this->createField('hidden', $params);
    }

    public function submit($params, $smarty)
    {
        return $this->createField('submit', $params);
    }

    public function reset($params, $smarty)
    {
        return $this->createField('reset', $params);
    }

    public function textarea($params, $smarty)
    {
        return $this->createField('textarea', $params);
    }

    public function select($params, $smarty)
    {
        return $this->createField('select', $params);
    }

    public function caption($params, $smarty)
    {
        return $this->createField('caption', $params);
    }

    protected function createField($name, $params) {
        $name = 'form' . ucfirst($name) . 'Field';
        fileLoader::load('forms/' . $name);
        $element = new $name();
        return $element->toString($params);
    }

    public function image($params, $smarty)
    {
        $name = $params['name'];
        $params['type'] = 'image';
        $params['name'] = $name . '_img';
        $image = $this->createField('text', $params);

        $hiddenParams = array();
        $hiddenParams['value'] = array_key_exists('value', $params) ? $params['value'] : 1;
        $hiddenParams['name'] = $name;
        return $this->hidden($hiddenParams, $smarty) . $image;
    }

    public function checkbox($params, $smarty)
    {
        return $this->createField('checkbox', $params);
    }

    public function radio($params, $smarty)
    {
        return $this->createField('radio', $params);
    }

    public function file($params, $smarty)
    {
        $params['type'] = 'file';
        return $this->createField('text', $params);
    }

    public function captcha($params, $smarty)
    {
        return $this->createField('captcha', $params);
    }

    /**
     * Устанавливает флаг генерации XHTML-тегов
     *
     * @param boolean $boolean
     */
    static public function setXhtml($flag)
    {
        self::$xhtml = (bool)$flag;
    }

    /**
     * Возвращает надо ли генерировать XHTML-теги
     *
     * @return boolean
     */
    static public function isXhtml()
    {
        return self::$xhtml;
    }
}

?>
