<p>������ ��������� ����� � actions (����������):</p>
<<code ini>>
; news actions config

[view]
controller = "view"

[folders]
controller = "folders"

[create]
controller = "create"

[edit]
controller = "edit"
jip = true
title = "&lt;img src='/templates/images/edit.png' width=16 height=16 border=0 alt='edit' /&gt;"

[delete]
controller = "delete"
jip = true
title = "&lt;img src='/templates/images/delete.png' width=16 height=16 border=0 alt='delete' /&gt;"
confirm = "�� ������ ������� ��� �������?"
<</code>>

<p>������ ������ (��������: [view]) ���������� ��� ������������� ��������. ��� ����� �������� �� ���� ���������� �������� (���������� � ������ ��������), ���� � ����� �������������. � ������ ������ ����������� �������� <em>controller</em> - ��� ��� �����������, ������� ����� ����������� ������ �������� (������ �� ������ MVC). ��� �������� �������� ������������ (?).<p>
<p>��������� �������� �����������:
<ul>
        <li><em>jip</em> - ������������ ����� ������� �������� <strong>true</strong> ��� <strong>false</strong>, � ���������� �������������� ������� ��� ���������� ������� ������ � jip'�� (������), ��������� ��� ������ ��������.
        </li>
        <li><em>title</em> - ���������� �������, ������� ����� �������� � jip. ������������ ��� <em>jip</em> = <strong>true</strong>.
        </li>
        <li><em>confirm</em> - ���������� ����� ��������������, ������� ����� ������� �� ����� � ����� �������� <strong>Ok</strong> � <b>������</b> ��� ������ �� ���� ������ ���� � jip. ������������ ��� <em>jip</em> = <strong>true</strong>.
        </li>
</ul>
</p>