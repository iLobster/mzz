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

fileLoader::load('tags/tagsItem');

/**
 * itemMapper: маппер
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsItemMapper extends simpleMapper
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
    protected $className = 'tagsItem';

    /**
     * Метод для возврата контроллера, обрабатывающего ошибку 404
     *
     * @return simpleController
     *
     * @todo подумать - насколько это плохо
     */
    public function get404()
    {
        fileLoader::load('tags/controllers/tags404Controller');
        return new tags404Controller();
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getRequest()->getAction();

        if (isset($args['parent_id']) || isset($args['id'])) {
            $parent_obj_id = isset($args['parent_id']) ? $args['parent_id'] : $args['id'];

        } elseif((isset($args['items']) && $action == 'itemsTagsCloud') || ($action == 'tagsCloud')) {
            // если передается список объектов для облака

            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_' . $action);
            $this->register($obj_id, 'tags', 'tagsItem');

            $obj = $this->create();
            $obj->import(array('obj_id' => $obj_id));
            return $obj;

        } else {
            //
            throw new Exception();
            return 1;
        }

        $tagsItem = $this->searchOneByField('item_obj_id', $parent_obj_id);
        if(is_null($tagsItem)) {

            // toDo owner добавить?

            $tagsItem = $this->create();
            $tagsItem->setItemObjId($parent_obj_id);
            $this->save($tagsItem);
        }

        if ($tagsItem) {
            return $tagsItem;
        }


        throw new mzzDONotFoundException();
    }
}

?>