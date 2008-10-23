var menu = ({
    openedMenuTree: null,

    up: function(id, menu_id)
    {
        var elm = 'item_' + id;
        var prev = $(elm).previousSiblings().first();
        if (prev) {
            prev.insert({before: $(elm)});
        } else {
            $(elm).up('ul').insert($(elm));
        }

        menu.markChanged(elm);
        menu._activateSave(menu_id);

        return false;
    },

    down: function(id, menu_id)
    {
        var elm = 'item_' + id;
        var next = $(elm).next();
        if (next) {
            next.insert({after: $(elm)});
        } else {
            $(elm).up('ul').firstDescendant().insert({before: $(elm)});
        }
        menu.markChanged(elm);
        menu._activateSave(menu_id);

        return false;
    },

    right: function(id, menu_id)
    {
        var elm = 'item_' + id;

        var prev = $(elm).previousSiblings().first();
        if (!prev) {
            return false;
        }
        prev.select('ul').first().insert($(elm));

        menu.markChanged(elm);
        menu._activateSave(menu_id);

        return false;
    },

    left: function(id, menu_id)
    {
        var elm = 'item_' + id;

        var prev = $(elm).up('li');
        if (!prev) {
            return false;
        }
        prev.insert({after: $(elm)});

        menu.markChanged(elm);
        menu._activateSave(menu_id);

        return false;
    },

    toggleTree: function(id, link)
    {
        link = $(link);
        if (this.openedMenuTree) {
            $(this.openedMenuTree).hide();
            this.openedMenuTree = null;
        }
        $(this.openedMenuTree = 'menuTree_content_' + id).show();
        link.up(2).select('a').each(function (e) { e.removeClassName('active'); });
        link.addClassName('active');
    },

    create: function(id)
    {
        Sortable.create('menuTree_' + id, {
            tree: true,
            scroll: window,
            onUpdate: function(e) {
                menu._activateSave(id);
            }
        });
        Draggables.addObserver(new menuObserver('menuTree_' + id));
    },

    save: function(url, id)
    {
        new Ajax.Request(url, {
            method: 'post',
            parameters: { data: Sortable.serialize('menuTree_' + id) },
            onSuccess: function(transport) {
                $('menuTree_' + id + '_apply').disable().setValue('Сохранено...');
                //$('resp').update(transport.responseText);

                $('menuTree_' + id).select('li.treeItemYellow').each(function (e) {
                    $(e).addClassName('treeItemGray').removeClassName('treeItemYellow');
                    $(e).select('div.menuItemTitleYellow').first().addClassName('menuItemTitleGray').removeClassName('menuItemTitleYellow');
                });

            }
        });
    },


    _activateSave: function(id)
    {
        $('menuTree_' + id + '_apply').enable().setValue('Применить');
    },

    markChanged: function(elm)
    {
        elm = $(elm);
        elm.addClassName('treeItemYellow').removeClassName('treeItemGray');
        var title = elm.select('div.menuItemTitleGray').first();
        if (title) {
            title.addClassName('menuItemTitleYellow').removeClassName('menuItemTitleGray');
        }
    }
});



var menuObserver = Class.create({
  initialize: function(element) {
    this.element   = $(element);
    this.lastValue = Sortable.serialize(this.element);
  },

  onStart: function() {
    this.lastValue = Sortable.serialize(this.element);
  },

  onEnd: function(event, draggable) {
      if(this.lastValue != Sortable.serialize(this.element)) {
          menu.markChanged(draggable.element);
      }
  }
});


