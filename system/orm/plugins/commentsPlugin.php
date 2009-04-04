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
 * commentsPlugin: плагин для комментируемых модулей.
 *
 * @package orm
 * @subpackage plugins
 * @version 0.0.1
 */
class commentsPlugin extends observer
{
    protected $options = array(
        'comments_count_field' => 'comments_count'
    );

    protected function updateMap(& $map)
    {
        $map[$this->options['comments_count_field']] = array(
            'accessor' => 'getCommentsCount',
            'mutator' => 'setCommentsCount'
        );
    }
}
?>