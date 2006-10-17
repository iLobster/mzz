Добавление пользователей в группу <b>{$group->getName()}</b><br />
<form action="{url}" id='filterForm' method="get" onsubmit="xajax_update(this.filter.value); return false; var xajaxRequestUri = xajaxRequestUri + '/?filter=' + this.filter.value;">
    <input type="text" value="{$filter}" name="filter"><input type="image" src="/templates/images/search.gif">
</form>
<div id='users' style='width: 100%;'>
</div>