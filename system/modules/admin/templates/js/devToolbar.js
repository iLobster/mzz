/**
 * devToolbar
 */
;(function ($){
    devToolbar = {
        addModule: function(name, links)
        {
            var modules = $('#modulesAndClasses');

            if (modules.length > 0) {
                var elms = modules.find('table');

                var neighbour = this.findNeighbour('module-' + name, elms);


                var mRow = $('<table id="module-' + name + '" class="toolbar admin" cellspacing="0" />')
                             .append($('<thead />')
                             .append($('<tr class="first" />')
                             .append($('<th class="first name" />').append('<img src="' + SITE_PATH + '/images/exp_minus.png" onclick="devToolbar.toggleModule(\'' + name + '\', this);" width="16" height="16" alt="expand/close classes list" title="expand/collapse classes" style="cursor: pointer" />').append(name))
                             .append($('<th class="actions last" />').append(this.convertLinks(links)))))
                             .append('<tbody id="module-' + name + '-classes"><tr class="row last empty"><td class="first">--- классов нет ---</td><td class="last"></td></tr></tbody>');

                if (neighbour) {
                    mRow.insertBefore(neighbour);
                } else {
                    mRow.appendTo(modules);
                }

            } else {
                console.log('devToolbar::addModule #modulesAndClasses not found');
            }
        },

        addClass: function(name, module, links)
        {
            var classes = $('#module-' + module + '-classes');

            if (classes.length > 0) {
                var elms = classes.find('tbody.toolbarClasses');
                var neighbour = this.findNeighbour('class-' + name, elms);

                var cRow = $('<tr id="class-' + name + '" class="" />')
                            .append('<td class="first name">' + name + '</td>')
                            .append($('<td class="last actions" />').append(this.convertLinks(links)));

                if (neighbour) {
                    cRow.insertBefore(neighbour);
                } else {
                    cRow.appendTo(classes);
                }

                if (cRow.prev().hasClass('empty')) {
                    cRow.prev().remove();
                }


                if (!cRow.next().length) {
                    cRow.addClass('last').prev().removeClass('last');
                }

            } else {
                console.log('devToolbar::addModule #module-' + module + '-classes not found');
            }
        },

        findNeighbour: function(name, elms)
        {
            for (var i = 0, l = elms.length; i < l; i++) {
                 elm = $(elms[i]);
                 if (elm.attr('id') >= name) {
                     return elm;
                 }
            }

            return false;
        },

        convertLinks: function(links, target) {
           $.each(links, function(e) {
               links[e] = '<a href="' + this.url + '" class="mzz-jip-link" title="' + this.alt + '"><span class="mzz-icon mzz-icon-' + this.ico + '">' + ((this.over) ? '<span class="mzz-bullet mzz-bullet-' + this.over + '">'  : '') + ((this.over) ? '</span>' : '') + '</span></a>';
           });
           return $(links.join("\n"));
        },

        toggleModule: function(id, img) {
            var elm = $('#module-' + id + '-classes');
            var cook = Cookie.get('mzz-devToolbarH');
            cook = (!cook) ? [] : cook.split(',');

            if (elm.length) {
                elm.toggle();
                var pos = $.inArray(id, cook);
                if (elm.css('display') == 'none' && pos < 0) {
                    $(img).attr({src: SITE_PATH + '/images/exp_plus.png'});
                    cook.push(id);
                } else {
                    $(img).attr({src: SITE_PATH + '/images/exp_minus.png'});
                    cook.splice(pos,1);
                }
            }

            Cookie.set('mzz-devToolbarH', cook.join(','), new Date(new Date().getTime() + 50000000000), ((SITE_PATH == '') ? '/' : SITE_PATH));
            return false;
        }

    }
})(jQuery);

function fillUpEditAclForm()
{
    (function ($) {
        $('#formElm_action_name').attr('value', 'editACL');
        $('#formElm_action_title').attr('value', '_ editACL');
        $('#formElm_action_controller').attr('value', 'neednot');
        $('#formElm_action_jip_1').attr('checked', 'checked');
        $('#formElm_action_403handle').attr('selectedIndex', 2);
        $('#formElm_action_icon').attr('value', 'sprite:mzz-icon/key');
    })(jQuery);
    return false;
}