{include file='jipTitle.tpl' title='admin/class.adding'|i18n}
<div class="generatorSuccessResult">
{_ class.create_successfully $name $module}
</div>

<script type="text/javascript">
devToolbar.addClass('{$name}', '{$module}', [
{ldelim}url: "{url route="aclDefaultsAdd" module="admin" class_name=$name action="editDefault"}", ico: "key", over: "default", alt: "Редактировать права 'по умолчанию"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="listActions"}", ico: "cog", over: "edit", alt: "Редактировать действия класса"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="editClass"}", ico: "db-table", alt: "Map"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="editClass"}", ico: "script", over: "edit", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="deleteClass"}", ico: "script", over: "del", alt: "Удалить класс"{rdelim}
]);
</script>