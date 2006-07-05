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
 * @package system
 * @subpackage toolkit
 * @version $Id$
*/

/**
 * systemToolkit: системный Toolkit
 *
 * @package system
 * @subpackage toolkit
 * @version 0.1
 */
class systemToolkit
{
    /**
     * Instance
     *
     * @var object
     */
    private static $instance = false;

    /**
     * Toolkit
     *
     * @var object
     */
    private $toolkit;

    /**
     * Singleton
     *
     * @return object
     */
    public static function getInstance()
    {
        if (self::$instance == false) {

            fileLoader::load('toolkit/compositeToolkit');
            self::$instance = new systemToolkit();
            self::$instance->toolkit = new compositeToolkit();
        }
        return self::$instance;
    }

    /**
     * Устанавливает новый toolkit
     *
     * @param iToolkit $toolkit
     * @return object возвращает старый toolkit
     */
    public function setToolkit(iToolkit $toolkit)
    {
        $old_toolkit = $this->getToolkit();
        $this->toolkit = $toolkit;
        return $old_toolkit;
    }

    /**
     * Добавляет Toolkit в Toolkit
     *
     * @param iToolkit $toolkit
     */
    public function addToolkit(iToolkit $toolkit)
    {
        $this->toolkit->addToolkit($toolkit);
    }

    /**
     * Возвращает текущий Toolkit
     *
     * @return object
     */
    public function getToolkit()
    {
        return $this->toolkit;
    }

    /**
     * Toolkit call
     *
     * @param string $methodName
     * @param array $args
     * @return mixed
     */
    public function __call($methodName, $args)
    {
        $toolkit = $this->toolkit->getToolkit($methodName);
        if ($toolkit == false) {
            throw new mzzRuntimeException("Can't find tool '" . $methodName . "' in toolkit");
        }

        return call_user_func_array(array($toolkit, $methodName), $args);
    }
}
?>