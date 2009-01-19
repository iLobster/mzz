{if $typeId == 'menuItemMapper::ITEMTYPE_ADVANCED'|constant}
<script type="text/javascript">
var routeMap = new Hash();
{foreach from=$routesParts item="parts" key="routeName"}
{strip}
routeMap.set('{$routeName}', new Array(
{foreach from=$parts item="part" name="partsIteration"}
{assign var="partName" value=$part.name}
new Hash({ldelim}name: '{$partName}', isVar: '{$part.isVar}', regex: '{$part.regex}', value: '{$part.value}'{rdelim}){if !$smarty.foreach.partsIteration.last}, {/if}
{/foreach}
));{/strip}
{/foreach}

{literal}
function getRoute(routeName)
{
    route = routeMap.get(routeName);
    $('routeParams').update('');
    if (route) {
        for (var i = 0; i < route.length; i++) {
            var input = new Element('input', {type: 'text', name: 'parts[' + route[i].get('name') + ']', value: route[i].get('value')});

            var newTitleTd = new Element('td').update(route[i].get('name') + ':');
            var newInputTd = new Element('td').insert(input);

            var newInputTr = new Element('tr').insert(newTitleTd).insert(newInputTd);

            $('routeParams').insert(newInputTr);
        }
    }
}
{/literal}
</script>
{/if}

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="grayBorder">
    <tr>
        <td style="width: 20%">{form->caption name="title" value="Заголовок:"}</td>
        <td style="width: 80%;">{form->text name="title" size=40 value=$item->getTitle()} {$errors->get('title')}</td>
    </tr>
    {if $typeId == 'menuItemMapper::ITEMTYPE_EXTERNAL'|constant}
    <tr>
        <td style="width: 20%">{form->caption name="url" value="URL:"}</td>
        <td style="width: 80%;">{form->text name="url" size=40 value=$item->getUrl()} {$errors->get('url')}</td>
    </tr>
    {elseif $typeId == 'menuItemMapper::ITEMTYPE_SIMPLE'|constant}
    <tr>
        <td style="width: 20%">{form->caption name="url" value="URL:"}</td>
        <td style="width: 80%;">{$request->getUrl()}/{if $i18nEnabled}&lt;{$request->getString(lang)}&gt;{/if}{form->text name="url" size=40 value=$item->getUrl()} {$errors->get('url')}</td>
    </tr>
    {elseif $typeId == 'menuItemMapper::ITEMTYPE_ADVANCED'|constant}
    <tr>
        <td>{form->caption name="activeRegExp" value="Определение активности:"}</td>
        <td>{form->text name="activeRegExp" size=40 value=$item->getActiveRegExp()} <span class="helpText">(pcre / регулярное выражение)</span> {$errors->get('activeRegExp')}</td>
    </tr>
    <tr>
        <td>{form->caption name="route" value="Роут:"}</td>
        <td>{form->select name="route" options=$routesSelect emptyFirst=true onchange="javascript: getRoute(this.value);" value=$current|default:null} и его параметры:</td>
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
    {/if}
    <tr>
        <td style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}{form->hidden name="type" value=$typeId}</td>
    </tr>
</table>