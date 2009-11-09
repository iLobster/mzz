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

fileLoader::load('menu/model/menuItem');
fileLoader::load('modules/i18n/plugins/i18nPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');
fileLoader::load('orm/plugins/tree_alPlugin');

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
            'options' => array('pk','once')
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
            'options' => array('i18n'),
        ),
        'order' => array(
            'accessor' => 'getOrder',
            'mutator' => 'setOrder',
            'orderBy' => 1
        ),
        'menu_id' => array(
            'accessor' => 'getMenu',
            'mutator' => 'setMenu',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'menu/menu',
            'options' => array('lazy')
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_alPlugin(array('path_name' => 'id')), 'tree');
        $this->plugins('jip');
        $this->plugins('i18n');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public static function getMenuItemsTypes()
    {
        return array(
            self::ITEMTYPE_SIMPLE => 'Простой',
            self::ITEMTYPE_ADVANCED => 'Advanced',
            self::ITEMTYPE_EXTERNAL  => 'External',
        );
    }

    public function getMaxOrder($parent_id, $menu_id)
    {
        $criteria = new criteria($this->table);
        $this->plugin('tree')->preSqlSelect($criteria);

        $criteria->clearSelect();
        $criteria->select(new sqlFunction('MAX', $this->table(false) . '.order', true), 'maxorder')->where('tree.parent_id', (int)$parent_id)->where('menu_id', (int)$menu_id);

        $select = new simpleSelect($criteria);
        $maxorder = $this->db()->getOne($select->toString());
        return (int)$maxorder;
    }

    public function searchByIdInMenu($id, $menuId)
    {
        $criteria = new criteria;
        $criteria->where('menu_id', $menuId)->where('id', $id);

        return $this->searchOneByCriteria($criteria);
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
        list($type, $className) = $this->getTypeAndClassByTypeId($row['type_id']);
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

        list($type, $className) = $this->getTypeAndClassByTypeId($type);

        fileLoader::load('menu/items/' . $className);

        $oldClassName = $this->class;
        $this->class = $className;
        $object = parent::create();
        $object->merge(array('type_id' => $type));
        $this->class = $oldClassName;
        return $object;
    }

    public function getTypeAndClassByTypeId($typeId)
    {
        switch ($typeId) {
            case self::ITEMTYPE_ADVANCED:
                $className = 'advancedMenuItem';
                break;

            case self::ITEMTYPE_EXTERNAL :
                $className = 'externalMenuItem';
                break;

            default:
                $typeId = self::ITEMTYPE_SIMPLE;
                $className = 'simpleMenuItem';
                break;
        }

        return array($typeId, $className);
    }

    public function convertArgsToObj($args)
    {
        if ($args['id'] == 0) {
            return $this->create();
        }
        $item = $this->searchById($args['id']);

        if ($item) {
            return $item;
        }

        throw new mzzDONotFoundException();
    }
}

?>
