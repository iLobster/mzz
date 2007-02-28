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

/**
 * timerViewController: контроллер для метода view модуля timer
 *
 * @package modules
 * @subpackage timer
 * @version 0.1
 */
class timerMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'timer';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'timer';

    public function convertArgsToId($args)
    {
        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId('timer_timer');
        $this->register($obj_id);
        return $obj_id;
    }
}

?>