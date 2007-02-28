<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';

/**
 * classFileResolver: �������� �������� ������
 * �������:
 * (������ -> ���������)
 * core         -> core/core.php
 * module/bla   -> module/bla.php
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class classFileResolver extends partialFileResolver
{
    /**
     * �����������
     *
     * @param object $resolver ������� ��������
     */
    public function __construct(iResolver $resolver)
    {
        parent::__construct($resolver);
    }

    /**
     * �������� �� ������������ ������� ���������� �������
     * ���������� ��� ���� ������������� ���, ������� ���������
     *
     * @param string $request ������ �������
     * @return string|null ������������ ������, ���� ������ ��������� � ��������, ���� null
     */
    protected function partialResolve($request)
    {
        $result = $request;
        if (strpos($request, '/') === false) {
            $result = $request . '/' . $request;
        }
        return $result . '.php';
    }
}

?>