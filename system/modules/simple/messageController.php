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
 * messageController: контроллер вывода стандартных сообщений
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

class messageController extends simpleController
{
    const INFO = 1;
    const WARNING = 2;

    private $message;
    private $type;
    private $templates;

    public function __construct($message, $type)
    {
        parent::__construct();

        $this->message = $message;
        $this->type = $type;
        $this->templates = array(
        self::INFO => 'info',
        self::WARNING => 'warning'
        );
    }

    protected function getView()
    {
        if (!isset($this->templates[$this->type])) {
            $this->type = self::INFO;
        }

        $this->smarty->assign('message', $this->message);
        return $this->smarty->fetch('simple/' . $this->templates[$this->type] . '.tpl');
    }
}

?>