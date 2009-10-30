{if $typeId == 'menuItemMapper::ITEMTYPE_ADVANCED'|constant}
<script type="text/javascript">
{literal}var routeMap = {};
(function($) {{/literal}
    {foreach from=$routesParts item="parts" key="routeName"}
    {strip}
    routeMap['{$routeName}'] = new Array(
    {foreach from=$parts item="part" name="partsIteration"}
    {assign var="partName" value=$part.name}
    {ldelim}name: '{$partName}', isVar: '{$part.isVar}', regex: '{$part.regex}', value: '{$part.value}'{rdelim}{if !$smarty.foreach.partsIteration.last}, {/if}
    {/foreach}
    );
    {/strip}
    {/foreach}
{literal}
    getRoute = function (routeName, fieldName, to) {
        fieldName = fieldName || 'parts';
        to = to || 'routeParams';
        route = routeMap[routeName];

        var routeParamsHolder = $('#' + to);
        if (route && routeParamsHolder) {
            routeParamsHolder.empty();
            for (var i = 0; i < route.length; i++) {
                var input = $('<tr><td>' + route[i].name + ':' + '</td><td><input type="text" name="' + fieldName + '[' + route[i].name + ']' + '" value="' + route[i].value + '" /></td></tr>');
                routeParamsHolder.append(input);
            }
        }
    }

    addActiveRoute = function() {
        var newSelect = $('#activeRouteSelect').clone(true);
        newSelect.attr({disabled: '', id: null}).css({display: 'inline'});
        var _lastActiveRouteNumber = lastActiveRouteNumber;
        newSelect.change(function(){
            getRoute(this.value, 'activeParts[' + _lastActiveRouteNumber + ']', 'routeActiveParams-' + _lastActiveRouteNumber);
        });

        var holderTd = $('<td/>').append(newSelect).append($('<span> \(<a href="#" onclick="return removeActiveRoute(this) && false;">удалить</a>\) и его параметры:</span>'));
        holderTd.append($('<table id="routeActiveParams-' + lastActiveRouteNumber + '" cellpadding="2" cellspacing="0"><tr><td></td></tr></table>'));
        var newTr = $('<tr class="activeRoute"><td></td></tr>').append(holderTd);

        $('.activeRoute:last').after(newTr);
        lastActiveRouteNumber++;
    }

    removeActiveRoute = function(trigger) {
        $(trigger).closest('tr.activeRoute').remove();
    }
})(jQuery);{/literal}
</script>
{/if}

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="grayBorder">
    <tr>
        <td style="width: 20%">{form->caption name="title" value="Заголовок:"}</td>
        <td style="width: 80%;">{form->text name="title" size=40 value=$item->getTitle()} {$validator->getFieldError('title')}</td>
    </tr>
    {if $typeId == 'menuItemMapper::ITEMTYPE_EXTERNAL'|constant}
    <tr>
        <td style="width: 20%">{form->caption name="url" value="URL:"}</td>
        <td style="width: 80%;">{form->text name="url" size=40 value=$item->getUrl()} {$validator->getFieldError('url')}</td>
    </tr>
    {elseif $typeId == 'menuItemMapper::ITEMTYPE_SIMPLE'|constant}
    <tr>
        <td style="width: 20%">{form->caption name="url" value="URL:"}</td>
        <td style="width: 80%;">{$request->getUrl()}/{if $i18nEnabled}&lt;{$request->getString(lang)}&gt;/{/if}{form->text name="url" size=40 value=$item->getUrl(false, false)} {$validator->getFieldError('url')}</td>
    </tr>
    {elseif $typeId == 'menuItemMapper::ITEMTYPE_ADVANCED'|constant}
    <tr>
        <td>{form->caption name="activeRegExp" value="Определение активности:"}</td>
        <td>{form->text name="activeRegExp" size=40 value=$item->getActiveRegExp()} <span class="helpText">(pcre / регулярное выражение)</span> {$validator->getFieldError('activeRegExp')}</td>
    </tr>
    <tr>
        <td>{form->caption name="route" value="Роут:"}</td>
        <td>{form->select name="route" options=$routesSelect emptyFirst=true onchange="javascript: getRoute(this.value);" onkeyup="this.onchange();" value=$current|default:null} и его параметры:</td>
    </tr>
    <tr>
        <td style="vertical-align: top;">&nbsp;</td>
        <td style="vertical-align: top;">
            <table id="routeParams" cellpadding="2" cellspacing="0">
            {if $current|default:false}
                {foreach from=$routesParts[$current] item="part"}
                {assign var="partName" value=$part.name}
                <tr>
                    <td>{$partName}:</td>
                    <td>
                        {form->text name="parts[$partName]" value=$part.value}
                    </td>
                </tr>
                {/foreach}
            {else}
            <tr><td></td></tr>
            {/if}
            </table>
        </td>
    </tr>
    <tr class="activeRoute">
        <td>Активность для роутов:</td>
        <td><a href="javascript: addActiveRoute(); ">Добавить</a>
        {form->select name="routeActive[]" options=$routesSelect emptyFirst=true onkeyup="this.onchange();" value=null id="activeRouteSelect" style="display: none" disabled="disabled"}</td>
    </tr>

    {assign lastActiveRouteNumber=0}
    {assign activeRoutes=$item->getActiveRoutes()}
    {foreach from=$activeRoutes item="activeRoute" key="key"}
    {assign current=$activeRoute.route}
    <tr class="activeRoute">
        <td></td>
        <td>{form->select name="routeActive[]" options=$routesSelect emptyFirst=true onchange="javascript: getRoute(this.value, 'activeParts[$lastActiveRouteNumber]', 'routeActiveParams');" onkeyup="this.onchange();" value=$current|default:null}
        (<a href="#" onclick="return removeActiveRoute(this) && false;">удалить</a>) и его параметры:
            <table id="routeActiveParams" cellpadding="2" cellspacing="0">
            {foreach from=$routesParts[$current] item="part"}
                {assign var="partName" value=$part.name}
                <tr>
                    <td>{$partName}:</td>
                    <td>
                        {form->text name="activeParts[$lastActiveRouteNumber][$partName]" value=$activeRoute.params.$partName|default:''}
                    </td>
                </tr>
            {/foreach}
            </table>
        </td>
    </tr>
    {assign var="lastActiveRouteNumber" value=$lastActiveRouteNumber+1}
    {/foreach}
    <script type="text/javascript"> var lastActiveRouteNumber = {$lastActiveRouteNumber};</script>
    {/if}
    <tr>
        <td></td>
        <td style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}{form->hidden name="type" value=$typeId}</td>
    </tr>
</table>