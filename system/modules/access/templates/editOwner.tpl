{include file='jipTitle.tpl' title="��������� ���� �� ������ ���� <b>$class</b> ������� <b>$section</b> ��� ��������� �������"}

<form action="{url}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
        {include file="access/checkboxes.tpl" actions=$actions adding=false}
    </table>
</form>