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
 * @package system
 * @version $Id$
*/

/**
 * frontController: ��������������� �������
 *
 * @package system
 * @version 0.5
 */

class frontController
{
    /**
     * ������� ����� �������
     *
     */
    const TPL_PRE = "act/";

    /**
     * ���������� �������
     *
     */
    const TPL_EXT = ".tpl";
    /**
     * iRequest
     *
     * @var iRequest
     */
    protected $request;

    /**
     * ���� �� ����� � ���������
     *
     * @var string
     */
    protected $path;

    /**
     * ����������� ������
     *
     * @param iRequest $request
     * @param $path ���� �� ����� � ���������
     */
    public function __construct($request, $path)
    {
        $this->request = $request;
        $this->path = $path;
    }

    /**
     * ��������� ����� �������
     *
     * @return string ��� ������� � ������������ � ����������� ������� � ������
     */
    public function getTemplateName()
    {
        $section = $this->request->getSection();
        $action = $this->request->getAction();

        $tpl_name = self::TPL_PRE . $section . '/' . $action . self::TPL_EXT;
        if (file_exists($this->path . '/' . $tpl_name)) {
            return $tpl_name;
        }
        throw new mzzRuntimeException('�� ������ �������� ������ ��� section = <i>"' . $section . '"</i>, action = <i>"' . $action . '"</i>');
    }
}

?>