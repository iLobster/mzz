<?php
/**
 * simple403Controller: контроллер страницы с 403 ошибкой
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.2
 */
class simple403Controller extends simpleController
{
    public function getView()
    {
        $module = 'page';
        $action = 'view';
        $name = '403';

        if ($this->request->getModule() == $module
        && $this->request->getString('name') == $name
        && $this->request->getAction() == $action) {
            throw new mzzRuntimeException('Recursion detected: the 403 controller was called twice.');
        }

        $this->request->setModule($module);
        $this->request->setParams(array('name' => $name));
        $this->request->setAction($action);

        $this->response->setStatus(403);

        return $this->forward($module, $action);
    }
}
?>