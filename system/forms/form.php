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

    public function __call($name, $args)
    {
        return $this->createField($name, $args[0]);
    }

    public function open($params)
    {
        fileLoader::load('forms/formTag');
        $element = new formTag();
        return $element->toString($params);
    }

    public function password($params)
    {
        $params['type'] = 'password';
        return $this->createField('text', $params);
    }

    protected function createField($name, $params) {
        $name = 'form' . ucfirst($name) . 'Field';
        fileLoader::load('forms/' . $name);
        $element = new $name();
        return $element->toString($params);
    }

    public function image($params, $view)
    {
        $name = $params['name'];
        $params['type'] = 'image';
        $params['name'] = $name . '_img';
        $image = $this->createField('text', $params);

        $hiddenParams = array();
        $hiddenParams['value'] = array_key_exists('value', $params) ? $params['value'] : 1;
        $hiddenParams['name'] = $name;
        return $this->hidden($hiddenParams, $view) . $image;
    }

    public function file($params, $view)
    {
        $params['type'] = 'file';
        return $this->createField('text', $params);
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

    /**
     * Генерирует случайный идентификатор для CSRF-проверки формы
     *
     * @return string
     */
    static public function getCSRFToken($reGenerate = false)
    {
        $session = systemToolkit::getInstance()->getSession();

        if ($reGenerate === true || !($token = $session->get('CSRFToken'))) {
            $token = md5(microtime(true) . rand());
            $session->set('CSRFToken', $token);
        }

        return $token;
    }
}
?>
