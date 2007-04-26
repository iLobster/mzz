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
 * catalogueDeleteController: ���������� ��� ������ delete ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueDeleteController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $user = $this->toolkit->getUser();

        $id = $this->request->get('id', 'integer', SC_PATH);

        if ($id) {
            $items = array($id);
        } else {
            $items = array_keys((array) $this->request->get('items', 'mixed', SC_POST));
        }

        $nonAccessible = array();
        foreach ($items as $id) {
            $catalogue = $catalogueMapper->searchById($id);
            if ($catalogue) {
                $acl = new acl($user, $catalogue->getObjId());
                if ($acl->get($this->request->getAction())) {
                    $catalogueMapper->delete($id);
                } else {
                    $nonAccessible[] = $id;
                }
            }
        }
        if (empty($nonAccessible)) {
            return jipTools::redirect();
        } else {
            return print_r($nonAccessible);
        }
    }
}

?>