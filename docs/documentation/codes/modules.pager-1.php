<?php

class simpleController
{
    [...]

    /**
     * ����� ��������� �������� ��� ���������� ��������� ��������
     *
     * @param simpleMapper $item ������, ������� ���������� ��������� ��������� ��������
     * @param integer $per_page ����� �������� �� ��������
     * @param boolean $reverse ����, ���������� ������� ������� �� ��������������� (�� ������� � �������)
     * @param integer $roundItems ����� ��������� ������� ������� ����� � ������� (��������: ... 4 5 6 _7_ 8 9 10 ... -> $roundItems = 3)
     * @return pager
     */
    protected function setPager($item, $per_page = 20, $reverse = false, $roundItems = 2)
    {
        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->request->get('page', 'integer', SC_GET), $per_page, $roundItems, $reverse);
        $item->setPager($pager);

        $this->smarty->assign('pager', $pager);

        return $pager;
    }
}

?>