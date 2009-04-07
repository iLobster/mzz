<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * commentsFolder: класс для работы с данными
 *
 * @package modules
 * @subpackage comments
 * @version 0.3
 */
class commentsFolder extends entity
{
    protected $object = null;
    protected $objectMapper = null;

    public function getObjectMapper()
    {
        if (is_null($this->objectMapper)) {
            $toolkit = systemToolkit::getInstance();
            $this->objectMapper = $toolkit->getMapper($this->getModule(), $this->getType());
        }

        return $this->objectMapper;
    }

    public function getObject()
    {
        if (is_null($this->object)) {
            $objectMapper = $this->getObjectMapper();

            //@todo: куда это можно вынести? Да и надо ли выносить? Может быть оставить $this->getByField()?
            if ($objectMapper->isAttached('comments')) {
                //Если у комментируемого маппера приаттачен плагин comments, то берем поле из плагина
                $byField = $objectMapper->plugin('comments')->getByField();
            } elseif ($objectMapper->isAttached('obj_id')) {
                //Если нет плагина comments, но есть плагин obj_id, то связь будет по полю obj_id
                $byField = $objectMapper->plugin('obj_id')->getObjIdField();
            } else {
                //иначе пробуем связаться по первичному ключу
                $byField = $objectMapper->pk();
            }

            $this->object = $objectMapper->searchOneByField($byField, $this->getParentId());
        }

        return $this->object;
    }
}
?>