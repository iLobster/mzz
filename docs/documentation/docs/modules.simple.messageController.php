<p>����������, ������������ ��� ��������� �������������� ��������� � ��������������. �������� ������ ������������� ������� �����������:</p>
<<code php>>
$controller = new messageController('������������� ������� �� �������', messageController::INFO);
return $controller->run();
<</code>>
<p>������ ���������� ����� ���� ������� ��� ���������� ���������. �� ��������� <code>messageController::WARNING</code>.<br />�������� ��������� ����:</p>
<ul>
    <li><code>messageController::INFO</code> - ��������� ��������������� ���������.</li>
    <li><code>messageController::WARNING</code> - ��������������.</li>
</ul>