<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
Изменение прав на объект типа <b>{$class}</b> раздела <b>{$section}</b> для владельца объекта
</div>

<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="list">
        {include file="access/checkboxes.tpl" actions=$actions adding=false}
    </table>
</form>