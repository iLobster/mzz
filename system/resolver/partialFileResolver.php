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

/**
 * partialFileResolver: ������� ����� ��� ���� ��������� ����������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class partialFileResolver implements iResolver
{
    /**
     * ������� ��������
     *
     * @var object
     */
    private $resolver;

    /**
     * �����������
     *
     * @param object $resolver ������� ��������
     */
    public function __construct(iResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * ������ �������� ����������
     *
     * @param string $request ������ �������
     * @return string|null ���� �� �����, ���� ���� ������, null � ��������� ������
     */
    public function resolve($request)
    {
        return $this->resolver->resolve($this->partialResolve($request));
    }

    /**
     * ����������� �������
     * ���������� � �����������
     *
     * @param string $request ������ �������
     * @return string ������������ ������
     */
    protected function partialResolve($request)
    {
        return str_replace('*', '', $request);
    }
}

?>