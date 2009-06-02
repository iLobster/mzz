{include file='jipTitle.tpl' title="_ move_folder"}
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    {_ from_to $folder->getTitle() $folder->getTreePath()}:
    <ul>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ to_folder"}
            <span class="input">{form->select name="dest" options=$dests size=10 style="width: 80%;" value=$folder->getTreeParent()->getId()}</span>
            {if $form->error('dest')}<div class="error">{$form->message('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>