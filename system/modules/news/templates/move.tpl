<div class="jipTitle">{_ move_news} <em>{$news->getTitle()}</em></div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    {_ moving $news->getTitle() $news->getFolder()->getTitle() $news->getFolder()->getTreePath()}
    <ul>
        <li class="{$validator->isFieldRequired('dest', 'required')} {$validator->isFieldError('dest', 'error')}">
            {form->caption name="dest" value="_ to_folder"}
            <span class="input">{form->select name="dest" options=$dests size=10 style="width: 80%;" value=$news->getFolder()->getId()}</span>
            {if $validator->isFieldError('dest')}<span class="error">{$validator->getFieldError('dest')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>