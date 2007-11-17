function buildMenuTree()
{
    var menuTreeImages = {'minus': SITE_PATH + '/templates/images/tree_minus.gif',
    'plus': SITE_PATH + '/templates/images/tree_plus.gif',
    'blank': SITE_PATH + '/templates/images/spacer.gif'};

    function toggleBranch(branch, expanderImage) {
        branch = $(branch);
        expanderImage = $(expanderImage);
        if (branch.getStyle('display') == 'none') {
            branch.show();
            expanderImage.src = menuTreeImages.minus;
        } else {
            branch.hide();
            expanderImage.src = menuTreeImages.plus;
        }
        expanderImage.width = 15;
        expanderImage.height = 15;
    }

    var trees = $A(document.getElementsByTagName("ul"));
    trees.each(function(tree)
    {
        if (!tree.id || !tree.id.match(/^myTree/)) {
            return false;
        }
        $A($(tree).select("li.treeItem")).each(function(elm)
        {
            subbranch = elm.getElementsByTagName("ul");
            if ($A(subbranch).size() > 0) {
                var img_src = ($(subbranch[0]).getStyle('display') == 'none') ? menuTreeImages.plus : menuTreeImages.minus;
            } else {
                var img_src = menuTreeImages.blank;
            }
            var divMenuItem = $(elm).select('div.menuItem')[0];
            divMenuItem.insert({top: '<img src="' + img_src + '" width="15" height="15" class="expandImage" />'});

            Droppables.add(elm,
            {
                accept            : 'treeItem',
                hoverclass        : 'dropOver',
                onHover            : function(dragged, dropped)
                {
                    if(Element.isParent(dropped, dragged)) {
                        return;
                    }

                    if ($(dropped).getStyle('position') != 'static') {
                        $(dropped).setStyle({'position': 'static'});
                    }

                    if (!this.expanded) {
                        subbranches = $A(dropped.getElementsByTagName('ul'));
                        if (subbranches.size() > 0) {
                            subbranch = $(subbranches[0]);
                            var _this = this;

                            if (subbranch.getStyle('display') == 'none') {
                                this.expanded = true;
                                var targetBranch = subbranch;
                                this.expanderTime = (function()
                                {
                                    toggleBranch(targetBranch, targetBranch.parentNode.select('img.expandImage')[0]);
                                    this.expanded = true;
                                }).delay(0.7);

                                var mouseOutEventer = Event.observe($(dropped), 'mouseout', function (event) {
                                    if (_this.expanderTime){
                                        window.clearTimeout(_this.expanderTime);
                                        _this.expanderTime = null;
                                        _this.expanded = false;
                                    }
                                    mouseOutEventer.stop();
                                });

                            }
                        }
                    }
                },

                onDrop: function(dragged, dropped)
                {
                    if(dragged.parentNode.parentNode == dropped) {
                        return;
                    }
                    var droppedId = dropped.id.match(/treeItem-([0-9]+)$/);
                    new Ajax.Request(SITE_PATH + '/menu/' + dragged.id.match(/treeItem-([0-9]+)$/)[1] + '/' + (droppedId && droppedId[1] || 0) + '/move', {
                        method: 'get',
                        onFailure: function(transport) {
                            alert('Перемещение не выполнено');
                        }
                    });

                    if (this.expanderTime) {
                        window.clearTimeout(this.expanderTime);
                        this.expanderTime = null;
                        this.expanded = false;
                    }

                    subbranch = $A(dropped.getElementsByTagName('ul'));

                    if (subbranch.size() == 0) {
                        dropped.insert({bottom: '<ul></ul>'});
                        subbranch = dropped.getElementsByTagName('ul');
                    } else {
                        _subbranch=$(subbranch[0]);
                        if(_subbranch.getStyle('display')=='none'){
                            _subbranch.show();
                        }

                        expandImg = dropped.select('img.expandImage')[0];
                        expandImg.src = menuTreeImages.minus;
                    }

                    oldParent = dragged.parentNode;
                    subbranch[0].appendChild(dragged);

                    new Effect.Highlight(dragged.select('div.menuItemContent')[0]);

                    oldBranches = $(oldParent).select('li');
                    if (oldBranches.size() == 0) {
                        $(oldParent.parentNode).select('img.expandImage').each(function (element) {
                            element.src = menuTreeImages.blank;
                        });
                    }

                    oldBranches = $(oldParent.parentNode).select('li');
                    if (oldBranches.size() == 0) {
                        $(oldParent).remove();
                    }

                    expander = dropped.select('img.expandImage');
                    if (expander[0].src.indexOf('spacer') > -1) {
                        expander[0].src = menuTreeImages.minus;
                    }
                }
            });

            var TreeObserver = Class.create();
            TreeObserver.prototype = {
                initialize: function() {
                },
                onEnd: function(eventName, dragElement, event) {
                    $$('li.treeItem').each(function (_elm) {
                        $(_elm).makePositioned();
                        _elm.style.zIndex = '1';
                    });
                    Droppables.drops.each(function (drop) {
                        if (drop.expanderTime){
                            window.clearTimeout(drop.expanderTime);
                            drop.expanderTime = null;
                            drop.expanded = false;
                        }
                    });

                    dragElement.already = false;
                },
                onStart: function(eventName, dragElement, event) {
                    if (!dragElement.already) {
                        var e = $(dragElement.element);
                        var w = e.setStyle({'width': 'auto', 'height': 'auto'});
                        dragElement.already = true;
                    }
                }
            }

            if (elm.id == 'root') return;

            Draggables.addObserver(new TreeObserver());

            new Draggable(elm, {revert: true, handle: $('textHolder'), ghosting: true,

            reverteffect: function(element, top_offset, left_offset) {
                var widthBefore = element.getWidth();
                if (left_offset > 0) {
                    element.setStyle({width: (parseInt(widthBefore) - left_offset) + 'px'});
                }

                var dur = Math.sqrt(Math.abs(top_offset^2)+Math.abs(left_offset^2))*0.02;
                new Effect.Move(element, { x: -left_offset, y: -top_offset, duration: dur,
                queue: {scope:'_draggable', position:'end'},
                afterFinish: function(obj)
                {
                    obj.element.setStyle({width: '100%', zIndex: '1'});
                }
                });
            }});
        });

        $A(tree.select(".expandImage")).each( function (imgElm) {
            imgElm.observe("click", function(event) {
                if (Event.element(event).src.indexOf('spacer') == -1) {
                    expandImg = event.srcElement || event.target;
                    subbranch = $(expandImg.parentNode.parentNode).select('ul')[0];
                    toggleBranch(subbranch, expandImg);
                }
            }
            );
        }
        );
    });
}