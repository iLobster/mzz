<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/mapper.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 1998 2007-07-28 20:41:57Z mz $
 */

fileLoader::load('tags/tagsItemRel');

/**
 * tagsItemRelMapper: ������
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsItemRelMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'tags';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'tagsItemRel';

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'tags_item_rel';
    }

    public function deleteByTagAndItem($tag_id, $item_id)
    {
        if ($tag_id instanceof simple) {
            $tag_id = $tag_id->getId();
        }

        if ($item_id instanceof simple) {
            $item_id = $item_id->getId();
        }

        $criteria = new criteria();
        $criteria->add('tag_id', $tag_id);
        $criteria->add('item_id', $item_id);
        $object = $this->searchOneByCriteria($criteria);

        $toolkit = systemToolkit::getInstance();
        if ($object && $this->isObjIdEnabled()) {
            $acl = new acl($toolkit->getUser());
            $acl->delete($object->getObjId());
        }

        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `tag_id` = :tag_id AND `item_id` = :item_id');
        $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /**
     * ���������� �������� ������ �� ����������
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }
}

?>