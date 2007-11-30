<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/captcha/mappers/captchaMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: captchaMapper.php 1121 2007-11-30 04:31:39Z zerkms $
 */

fileLoader::load('captcha');

/**
 * captchaMapper: маппер
 *
 * @package modules
 * @subpackage captcha
 * @version 0.1
 */

class captchaMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'captcha';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'captcha';

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_captcha');
        $this->register($obj_id);
        return $obj_id;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => $this->getObjId()));
        return $obj;
    }
}

?>