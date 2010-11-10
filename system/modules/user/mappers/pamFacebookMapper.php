<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/mapper.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 4004 2009-11-24 00:10:39Z mz $
 */

fileLoader::load('user/models/pamFacebook');

/**
 * facebookMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class pamFacebookMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'pamFacebook';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_pamFacebook';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array (
        'user_id' => 
array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/user',
            'options'=>array('once')
        ),
        'facebook_uid' => 
        array (
            'accessor' => 'getFacebookUid',
            'mutator' => 'setFacebookUid',
            'type' => 'int',
            'options' => 
            array ('pk','once'),
        ),
    );
}

?>