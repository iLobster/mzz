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

require_once systemConfig::$pathToSystem  . '/resolver/partialFileResolver.php';

/**
 * configFileResolver: �������� ����� ������������
 * �������:
 * (������ -> ���������)
 * configs/someconfig.ext   -> configs/someconfig.ext
 * notconfig/somefile       -> null
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class configFileResolver extends partialFileResolver
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
        if (strpos($request, 'configs/') === 0) {
            return $request;
        }
        return null;
    }
}

?>