{if $isEdit}
    <div class="jipTitle">{_ edit_news} ID: {$news->getId()} ({$news->getTitle()|htmlspecialchars|mzz_substr:0:25}...)</div>
{else}
    <div class="jipTitle">{_ create_news}</div>
    {literal}<script type="text/javascript">
    (function($) {
        fileLoader.loadCSS(SITE_PATH + '/css/calendar-blue.css');
        fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar.js',
            function(url, type, status){
                if (status == 0 || status == 'success'){
                    fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar-ru.js');
                    fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar-setup.js', function() {
                        Calendar.setup({
                            'inputField': 'calendar-field-created',
                            'button': 'calendar-trigger-created',
                            'ifFormat': '%H:%M:%S %d/%m/%Y',
                            "firstDay":1,
                            "showsTime":true,
                            "showOthers":true,
                            "timeFormat":24
                        });
                    });
                }
            }, null, true);
    })(jQuery);
    </script>{/literal}
{/if}

{form action=$action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('title', 'required')} {$validator->isFieldError('title', 'error')}">
            {form->caption name="title" value="_ title"}
            <span class="input">{form->text name="title" value=$news->getTitle() style="width: 100%"}</span>
            {if $validator->isFieldError('title')}<span class="error">{$validator->getFieldError('title')}</span>{/if}
        </li>
        {if !$isEdit}
        <li class="{$validator->isFieldRequired('created', 'required')} {$validator->isFieldError('created', 'error')}">
            {form->caption name="created" value="_ creating_date"}
            <span class="input">{form->text name="created" style="width: 50%;" id="calendar-field-created" value=$smarty.now|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created">...</button></span>
            {if $validator->isFieldError('created')}<span class="error">{$validator->getFieldError('created')}</span>{/if}
        </li>
        {/if}
        <li class="{$validator->isFieldRequired('annotation', 'required')} {$validator->isFieldError('annotation', 'error')}">
            {form->caption name="annotation" value="_ annotation"}
            <span class="input">{form->textarea name="annotation" value=$news->getAnnotation() rows="4" style="width: 100%"}</span>
            {if $validator->isFieldError('annotation')}<span class="error">{$validator->getFieldError('annotation')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('text', 'required')} {$validator->isFieldError('text', 'error')}">
            {form->caption name="text" value="_ text"}
            <span class="input">{form->textarea name="text" value=$news->getText() rows="7" style="width: 100%"}</span>
            {if $validator->isFieldError('text')}<span class="error">{$validator->getFieldError('text')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>