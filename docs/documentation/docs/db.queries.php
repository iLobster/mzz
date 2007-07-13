<p>��� ��������� SQL-�������� � mzz ������������ ����������� ����� simpleSelect. SimpleSelect �������� ������ �� ��������� ������, �������� �������� ������� ������� criteria. ���������� ���������� ������:</p>
<!-- php code 1 -->
<p>��� ������ - ��������� �������� ��� ����������� � ��������� ����� ������� � �������� ������� (`). ����������� ������� ��� �� ����� ���������� �� ��������� �������� ('), � ������� ���������� ��������� ���������, � �� ������������� ���� ��������� ��������.</p>
<p>���������� �������� ����� ������ � ����������� �������� (����� ������ ������� - ��� ������ �������� � ��������� ������).</p>
<ul>
    <li>
        ������� ����������� �����
        <!-- php code 2 -->
        <<note>>������ �� ������� �������� ���������� ������ �� ������ ����, ����� ������� ������ ����� ����������� � ������� �������� �������:<!-- code 3 --><</note>>
    </li>
    <li>
        ������� �� �������
        <!-- php code 4 -->
        ������� ���������� � ������ criteria::add() �������� ������ ���������. � ��� ���������: EQUAL('='), NOT_EQUAL('<>'), GREATER('&gt;'), LESS('&lt;') � ������. ������ �������� ����� ���������� ��������������� � ������ criteria ���� � API-������������ (!!).
    </li>
    <li>
        ���������� � ����������� ����� �������
        <!-- php code 5 -->
    </li>
    <li>
        ����������� � ������� ���������
        <!-- php code 6 -->
        <<note>>�������� ������ criterion �������� ����<</note>>
        �� ������� ����� - ��� � �������� ������� ����������� � ����� criteria::addJoin() ������ ���������� ��������� ������ ������ criterion. ��� ����������� ������� �������� ���������� � ����� ���� criteria::JOIN_INNER ���� criteria::JOIN_LEFT (�������� �� ���������).
    </li>
    <li>
        ���������� �����������
        <!-- php code 7 -->
    </li>
</ul>
<p><b>Criterion</b></p>
<p>����� criterion �������� ��������� ������������ � ���������� ��������. ������ �� ������ ���������� �� ��������� � �������� �� ���������. ������� ��������� �������� �������� ��� ������ ���������� - ����� ����, ������ - ��������� ���������, ����� ������� ����, ������� � ������� (��� ������� � IN � BETWEEN). ������� ���������� �������� ��� ��������� ���������. �������� - ����, ������������ ��� ������ ������� �������� ����� (���������� ���� ��� ����� ��������� � `, � �� � ' � �� ������������). ������� ������������� ������:</p>
<!-- php code 8 -->
<p>����� ������� criterion ����� ���������� ���� � ������ ����������� ������� criterion::addAnd() � criterion::addOr(), ������������ �������������� ����� ����������� ���������� and � or.</p>
<!-- php code 9 -->
<<note>>����� criteria::generate() ����� ���������� � ���������������� ����� - ��� �� ������� ��� �������� �������, ��� ������ ��������� ��� simpleSelect.<</note>>