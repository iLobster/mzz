<div class="jipTitle">Перемещение каталога "{$folder->getTitle()}" ({$folder->getTreePath()})</div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('dest', 'required')} {$validator->isFieldError('dest', 'error')}">
            Перемещение каталога: <em>'{$folder->getTitle()}'</em>({$folder->getTreePath()}) из <em>{$folder->getTreeParent()->getTitle()}</em>({$folder->getTreeParent()->getTreePath()})
            {form->caption name="dest" value="В каталог"}
            <span class="input">{form->select name="dest" options=$dests styles=$styles size=10 style="width: 100%;" value=$folder->getTreeParent()->getId()}</span>
            {if $validator->isFieldError('dest')}<span class="error">{$validator->getFieldError('dest')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>