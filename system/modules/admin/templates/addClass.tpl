{if $isEdit}
{include file='jipTitle.tpl' title='Редактирование класса'}
{else}
{include file='jipTitle.tpl' title='Добавление класса'}
{/if}
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="Название"}</td>
            <td>{form->text name="name" value=$data.name size="60"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="table" value="Имя таблицы"}</td>
            <td>
                {if $isEdit}
                {else}
                    {form->text name="table" value=$data.table size="60"}{$errors->get('table')}
                {/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="dest" value="Каталог генерации"}</td>
            <td>{$data.dest}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>