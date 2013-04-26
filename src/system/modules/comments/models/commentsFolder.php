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
 * @version 0.3.1
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
            $this->object = $objectMapper->searchOneByField($this->getByField(), $this->getParentId());
        }

        return $this->object;
    }

    public function setObject(entity $object)
    {
        $this->object = $object;
    }
}
?>