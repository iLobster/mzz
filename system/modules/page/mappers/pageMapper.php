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

fileLoader::load('page');

/**
 * pageMapper: ������ ��� �������
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */
class pageMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'page';

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ��������� ����� �������� �� �������������� �����
     *
     * @param integer $id ������������� �����
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|null
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function convertArgsToId($args)
    {
        if (isset($args['id']) && !isset($args['name'])) {
            $args['name'] = $args['id'];
        }

        if (strpos($args['name'], '/') !== false) {
            $toolkit = systemToolkit::getInstance();
            $pageFolderMapper = $toolkit->getMapper('page', 'pageFolder');

            $folder = substr($args['name'], 0, strrpos($args['name'], '/'));
            $pagename = substr(strrchr($args['name'], '/'), 1);

            $pageFolder = $pageFolderMapper->searchByPath($folder);

            $criteria = new criteria();
            $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
            $page = $this->searchOneByCriteria($criteria);
        }

        if (!isset($page)) {
            $page = $this->searchOneByField('name', $args['name']);
        }

        if ($page) {
            return (int)$page->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>