{add file="comments/comments.css"}
<h2>{if !$commentReply}{_ post_comment}{else}{_ reply_comment}{/if}</h2>
<div class="entry-comments">
    {form action=$action method="post"}
        {if isset($validator) && !$validator->isValid()}
        <dl class="errors">
            <dt>Ошибка добавления комментария:</dt>
            <dd>
                <ul>
                {foreach from=$validator->getErrors() item="error"}
                    <li>{$error}</li>
                {/foreach}
                </ul>
            </dd>
        </dl>
        {/if}
        {include file="comments/postForm.tpl"}
    </form>
</div>