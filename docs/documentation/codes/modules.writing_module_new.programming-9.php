<?php

class message extends simple
{
    [...]

    public function getAcl($name = null)
    {
        // � ����� 'delete' ������ �������� ����������� ����� ����� ��
        if ($name == 'view' || $name == 'delete') {
            // �������� id ���������� ��������� (��� �����������, � ������ � ���������� 'sent'
            $user_id = ($this->getCategory()->getName() == 'sent') ? $this->getSender()->getId() : $this->getRecipient()->getId();
            // ���� id ����������/����������� == id �������� ������������ - ������ ����
            return $user_id == systemToolkit::getInstance()->getUser()->getId();
        }

        return parent::getAcl($name);
    }
}

?>