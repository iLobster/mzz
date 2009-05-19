/**
 * devToolbar
 */
;(function ($){
    devToolbar = {
        addModule: function(name, links)
        {
            var modules = $('#modulesAndClasses');

            if (modules.length > 0) {
                var elms = modules.find('tbody.toolbarModules');

                var neighbour = this.findNeighbour('module-' + name, elms);

                var mRow = $('<tbody id="module-' + name + '" class="toolbarModules" />')
                             .append($('<tr />').hover(fnOver,fnOut)
                             .append('<th class="name">' + name + '</th>')
                             .append($('<th class="actions" />').append(this.convertLinks(links))));

                var cRow  = $('<tbody id="module-' + name + '-classes" class="toolbarClasses"  />')
                             .append($('<tr class="toolbarEmpty" />')
                             .append('<td colspan="2">--- классов нет ---</td>'));

                if (neighbour) {
                    mRow.insertBefore(neighbour);
                } else {
                    mRow.appendTo(modules);
                }

                cRow.insertAfter(mRow);
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

                var cRow = $('<tr id="class-' + name + '/>')
                            .append('<td class="name">' + name + '</td>')
                            .append($('<td class="actions" />').append(this.convertLinks(links)));

                if (neighbour) {
                    cRow.insertBefore(neighbour);
                } else {
                    cRow.appendTo(classes);
                }

                if (cRow.prev().hasClass('toolbarEmpty')) {
                    cRow.prev().remove();
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
               links[e] = '<a href="' + this.url + '" class="mzz-jip-link"><img src="' + SITE_PATH + '/templates/images/' + this.img + '" title="' + this.alt + '" alt="' + this.alt + '"/ ></a>';
           });
           return $(links.reverse().join(''));
        }

    }
})(jQuery);