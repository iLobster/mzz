<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * errorPages404Controller
 *
 * @package modules
 * @subpackage errorPages
 * @version 0.0.1
 */
class errorPages404Controller extends simpleController
{
    public function run(simpleAction $forAction = null)
    {
        if (!is_null($forAction)) {
            $module = $forAction->getModuleName();
            $class = $forAction->getClassName();
            $controller = $class . '404Controller';

            try {
                fileLoader::load($module . '/controllers/' . $controller);
                $controller = new $controller($forAction);

                return $controller->run();
            } catch (mzzIoException $e) {
                return $this->getView();
            }
        }

        return $this->getView();
    }

    protected function getView()
    {
        $this->response->setStatus(404);
        return $this->render('errorPages/404.tpl');
    }
}
?>