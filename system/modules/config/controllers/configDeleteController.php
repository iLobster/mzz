<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * configDeleteController: контроллер для метода delete модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configDeleteController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $configOptionMapper = $this->toolkit->getMapper('config', 'configOption');
        $option = $configOptionMapper->searchById($id);

        if (!$option) {
            return $this->forward404($configOptionMapper);
        }

        $configOptionMapper->delete($option);
        return jipTools::redirect();
    }
}

?>