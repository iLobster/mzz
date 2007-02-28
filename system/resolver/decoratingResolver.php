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
 * decoratingResolver: ���������� �������� decorator ��� ����������
 * �� ���� ����������� ��� ������������ ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
abstract class decoratingResolver implements iResolver
{
    /**
     * ��������, ������� ����� ��������������
     *
     * @var object
     */
    protected $resolver = null;

    /**
     * �����������
     *
     * @param object $resolver ��������, ������� ����� ��������������
     */
    public function __construct(iResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * �������� ����� resolve ��� ������������� ���������
     * � ����������� ����� ����� ����������� �������������
     *
     * @param string $request ������
     * @return string|null ���� �� ����� ���� ������, ���� null � ��������� ������
     */
    public function resolve($request)
    {
       return $this->resolver->resolve($request);
    }

    /**
     * �������� ��� ������ ������������� ���������
     *
     * @param string $callname ��� ������
     * @param array $args ���������
     * @return mixed ���������� ���������� ����������� ������
     */
    public function __call($callname, $args)
    {

        $callback = array($this->resolver, $callname);

        if (!is_callable($callback)) {
            throw new mzzCallbackException($callback);
        }

        return call_user_func_array($callback, $args);

    }
}

?>