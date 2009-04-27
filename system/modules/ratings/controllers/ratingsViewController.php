<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * ratingsViewController: контроллер для метода view модуля ratings
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */

class ratingsViewController extends simpleController
{
    protected function getView()
    {
        $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');

        $object = $this->request->getRaw('object');
        if (!$object instanceof entity) {
            throw new mzzInvalidParameterException('Invalid object for comments');
        }

        $objectModule = $object->module();
        $objectType = get_class($object);

        $objectMapper = $this->toolkit->getMapper($objectModule, $objectType);

        //@todo: куда это можно вынести?
        if ($objectMapper->isAttached('obj_id')) {
            //Если есть плагин obj_id, то связь будет по полю obj_id
            $byField = $objectMapper->plugin('obj_id')->getObjIdField();
        } else {
            //иначе пробуем связаться по первичному ключу
            $byField = $objectMapper->pk();
        }

        $map = $objectMapper->map();
        if (!isset($map[$byField])) {
            throw new mzzInvalidParameterException('Invalid byField value for comments');
        }

        $objectId = $object->$map[$byField]['accessor']();

        if (!is_numeric($objectId)) {
            throw new mzzInvalidParameterException('Invalid objectId for comments');
        }

        $ratingsFolder = $ratingsFolderMapper->searchFolder($objectType, $objectId);

        if (!$ratingsFolder) {
            $ratingsFolder = $ratingsFolderMapper->create();
            $ratingsFolder->setModule($objectModule);
            $ratingsFolder->setType($objectType);
            $ratingsFolder->setByField($byField);
            $ratingsFolder->setParentId($objectId);
            $ratingsFolderMapper->save($ratingsFolder);
        }

        $this->smarty->assign('ratingsFolder', $ratingsFolder);
        return $this->fetch('ratings/view.tpl');
    }
}

?>