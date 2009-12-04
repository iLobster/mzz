<h3>{if $isEdit}Edit{else}Create{/if} a post</h3>

{form action=$form_action method="post"}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="post[name]" value="Name"}</td>
            <td>
                {form->text name="post[name]" size="30" value=$post->getName()}
                {if $validator->isFieldError('post[name]')}<div class="error">{$validator->getFieldError('post[name]')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="post[title]" value="Title"}</td>
            <td>
                {form->text name="post[title]" size="30" value=$post->getTitle()}
                {if $validator->isFieldError('post[title]')}<div class="error">{$validator->getFieldError('post[title]')}</div>{/if}
            </td>
        </tr>
        {if !$isEdit}
        <tr>
            <td>{form->caption name="post[created_at]" value="Created at"}</td>
            <td>
                {form->text name="post[created_at]" size="30" value=$smarty.now|date_format:"%H:%M:%S %d/%m/%Y"}
                {if $validator->isFieldError('post[created_at]')}<div class="error">{$validator->getFieldError('post[created_at]')}</div>{/if}
            </td>
        </tr>
        {/if}
        <tr>
            <td valign="top">{form->caption name="post[content]" value="Content"}</td>
            <td>
                {form->textarea name="post[content]" rows="10" cols="45" value=$post->getContent()}
                {if $validator->isFieldError('post[content]')}<div class="error">{$validator->getFieldError('post[content]')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"}</td>
        </tr>
    </table>
</form>