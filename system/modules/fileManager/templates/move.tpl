<div class="jipTitle">Перемещение элемента {$file->getName()}</div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('dest', 'required')} {$form->error('dest', 'error')}">
            Перемещение элемента <em>'{$file->getName()}'</em> из каталога {$file->getFolder()->getName()} ({$file->getFolder()->getTreePath()})
            {form->caption name="dest" value="В каталог"}
            <span class="input">{form->select name="dest" styles=$styles options=$dests size=10 style="width: 100%" value=$file->getFolder()->getId()}</span>
            {if $form->error('dest')}<span class="error">{$form->message('dest')}</span>{/if}
        </tr>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>