{include file='jipTitle.tpl' title='admin/module.adding'|i18n}
<div class="generatorSuccessResult">
{_ module.create_successfully $name $dest}
</div>

<script type="text/javascript">
devToolbar.addModule('{$name}', [
{ldelim}url: "{url route="aclDefaultsAdd" class_name=$name action="admin_access"}", ico: "key", over: "edit", alt: "Редактировать права доступа"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="editModule"}", ico: "block", over: "edit", alt: "Редактировать модуль"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="deleteModule"}", ico: "block", over: "del", alt: "Удалить модуль"{rdelim},
{ldelim}url: "{url route="withId" module="admin" id=$id action="addClass"}", ico: "script", over: "add", alt: "Добавить класс"{rdelim},
{ldelim}url: "{url route="withId" module="config" id=$name action="list"}", ico: "wrench", alt: "Параметры конфигурации"{rdelim}
]);
</script>