<p>����������, ������������ ��� ��������� �������������� ��������� � ��������������. �������� ������ ������������� ������� �����������:</p>
<<code php>>
$controller = new messageController('��������, ������������� ������� �� �������', messageController::WARNING);
return $controller->run();
<</code>>
<p>������ ���������� ����� ���� ������� ��� ���������� ���������. �������� ��������� ����:</p>
<ul>
    <li><code>messageController::INFO</code> - ��������� ��������������� ���������.</li>
    <li><code>messageController::WARNING</code> - ��������������.</li>
</ul>