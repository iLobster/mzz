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
 * moduleResolver: �������� ����� �������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class moduleResolver extends partialFileResolver
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
        $result = null;
        //echo "<pre>";var_dump($request);echo "</pre>";


        // �������� ��� nameFactory ������������ � name/nameFactory
        if (preg_match('/^([a-z0-9]+)Factory$/i', $request, $matches)) {
            $request = $matches[1] . '/' . $request;
            //echo "<pre>";var_dump($request);echo "</pre>";
        }

        if (preg_match('/^[a-z0-9]+$/i', $request)) {
            $result = 'modules/' . $request . '/' . $request;
        } elseif (preg_match('/^[a-z0-9]+(\/[a-z0-9\._]+)+$/i', $request)) {
            $result = 'modules/' . $request;
        }

        $ext = substr(strrchr($request, '.'), 1);
        if ($ext != 'php' && $ext != 'ini' && $ext != 'xml') {
            $result .= '.php';
        }
        //echo "<pre>";var_dump($result);echo "</pre>";
        return $result;
    }
}

?>