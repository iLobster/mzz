������ ��������� ����� � ������� (����������):<br />
<div class="code"><code>
        ; news actions config<br />
        <br />
        [view]<br />
        controller = "view"<br />
        <br />
        [folders]<br />
        controller = "folders"<br />
        <br />
        [create]<br />
        controller = "create"<br />
        <br />
        [edit]<br />
        controller = "edit"<br />
        jip = true<br />
        title = "&lt;img src='/templates/images/edit.png' width=16 height=16 border=0 alt='edit' /&gt;"<br />
        <br />
        [delete]<br />
        controller = "delete"<br />
        jip = true<br />
        title = "&lt;img src='/templates/images/delete.png' width=16 height=16 border=0 alt='delete' /&gt;"<br />
        confirm = "�� ������ ������� ��� �������?"<br />
</code></div>
������ ������ (��������: [view]) ���������� ��� ������������� ��������. ��� ����� �������� �� ���� ���������� �������� (���������� � ������ ��������), ���� � ����� �������������. � ������ ������ ����������� �������� <i>controller</i> - ��� ��� �����������, ������� ����� ����������� ������ �������� (������ �� ������ MVC). ��� �������� �������� ������������ (?).<br />
��������� �������� �����������:<br />
<ul>
        <li><i>jip</i> - ������������ ����� ������� �������� <b>true</b> ��� <b>false</b>, � ���������� �������������� ������� ��� ���������� ������� ������ � jip'�� (������), ��������� ��� ������ ��������.
        </li>
        <li><i>title</i> - ���������� �������, ������� ����� �������� � jip. ������������ ��������� �� ��������� <i>jip</i>.
        </li>
        <li><i>confirm</i> - ���������� ��������������, ������� ����� �������� �� ����� � ����� �������� <b>Ok</b> � <b>������</b> ��� ������ �� ���� ������ ���� � jip. ������������ ��������� �� ��������� <i>jip</i>.
        </li>
</ul>