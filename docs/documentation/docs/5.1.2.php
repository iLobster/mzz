<p>������ ��������� ����� � ������� (����������):</p>
<<code>>
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