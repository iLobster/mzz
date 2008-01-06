{title append="Форум"}
{title append=$thread->getForum()->getTitle()}
{title append=$thread->getTitle()}

<a href="{url route="default2" action="forum"}">Форум</a> / <a href="{url route="withId" action="list" id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a> / <a href="{url route="withId" action="thread" id=$thread->getId()}">{$thread->getTitle()}</a> /
{if $isEdit}
    {title append="Редактирование поста"}
    Редактирование поста
{else}
    {title append="Создание нового поста"}
    Создание нового поста
{/if}

<form action="{$action}" method="post">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='vertical-align: top;'>{form->caption name="text" value="Текст сообщения" onError="style=color: red;"}</td>
        </tr>
        <tr>
            <td>{form->textarea name="text" rows="7" cols="50" value=$post->getText()}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Отправить"} {form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
<br />
Обзор темы (новые сверху)
{foreach from=$posts item="ppost"}
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="background-color: #EFF2F5;">
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;">
                <a name="post_{$ppost->getId()}"></a>{$ppost->getAuthor()->getLogin()}, {$ppost->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{if $ppost->getEditDate()}, отредактировано {$ppost->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}{/if}
            </td>
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;" align="right">
            {*{math equation="(page - 1)* per_page + number" page=$pager->getRealPage() per_page=$pager->getPerPage() number=$smarty.foreach.post_cycle.iteration assign=post_number}
                <a href="{url route="withId" id=$post->getId() action="goto"}">#{$post_number}</a>*}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #DEE4EB; padding: 10px 10px 10px 10px" colspan="2">{$ppost->getText()|htmlspecialchars|nl2br}</td>
        </tr>
    </table>
{/foreach}