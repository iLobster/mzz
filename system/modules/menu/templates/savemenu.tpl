<div class="jipTitle">{if $isEdit}Редактирование{else}Создание{/if}</div>
{form action=$action method="post" jip=true}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="Имя:"}
    </div>
    <div class="text">
        {form->text name="name" size="60" value=$menu->getName()}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="Сохранить"} {form->reset jip="true" name="reset" value="Отмена"}
    </div>
</div>
</form>