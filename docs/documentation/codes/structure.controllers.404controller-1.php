<?php
/**
 * simple404Controller: контроллер страницы с ошибкой 404
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.5
 */
class simple404Controller extends simpleController
{
    /**
     * Свойство, определяющее - отправлять контент или только заголовки
     *
     * @var boolean
     */
    protected $onlyHeaders;

    /**
     * Результат работы контроллера, обрабатывающего 404 ошибку конкретных ДО
     *
     * @var string
     */
    private $result;

    /**
     * Конструктор
     *
     * @param boolean $onlyHeaders
     */
    public function __construct($onlyHeaders = false)
    {
        parent::__construct();
        $this->onlyHeaders = (bool)$onlyHeaders;
    }

    /**
     * Установка результата работы 404 контроллера для определенного маппера
     *
     * @param simpleMapper $mapper
     */
    public function applyMapper(mapper $mapper)
    {
        $this->result = $this->forward404($mapper);
    }

    protected function getView()
    {
        $this->response->setStatus(404);

        if ($this->result) {
            return $this->result;
        }

        $module = 'page';
        $action = 'view';
        $name = '404';

        if ($this->request->getModule() == $module && $this->request->getString('name') == $name && $this->request->getAction() == $action) {
            throw new mzzRuntimeException('Recursion detected: the 404 controller was called twice.');
        }

        $this->request->setModule($module);
        $this->request->setParams(array('name' => $name));
        $this->request->setAction($action);

        return $this->onlyHeaders ? false : $this->forward($module, $action);
    }
}

?>