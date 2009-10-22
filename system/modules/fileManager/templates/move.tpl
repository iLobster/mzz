<div class="jipTitle">Перемещение элемента {$file->getName()}</div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('dest', 'required')} {$validator->isFieldError('dest', 'error')}">
            Перемещение элемента <em>'{$file->getName()}'</em> из каталога {$file->getFolder()->getName()} ({$file->getFolder()->getTreePath()})
            {form->caption name="dest" value="В каталог"}
            <span class="input">{form->select name="dest" styles=$styles options=$dests size=10 style="width: 100%" value=$file->getFolder()->getId()}</span>
            {if $validator->isFieldError('dest')}<span class="error">{$validator->getFieldError('dest')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>