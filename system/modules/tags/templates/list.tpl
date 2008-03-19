{literal}
<script type="text/javascript">
function tagMarqueeShow(x, y, w, h) {
    MarqueeTool = new Marquee(imageId, {
        color: '#444', opacity: 0.5, hideEdges: true,
        coords: {x1: x, y1: y, width: w, height: h}
    });
    MarqueeTool.disable();
}

var newTagTpl = '<span onmouseout="destroyMarqueeTool()" onmouseover="tagMarqueeShow(#{x}, #{y}, #{w}, #{h});">#{tag}</span>';
</script>
{/literal}
<div class="tagList">
{foreach name=tagsList from=$tags item=tag}
{assign var="coords" value=$tag->getCoords()}
<a href="{url route=tags tag=$tag->getTag() section=$section}" onmouseout="destroyMarqueeTool()" onmouseover="tagMarqueeShow({$coords.x}, {$coords.y}, {$coords.w}, {$coords.h});">{$tag->getTag()}</a>
{$coords.w} {$coords.h} {$coords.x} {$coords.y}
{if !$smarty.foreach.tagsList.last}, {/if}
{/foreach}
</div>

<script type="text/javascript">
var tagCoords = [
{foreach name=tagsList from=$tags item=tag}
{assign var="coords" value=$tag->getCoords()}
[{$coords.x}, {$coords.y}, {$coords.x+$coords.w}, {$coords.y+$coords.h}, "{$tag->getTag()|htmlspecialchars}"]{if !$smarty.foreach.tagsList.last}, {/if}
{/foreach}
];
{literal}
var offsets = null;
var offsetsLeft = 0;
var offsetsTop = 0;
var offsetsWidth = 0;
var offsetsHeight = 0;
var offsetK = 3;
var tagtimerID = 0;
var textHolder = null;

Event.observe(window, 'load', function () {
    offsets = $(imageId).cumulativeOffset();
    offsetsLeft = offsets[0] + 1;
    offsetsTop = offsets[1];
    offsetsWidth = $(imageId).clientWidth;
    offsetsHeight = $(imageId).clientHeight;

    $(imageId).observe('mousemove', function(e) {
        var points = Event.pointer(e);
        var x = points.x;
        var y = points.y;
//alert(tagCoords[7]);
        $A(tagCoords).each(function (coord) {
            if (x >= offsetsLeft + coord[0] && y >= offsetsTop + coord[1] &&
            x <= offsetsLeft + coord[2] && y <= offsetsTop + coord[3]) {
                clearTimeout(tagtimerID);
                //alert(tagtimerID)
                textHolder = $($($(imageId).up()).select('span').first());
                textHolder.innerHTML = coord[4];
                textHolder.style.left = coord[0] + offsetsLeft + 'px';
                textHolder.style.top = coord[3] + offsetsTop - offsetK + 'px';
                textHolder.style.width = coord[2] - coord[0] + 'px';
                textHolder.show();

                textHolder.stopObserving('mousemove');
                textHolder.stopObserving('mouseout');

                textHolder.observe('mousemove', function () {
                    clearTimeout(tagtimerID);
                    tagtimerID = 0;
                });
                textHolder.observe('mouseout', function () {
                    tagtimerID = setTimeout(function () { textHolder.hide(); }, 100);
                });

                if (textHolder.clientHeight + coord[3] > offsetsHeight) {
                    textHolder.style.top = coord[3] + offsetsTop - textHolder.clientHeight - offsetK + 'px';
                }
                if (textHolder.clientWidth + coord[0] > offsetsWidth) {
                    textHolder.style.left = offsetsWidth + offsetsLeft - textHolder.clientWidth - offsetK + 'px';
                }
                throw $break;
            } else {
                textHolder = $($($(imageId).up()).select('span').first());
                textHolder.innerHTML = '';
                textHolder.hide();
            }
        });
    });
});
</script>
{/literal}


<a class="jipLink" href="{url route=withId id=$item_obj_id section=tags action=editTags}">Добавить тэги</a>