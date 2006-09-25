<p>��������� ������������� ��� ��������� �������� ����������� ������. ��������� ���������� ������ ���� � ����� (���� �� ����������), ����� �������� �������� � �������� ������������� ��������� � ������ resolve().
��������:
</p>
<!-- code 1 -->
<p>����������� �������� ��������� ��������� ������� (�����������) ���������. ���� �������� ��������� ��������� �������� Chain of Responsibility. � ������ ������������ ���������, ������ ����� ������� �� ������� ����������, ���� �� �� ����� ��������� ���-���� �� ���������� ��� �� ���������� �������. ��� ��������� ����������� ����� ����������� ������ � ������ ���������, ���� ����� � ������ ���������� (�������) ������ ����� - ����� ������� ������.<br />
������ �������� � ������������� ������������ ���������:
</p>
<!-- code 2 -->
<p>� ���� ������� ���� <i>file.php</i> ����� ������� ������� � $resolver1. ���� $resolver1 �� ������ ����������� ������, ����� ������ ����� ������� � $resolver2.
</p>
<p>� �����������, ������, ���������� �������� � ���������� ��� �� �������. ���������� ��� ���������������� �������� ������ ������������� ������ ��� ��������� - <i>fileLoader</i>. � ����� ������ �������� ���������� ������������ ����������� ��������, ������� ����� ��������� ��� ������� ������ ������. ����� ���� �������� ��������� � fileLoader, � ����� ��� ������ ������� fileLoader::load, ������ ����� �������������� ����� ���������.<br />
������ �������� ��������� � �������� ������ � ��� �������:
</p>
<!-- code 3 -->
<<note>>FileLoader �������� ���������� ����������� ��������� php require_once. ����� ������� - ���������� fileLoader'� ������ ���� ����� ���� �������� ������ 1 ���.<</note>>