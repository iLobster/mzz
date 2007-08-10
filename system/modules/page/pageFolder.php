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

fileLoader::load('simple/simpleForTree');

/**
 * pageFolder: класс дл€ работы c данными
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */
class pageFolder extends simpleForTree
{
    protected $name = 'page';

    /**
     *  онструктор
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>