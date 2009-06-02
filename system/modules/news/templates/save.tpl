{if $isEdit}
    <div class="jipTitle">{_ edit_news} ID: {$news->getId()} ({$news->getTitle()|htmlspecialchars|mzz_substr:0:25}...)</div>
{else}
    <div class="jipTitle">{_ create_news}</div>
    {literal}<script type="text/javascript">
    (function($) {
        fileLoader.loadJS(SITE_PATH + '/templates/js/jquery-ui/ui.datepicker.js',
            function(url, type, status){
                if (status == 0 || status == 'success'){
                    $("#calendar-field-created").datepicker({showOn: 'button', buttonImage: SITE_PATH + '/templates/images/calendar.png', buttonImageOnly: true});
                }
            }, null, true);
    })(jQuery);
    </script>{/literal}
{/if}

{form action=$action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('title','required')} {$form->error('title','error')}">
            {form->caption name="title" value="_ title"}
            <span class="input">{form->text name="title" value=$news->getTitle() style="width: 100%"}</span>
            {if $form->error('title')}<span class="error">{$form->message('title')}</span>{/if}
        </li>
        {if !$isEdit}
            <li class="{$form->required('created','required')} {$form->error('created','error')}">
                {form->caption name="created" value="_ creating_date"}
                <span class="input">{form->text name="created" style="width: 93%; margin-right: 1%" id="calendar-field-created" value=$smarty.now|date_format:"%H:%M:%S %d/%m/%Y"}</span>
                {if $form->error('created')}<span class="error">{$form->message('created')}</span>{/if}
            </li>
        {/if}
        <li class="{$form->required('annotation','required')} {$form->error('annotation','error')}">
            {form->caption name="annotation" value="_ annotation"}
            <span class="input">{form->textarea name="annotation" value=$news->getAnnotation() rows="4" style="width: 100%"}</span>
            {if $form->error('annotation')}<span class="error">{$form->message('annotation')}</span>{/if}
        </li>
        <li class="{$form->required('text','required')} {$form->error('text','error')}">
            {form->caption name="text" value="_ text"}
            <span class="input">{form->textarea name="text" value=$news->getText() rows="7" style="width: 100%"}</span>
            {if $form->error('text')}<span class="error">{$form->message('text')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>