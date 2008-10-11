{if $isEdit}
{include file='jipTitle.tpl' title='Редактирование модуля'}
{else}
{include file='jipTitle.tpl' title='Добавление модуля'}
{/if}
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 30%;">{form->caption name="name" value="Имя"}</td>
            <td>{if $nameRO}
            {$data.name}
            {else}
            {form->text name="name" size="30" value=$data.name}{$errors->get('name')}
            {/if}</td>
        </tr>
        <tr>
            <td>{form->caption name="dest" value="Каталог генерации"}</td>
            <td>{form->select name="dest" options=$dests one_item_freeze=1}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="title" value="Название"}</td>
            <td>{form->text name="title" size="30" value=$data.title}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="icon" value="Иконка"}</td>
            <td>{form->text name="icon" size="30" value=$data.icon}{$errors->get('icon')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="order" value="Порядок сортировки:"}</td>
            <td>{form->text name="order" size="30" value=$data.order|default:"0"}{$errors->get('order')}</td>
        </tr>
        {if $isEdit}
            <tr>
                <td style="width: 30%;">{form->caption name="main_class" value="Главный класс:"}</td>
                <td>{form->select name="main_class" options=$classes_select value=$data.main_class}{$errors->get('main_class')}</td>
            </tr>
        {/if}
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>