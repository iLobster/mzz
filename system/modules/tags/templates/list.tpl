{foreach name=tagsList from=$tags item=tag}
{assign var="coords" value=$tag->getCoords()}
<a href="{url route=tags tag=$tag->getTag() section=$section}" onmouseout="if(MarqueeTool) MarqueeTool.hide(); MarqueeTool = null;" onmouseover="
MarqueeTool = new Marquee('galleryPhoto', {ldelim}color: '#444', opacity: 0.5, hideEdges: true, coords: {ldelim}x1: {$coords.x}, y1: {$coords.y}, width: {$coords.w}, height: {$coords.h}{rdelim}{rdelim}); MarqueeTool.disable();">{$tag->getTag()}</a>

{$coords.w} {$coords.h} {$coords.x} {$coords.y}

{if !$smarty.foreach.tagsList.last}, {/if}

{/foreach}


<script type="text/javascript">
var tagCoords = [
{foreach name=tagsList from=$tags item=tag}
{assign var="coords" value=$tag->getCoords()}
[{$coords.x}, {$coords.y}, {$coords.x+$coords.w}, {$coords.y+$coords.h}, "{$tag->getTag()|htmlspecialchars}"]{if !$smarty.foreach.tagsList.last}, {/if}
{/foreach}
];
{literal}

var offsets = $('galleryPhoto').cumulativeOffset();
var offsetsLeft = offsets[0] + 1;
var offsetsTop = offsets[1];
var offsetsWidth = $('galleryPhoto').clientWidth;
var offsetsHeight = $('galleryPhoto').clientHeight;
var offsetK = 3;

$('galleryPhoto').observe('mousemove', function(e) {
    for (var i in tagCoords) {
        if (x >= offsetsLeft + tagCoords[i][0] && y >= offsetsTop + tagCoords[i][1] &&
        x <= offsetsLeft + tagCoords[i][2] && y <= offsetsTop + tagCoords[i][3]) {
            var textHolder = $($($('galleryPhoto').up()).select('span').first());
            textHolder.innerHTML = tagCoords[i][4];
            textHolder.style.left = tagCoords[i][0] + offsetsLeft + 'px';
            textHolder.style.top = tagCoords[i][3] + offsetsTop + 'px';
            textHolder.style.width = tagCoords[i][2] - tagCoords[i][0] + 'px';
            textHolder.show();


            if (textHolder.clientHeight + tagCoords[i][3] > offsetsHeight) {
                textHolder.style.top = tagCoords[i][3] + offsetsTop - textHolder.clientHeight - offsetK + 'px';
            }
            if (textHolder.clientWidth + tagCoords[i][0] > offsetsWidth) {
                textHolder.style.left = offsetsWidth + offsetsLeft - textHolder.clientWidth - offsetK + 'px';
            }
            break;
        }
    }
});
</script>
{/literal}
<a class="jipLink" href="{url route=withId id=$item_obj_id section=tags action=editTags}">Добавить тэги</a>