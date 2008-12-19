{include file='jipTitle.tpl' title='Создание ДО'}
{foreach from=$log item="item"}
    Создан файл <strong>{$item}</strong><br />
{/foreach}
<br />
<div class="generatorSuccessResult">
Класс "{$name}" успешно добавлен в модуль {$module}.
</div>

<script type="text/javascript">
addClassToModule('{$name}', '{$module}', $A([
{ldelim}url: "{url route="withAnyParam" section="admin" name=$name action="readmap"}", img: "/admin/model.gif", alt: "Схема объекта"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="listActions"}", img: "actions.gif", alt: "Действия классас"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editClass"}", img: "edit.gif", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteClass"}", img: "delete.gif", alt: "Удалить класс"{rdelim}
]));
</script>
