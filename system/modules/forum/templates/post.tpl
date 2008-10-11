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

{form action=$action method="post"}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='vertical-align: top;'>{form->caption name="text" value="Текст сообщения" onError="style=color: red;"}</td>
        </tr>
        <tr>
            <td>{form->textarea name="text" rows="7" cols="50" value=$post->getText()} {$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Отправить"} {form->reset name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{if !$isEdit}
<br />
Обзор темы (новые сверху)
{foreach from=$posts item="ppost"}
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="background-color: #EFF2F5;">
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;">
                <a name="post_{$ppost->getId()}"></a>{$ppost->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{if $ppost->getEditDate()}, отредактировано {$ppost->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}{/if}
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td style="border: 1px solid #DEE4EB; width: 15%; padding: 10px 10px 10px 10px; vertical-align: top;">
                            <strong>{$ppost->getAuthor()->getUser()->getLogin()}</strong><br />
                            Сообщений: {$ppost->getAuthor()->getMessages()}
                        </td>
                        <td style="border: 1px solid #DEE4EB; padding: 10px 10px 10px 10px;">
                            {$ppost->getText()|htmlspecialchars|nl2br}
                            {if $ppost->getAuthor()->getSignature()}
                                <br /><br /><hr />
                                {$ppost->getAuthor()->getSignature()|htmlspecialchars|nl2br}
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
{/foreach}
{/if}