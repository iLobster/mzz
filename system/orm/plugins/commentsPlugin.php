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
 * @version 0.0.2
 */
class commentsPlugin extends observer
{
    protected $options = array(
        'extendMap' => false,
        'byField' => 'obj_id',
        'comments_count_field' => 'comments_count'
    );

    protected function updateMap(& $map)
    {
        if ($this->options['extendMap']) {
            $map[$this->options['comments_count_field']] = array(
                'accessor' => 'getCommentsCount',
                'mutator' => 'setCommentsCount'
            );
        }
    }

    public function postDelete(entity $object)
    {
        $toolkit = systemToolkit::getInstance();
        $commentsFolderMapper = $toolkit->getMapper('comments', 'commentsFolder');

        $objectType = get_class($object);

        $map = $this->mapper->map();

        $objectId = $object->$map[$this->getByField()]['accessor']();
        $commentsFolder = $commentsFolderMapper->searchFolder($objectType, $objectId);
        if ($commentsFolder) {
            $commentsFolderMapper->delete($commentsFolder);
        }
    }

    public function getByField()
    {
        return $this->options['byField'];
    }

    public function isExtendMap()
    {
        return $this->options['extendMap'];
    }
}
?>