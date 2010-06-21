<div class="jipTitle">{_ module.adding}</div>
<div class="generatorSuccessResult">
{_ module.create_successfully $module->getName() $dest}
</div>

<script type="text/javascript">
devToolbar.addModule('{$module->getName()}', [
    {ldelim}url: "{url route="withAnyParam" module="config" name=$name action="list"}", ico: "action", alt: "Параметры конфигурации"{rdelim},
{ldelim}url: "{url route="accessEditRoles" module_name=$name action="list"}", ico: "module-acl", alt: "Редактировать права доступа"{rdelim},
{ldelim}url: "{url route="withAnyParam" module="admin" name=$name action="editModule"}", ico: "module-edit", alt: "Редактировать модуль"{rdelim},
{ldelim}url: "{url route="withAnyParam" module="admin" name=$name action="deleteModule"}", ico: "module-del", alt: "Удалить модуль"{rdelim},
{ldelim}url: "{url route="withAnyParam" module="admin" name=$name action="addClass"}", ico: "class-add", alt: "Добавить класс"{rdelim}
]);
</script>