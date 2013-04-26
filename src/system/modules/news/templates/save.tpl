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
<div class="field{$validator->isFieldRequired('title', ' required')}{$validator->isFieldError('title', ' error')}">
    <div class="label">
        {form->caption name="title" value="_ title"}
    </div>
    <div class="text">
        {form->text name="title" value=$news->getTitle()}
        <span class="caption error">{$validator->getFieldError('title')}</span>
    </div>
</div>
{if !$isEdit}
<div class="field{$validator->isFieldRequired('created', ' required')} {$validator->isFieldError('created', ' error')}">
    <div class="label">
        {form->caption name="created" value="_ creating_date"}
    </div>
    <div class="text">
        {form->text name="created" style="width: 50%;" id="calendar-field-created" value=$smarty.now|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created">...</button>
        <span class="caption error">{$validator->getFieldError('created')}</span>
    </div>
</div>
{/if}
<div class="field{$validator->isFieldRequired('annotation', ' required')} {$validator->isFieldError('annotation', ' error')}">
    <div class="label">
        {form->caption name="annotation" value="_ annotation"}
    </div>
    <div class="text">
        {form->textarea name="annotation" value=$news->getAnnotation() rows="4"}
        <span class="caption error">{$validator->getFieldError('annotation')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('text', ' required')} {$validator->isFieldError('text', ' error')}">
    <div class="label">
        {form->caption name="text" value="_ text"}
    </div>
    <div class="text">
        {form->textarea name="text" value=$news->getText() rows="7"}
        <span class="error">{$validator->getFieldError('text')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>