<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/mappers/tagsItemRelMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsItemRelMapper.php 1121 2007-11-30 04:31:39Z zerkms $
 */

fileLoader::load('tags/tagsItemRel');

/**
 * tagsItemRelMapper: маппер
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsItemRelMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'tags';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'tagsItemRel';

    /**
     * Конструктор
     *
     * @param string $section секция
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
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }
}

?>