{include file='jipTitle.tpl' title='admin/class.adding'|i18n}
<div class="generatorSuccessResult">
{_ class.create_successfully $name $module}
</div>

<script type="text/javascript">
devToolbar.addClass('{$name}', '{$module}', [
{ldelim}url: "{url route="withId" section="admin" id=$id action="listActions"}", ico: "cog", over: "edit", alt: "Действия класса"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editClass"}", ico: "db-table", alt: "Map"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editClass"}", ico: "script", over: "edit", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteClass"}", ico: "script", over: "del", alt: "Удалить класс"{rdelim}
]);
</script>
