<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/mapper.tpl $
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 2182 2007-11-30 04:41:35Z zerkms $
 */

{{if $mapper_data.module ne $mapper_data.doname}}
fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.doname}}');
{{else}}
fileLoader::load('{{$mapper_data.module}}');
{{/if}}

/**
 * {{$mapper_data.mapper_name}}: маппер
 *
 * @package modules
 * @subpackage {{$mapper_data.module}}
 * @version 0.1
 */

class {{$mapper_data.mapper_name}} extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = '{{$mapper_data.module}}';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = '{{$mapper_data.doname}}';

    /**
     * Возвращает уникальный идентификатор класса
     *
     * @return simple
     */
    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_' .$this->className);
        $this->register($obj_id);
        return $obj_id;
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        if (!empty($args['id'])) {
            return $this->searchByKey($args['id']);
        }

        $acl = new acl(systemToolkit::getInstance()->getUser());
        $acl->delete($this->getObjId());
        $obj = $this->create();
        $obj->import(array('obj_id' => $this->getObjId()));
        return $obj;
    }

}

?>