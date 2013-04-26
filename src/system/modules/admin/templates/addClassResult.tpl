<div class="jipTitle">{_ class.adding}</div>

<div class="generatorSuccessResult">
{_ class.create_successfully $name $module->getName()}
</div>

<script type="text/javascript">
devToolbar.addClass('{$name}', '{$module->getName()}', [
{ldelim}url: "{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="listActions"}", ico: "action-edit", alt: "Редактировать действия класса"{rdelim},
{ldelim}url: "{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="map"}", ico: "db-table", alt: "Map"{rdelim},
{ldelim}url: "{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="editClass"}", ico: "class-edit", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="deleteClass"}", ico: "class-del", alt: "Удалить класс"{rdelim}
]);
</script>