{assign var="commentsFolderId" value=$commentsFolder->getId()}
{if $hideForm}{assign var="formStyle" value="display: none;"}{else}{assign var="formStyle" value=""}{/if}
{form id="commentForm_$commentsFolderId" action=$action method="post" style=$formStyle onsubmit="comments.postForm(this); return false;"}
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