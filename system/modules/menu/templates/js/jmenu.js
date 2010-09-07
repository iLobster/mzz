// REQUIRE:jquery.ex.js;menu/mzz_ns.js
/*
 * черновой вариант, добавить отображение статуса сохранения, вывод ошибки
 * перемещение по "кнопкам" ???
 */

(function($){

    menu = {
        create: function(id) {
            $('#menuTree_' + id).mzz_ns({droppableHeight: 30,
                                        handler: '.menuHandler',
                                        placeHolder: '<li><div class="menuItem yellow"><div class="menuTreeTitle" /><div class="menuActions" /></div></li>',
                                        drop: function(e, ui){
                                            $('#menuApply_' + id).removeAttr('disabled');
                                            ui.sortable.find('div.menuItem').addClass('yellow');
                                        }});
        },

        save: function(url, id) {
            var tree = $('#menuTree_' + id);
            if (tree.length > 0) {
                $('#menuApply_' + id).attr('disabled','disabled');
                var data = tree.mzz_ns('serialize');
                tree.find('div.menuItem.yellow').removeClass('yellow');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    cache: 'false',
                    complete: function(transport, status) {
                        console.log(status, transport);
                    }
                });

            } else {
                console.log('menu::save "#menuTree_' + id +'" not found')
            }
        },

        toggle: function(id) {
            //todo : переключение на "другое" меню после фикса добавления меню
            $('body').find('.menuContent:visible').hide();
            var content = $('#menuContent_' + id);
            content.show();
            var link = $('#menuLink_' + id);
            link.addClass('active');
        }

    };

})(jQuery);