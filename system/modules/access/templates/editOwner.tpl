{include file='jipTitle.tpl' title="Изменение прав на объект типа <b>$class</b> раздела <b>$section</b> для владельца объекта"}

{set name="form_action"}{url}{/set}
{form action=$form_action method="post" jip=true}
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
        {include file="access/checkboxes.tpl" actions=$actions adding=false}
    </table>
</form>