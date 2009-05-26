{assign var="commentsFolderId" value=$commentsFolder->getId()}
<h3><a href="{url route="withId" section="comments" action="post" id=$commentsFolderId}" class="selected" onclick="moveCommentForm(0, {$commentsFolderId}, this); return false;">{_ post_comment}</a></h3>
<div id="answerForm_{$commentsFolderId}_0">
    {form id="commentForm_$commentsFolderId" action=$action method="post"}
        {if !$errors->isEmpty()}
        <dl class="errors">
            <dt>Ошибка добавления комментария:</dt>
            <dd>
                <ol>
                {foreach from=$errors item="error"}
                    <li>{$error}</li>
                {/foreach}
                </ol>
            </dd>
        </dl>
        {/if}
        <dl>
            <dt>{form->caption name="text" value="Текст:" onError=""}</dt>
            <dd>{form->textarea name="text" value=$comment->getText() rows="5" cols="5"}</dd>
        </dl>
        <p>
            {form->hidden name="backUrl" value=$backUrl}
            {form->submit class="send" name="commentSubmit" value="Отправить комментарий"}
        </p>
    </form>
</div>