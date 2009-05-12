<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('menu/menuItem');
fileLoader::load('orm/plugins/i18nPlugin');

/**
 * itemMapper: маппер
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuItemMapper extends mapper
{
    const ITEMTYPE_SIMPLE = 1;
    const ITEMTYPE_ADVANCED = 2;
    const ITEMTYPE_EXTERNAL = 3;

    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'menu';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'menuItem';

    protected $table = 'menu_menuItem';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once',
            ),
        ),
        'parent_id' => array(
            'accessor' => 'getParent',
            'mutator' => 'setParent',
        ),
        'type_id' => array(
            'accessor' => 'getType',
            'mutator' => 'setType',
        ),
        'args' => array(
            'accessor' => 'getArgs',
            'mutator' => 'setArgs',
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n',
            ),
        ),
        'order' => array(
            'accessor' => 'getOrder',
            'mutator' => 'setOrder',
        ),
        'menu_id' => array(
            'accessor' => 'getMenu',
            'mutator' => 'setMenu',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'menu/menuMapper',
            'options' => array('lazy')
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
        $this->plugins('i18n');
        $this->plugins('acl_ext');
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getMenuItemsTypes()
    {
        return array(
            self::ITEMTYPE_SIMPLE => 'Простой',
            self::ITEMTYPE_ADVANCED => 'Advanced',
            self::ITEMTYPE_EXTERNAL  => 'External',
        );
    }

    public function getTitleByType($type)
    {
        $types = $this->getMenuItemsTypes();

        if (!array_key_exists($type, $types)) {
            $type = self::ITEMTYPE_SIMPLE;
        }

        return $types[$type];
    }

    public function getMenuChildrens($parent_id, menu $menu)
    {
        $criteria = new criteria;
        $criteria->add('parent_id', (int)$parent_id)->add('menu_id', $menu->getId())->setOrderByFieldDesc('order')->setOrderByFieldDesc('id');

        $data = $this->searchAllByCriteria($criteria);
        return $data;
    }

    public function getMaxOrder($parent_id, $menu_id)
    {
        $criteria = new criteria($this->table);
        $criteria->addSelectField(new sqlFunction('MAX', 'order', true), 'maxorder')->add('parent_id', (int)$parent_id)->add('menu_id', (int)$menu_id);
        $select = new simpleSelect($criteria);
        $stmt = $this->db()->query($select->toString());
        $maxorder = $stmt->fetch();
        return (int)$maxorder['maxorder'];
    }

    public function searchByOrderAndParentInMenu($order, $parent, $menu_id)
    {
        $criteria = new criteria;
        $criteria->add('order', (int)$order)->add('parent_id', (int)$parent)->add('menu_id', (int)$menu_id);
        return $this->searchOneByCriteria($criteria);
    }


    public function move(menuItem $item, $target)
    {
        if ($target == 'up' || $target == 'down') {
            $item = $this->changeOrder($item, $target);
        } elseif ($item->getParent() != $target) {
            $item = $this->changeParent($item, $target);
        }

        $this->save($item);
    }

    protected function changeOrder(menuItem $item, $target)
    {
        $order = ($target == 'up') ? $item->getOrder() - 1 : $item->getOrder() + 1;
        $next = $this->searchByOrderAndParentInMenu($order, $item->getParent(), $item->getMenu()->getId());
        if ($next) {
            $item->setOrder($next->getOrder());
            $next->setOrder($item->getOrder());
            $this->save($next);
        }
        return $item;
    }

    protected function changeParent(menuItem $item, $target)
    {
        $new = $this->searchById($target);

        if ($new || $target == 0) {
            $this->shift($item->getParent(), $item->getOrder());

            $item->setOrder($this->getMaxOrder($target, $item->getMenu()->getId()) + 1);
            $item->setParent($target);
        }

        return $item;
    }

    public function delete(menuItem $item)
    {
        $childrens = $this->getMenuChildrens($item->getId(), $item->getMenu());
        foreach ($childrens as $child) {
            $this->delete($child);
        }

        $this->shift($item->getParent(), $item->getOrder());
        parent::delete($item->getId());
    }

    protected function shift($parent_id, $order)
    {
        $stmt = $this->db()->prepare('UPDATE ' . $this->table . ' SET `order` = `order` - 1 WHERE `parent_id` = :parent_id AND `order` > :order');
        $stmt->bindParam('parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->bindParam('order', $order, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function postCreate(entity $object)
    {
        $request = systemToolkit::getInstance()->getRequest();
        $object->setUrlLang($this->getCurrentLang(), $request->getString('lang'));

        return $object;
    }

    protected function getCurrentLang()
    {
        if (!systemConfig::$i18nEnable) {
            return null;
        }

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $lang = $request->getString('lang');
        if (empty($lang)) {
            $lang = $toolkit->getLocale()->getName();
        }
        return $lang;
    }

    public function createItemFromRow($row)
    {
        switch ($row['type_id']) {
            case self::ITEMTYPE_ADVANCED:
                $className = 'advancedMenuItem';
                break;

            case self::ITEMTYPE_EXTERNAL :
                $className = 'externalMenuItem';
                break;

            default:
                $type_id = self::ITEMTYPE_SIMPLE;
                $className = 'simpleMenuItem';
                break;
        }
        fileLoader::load('menu/items/' . $className);

        $oldClassName = $this->class;
        $this->class = $className;
        $object = parent::createItemFromRow($row);
        $this->class = $oldClassName;
        return $object;
    }

    public function create($type = null)
    {
        if ($type === null) {
            return parent::create();
        }
        switch ($type) {
            case self::ITEMTYPE_ADVANCED:
                $className = 'advancedMenuItem';
                break;

            case self::ITEMTYPE_EXTERNAL :
                $className = 'externalMenuItem';
                break;

            default:
                $type_id = self::ITEMTYPE_SIMPLE;
                $className = 'simpleMenuItem';
                break;
        }
        fileLoader::load('menu/items/' . $className);

        $oldClassName = $this->class;
        $this->class = $className;
        $object = parent::create();
        $this->class = $oldClassName;
        return $object;
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_menuItem');
        $this->register($obj_id);
        return $obj_id;
    }

    public function convertArgsToObj($args)
    {
        if ($args['id'] == 0) {
            $obj = $this->createItemFromRow(array());
            $obj->import(array('obj_id' => $this->getObjId()));
            return $obj;
        }
        $item = $this->searchById($args['id']);

        if ($item) {
            return $item;
        }

        throw new mzzDONotFoundException();
    }
}

?>
