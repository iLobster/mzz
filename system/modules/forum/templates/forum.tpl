<a href="{url route=default2 action=new}">показать новые сообщения</a>
{foreach from=$categories item=category name=cat}
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="background-color: #EFF2F5;">
            <td colspan="2" style="height: 32px; width: 54%; padding: 5px; border-bottom: 1px solid #DEE4EB;">{$category->getTitle()}</td>
            <td style="width: 7%; padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Тем</td>
            <td style="width: 7%; padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Сообщений</td>
            <td style="width: 32%; padding: 5px; border-bottom: 1px solid #DEE4EB;">Последнее сообщение</td>
        </tr>
        {foreach from=$category->getForums() item=forum}
            <tr style="background-color: #FBFBFB;">
                <td style="width: 4%; height: 35px; border-bottom: 1px solid #EBEBEB;">
                    {assign var=id value=$forum->getId()}
                    {if not empty($new_forums.$id)}
                        <span style="color: red;">new!!!</span>
                    {else}
                        &nbsp;
                    {/if}
                </td>
                <td style="width: 50%; border-bottom: 1px solid #EBEBEB;"><a href="{url route=withId action=list id=$forum->getId()}">{$forum->getTitle()}</a>{if $forum->getDescription()}<br /><font size="1px"><b>{$forum->getDescription()}</b></font>{/if}</td>
                <td style="width: 7%;text-align: center; border-bottom: 1px solid #EBEBEB;">{$forum->getThreadsCount()}</td>
                <td style="width: 7%;text-align: center; border-bottom: 1px solid #EBEBEB;">{$forum->getPostsCount()}</td>
                <td style="width: 32%;border-bottom: 1px solid #EBEBEB;">{if $forum->getLastPost()->getId()}<a href="{url route=withId action=last id=$forum->getLastPost()->getThread()->getId()}">{$forum->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a><br />{$forum->getLastPost()->getAuthor()->getLogin()}{else}Постов нет{/if}</td>
            </tr>
        {/foreach}
    </table>
        {if not $smarty.foreach.cat.last}
            <br />
        {/if}
{/foreach}