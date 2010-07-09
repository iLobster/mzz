<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user/models/userFolder');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * userFolderMapper: mapper for fake object
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userFolderMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'userFolder';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_userFolder';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
    );

    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
    }

    public function getFolder()
    {
        return $this->create();
    }
}

?>