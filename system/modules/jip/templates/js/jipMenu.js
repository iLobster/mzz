/**
 * Порт jipMenu на jQuery
 * 
 * Возможна работа в режиме noConflict с другими фреймворками
 *
 * проверено в 7 / 8, firefox 3.0.10 / 3.5 beta4, opera 9.64 / 10 alpha, safari 3.2 / 4 beta
 *
 * @bug: не работает ESC в chrome (или это гомно chrome?)
 */

(function ($){
    
    MZZ.jipMenu = DUI.Class.create({
        init: function() {
            this.cMenu = false;
            this.cButton = false;
            this.cLang = false;
            this.cLangId = false;
            this.tMenu = null;
            this.tLang = null;
            this.langs = false;
            this.jipLangMenu = false;
            this.langParent = null;
        },

        eventKey: function(e)
        {
            if (e.keyCode == 27) {
                jipMenu.close();
            }
        },

        close: function() {
            this.mouseOut();
            if (this.cMenu) {
                this.closeLang();
                //this.cMenu.unbind();
                this.cMenu.stop(true, true);
                this.cMenu.hide();
                this.cMenu = false;
                this.cButton.attr({
                    src: SITE_PATH + '/images/jip/jip.gif'
                });
                this.cButton = false;
                $(document).unbind('keypress', this.eventKey);
            }
        },

        closeLang: function() {
            this.mouseInLang();
            if (this.cLang) {
                this.cLang.stop(true, true);
                this.cLang.hide();
                this.cLang = false;
                this.cLangId = false;
                this.cMenu.find('.active').removeClass('active');
            }
        },

        show: function(button, menuId, items, langs) {
            id = 'jip_menu_' + menuId;

            if (!$('#' + id).length || $('#' + id).css('display') == 'none') {
                if (this.cMenu != false && this.cButton != false) {
                    this.close();
                }

                this.draw(button, id, items, langs);
                this.cButton.attr({
                    src: SITE_PATH + '/images/jip/jip_active.gif'
                });
            } else {
                this.close();
            }
        },

        showLang: function(parent, lnk, langs) {
            parent.addClass('active');
            id = parent.attr('id') + '_lang';
            if (!$('#' + id).length) {
                this.drawLang(id, lnk, langs);
            }

            var lang = $('#' + id);
            if (this.cLangId == id) {
                this.mouseInLang();
            } else {
                this.closeLang();
                this.cLang = lang;
                this.cLangId = id;

                var size_p = {
                    width: parent.width(),
                    height: parent.height()
                };
                var pos_p  = parent.offset()
                var size_d = {
                    width: $(window).width(),
                    height: $(window).height()
                };
                var pos_d  = {
                    top: $(window).scrollTop(),
                    left: $(window).scrollLeft()
                };
                var size_l = {
                    width: lang.width(),
                    height: lang.height()
                };

                if ((size_p.width + pos_p.left + size_l.width) > (size_d.width + pos_d.left)) {
                    var x = pos_p.left - 8 - size_l.width;
                } else {
                    var x = pos_p.left + size_p.width + 4;
                }

                var y = pos_p.top - 3;

                lang.css({
                    'position': 'absolute',
                    'top': y,
                    'left': x
                });
                lang.show('fast');
            }
        },

        draw: function(button, id, items, langs) {
            if (!$('#' + id).length) {
                var jipMenuDiv = $('<div />').attr({'id': id}).css({
                    'display': 'none'
                }).appendTo($('body')).addClass('mzz-jip-menu').hover(function() {
                    jipMenu.mouseIn();
                },
                function() {
                    jipMenu.mouseOut();
                });

                var jipMenuUl = $('<ul />').appendTo(jipMenuDiv).addClass('mzz-jip-menu');

                for (var i = 0, l = items.length; i < l; i++) {
                    var elm = items[i];
                    var jipMenuItem = $('<li />').attr({'id': id + '_' + i}).appendTo(jipMenuUl).bind('click', {
                        link: elm[1],
                        target: elm[4]
                    }, this.itemClick);

                    var jipMenuItemA = $('<a />').attr({
                        href: elm[1]
                    }).appendTo(jipMenuItem);

                    if (elm[3]) {
                        jipMenuItemA.addClass('withlang');
                        jipMenuItemA.bind("mouseenter", [elm[1], langs], function (e) {
                            jipMenu.showLang($(this).parent(), e.data[0], e.data[1]);
                        });
                    } else {
                        jipMenuItemA.bind("mouseenter", function () {
                            jipMenu.closeLang();
                        });
                    }

                    var jipMenuIcon = $('<span />').appendTo(jipMenuItemA).addClass('mzz-jip-icon');

                    if ($.isObject(elm[2])) {
                        jipMenuIcon.addClass(elm[2].sprite);
                        if ($.isString(elm[2].index)) {
                            jipMenuIcon.addClass(elm[2].sprite + '-' + elm[2].index);
                            if (elm[2].bullet) {
                                jipMenuIcon.append($('<span class="mzz-bullet mzz-bullet-' + elm[2].bullet + '" />'));
                            }
                        }
                    } else {
                        jipMenuIcon.append('<img src="' + elm[2] + '" alt="." width="16" height="16" />');
                    }

                    $('<span />').appendTo(jipMenuItemA).addClass('mzz-jip-title').text(elm[0]);

                }

            } else {
                var jipMenuDiv = $('#' + id);
                jipMenuDiv.css({
                    'display': 'block'
                });
            }
                
            this.cMenu = jipMenuDiv;
            this.cButton = $(button);
            this.prepareDiv(jipMenuDiv);
            this.setPosition();
            $(document).keypress(this.eventKey);
        },

        drawLang: function(id, lnk, langs) {
            if (!$('#' + id).length) {
                var jipMenuDiv = $('<div />').attr({'id': id}).css({
                    'display': 'none'
                }).appendTo($('body')).addClass('mzz-jip-menu').hover(function() {
                    jipMenu.mouseInLang();
                }, function() {
                    jipMenu.mouseOutLang();
                });
                
                var jipMenuUl = $('<ul />').appendTo(jipMenuDiv).addClass('mzz-jip-menu mzz-jip-menu-lang');
                for (var i in langs) {
                    var elm = langs[i];
                    var linkWithLang = lnk + '?lang_id=' + i;
                    var jipMenuItem = $('<li />')
                        .attr({'id': id + '_' + i}).appendTo(jipMenuUl)
                        .bind('click', linkWithLang, function (e) {
                            jipMenu.close(); return jipWindow.open(e.data);
                        });

                    var jipMenuItemA = $('<a />').attr({href: linkWithLang, title: linkWithLang}).appendTo(jipMenuItem);
                    var jipMenuIcon = $('<span />').appendTo(jipMenuItemA).addClass('mzz-jip-icon mzz-flag mzz-flag-' + elm[0]);
                    $('<span />').appendTo(jipMenuItemA).addClass('mzz-jip-title').text(elm[1]);
                }
            }
        },

        mouseIn: function() {
            if (this.tMenu) {
                clearTimeout(this.tMenu);
                this.tMenu = null;
            }
        },

        mouseOut: function() {
            if (this.tMenu) {
                this.mouseIn();
            }

            if (this.cMenu) {
                this.tMenu = setTimeout("jipMenu.close()", 1000);
            }
        },

        mouseInLang: function() {
            this.mouseIn();
            if (this.tLang) {
                clearTimeout(this.tLang);
                this.tLang = null;
            }
        },

        mouseOutLang: function() {
            this.mouseOut();
            if (this.tLang) {
                this.mouseInLang();
            }

            if (this.cLang) {
                this.tLang = setTimeout("jipMenu.closeLang()", 1000);
            }
        },

        setPosition: function() {
            var size_m = {
                width: this.cMenu.outerWidth(),
                height: this.cMenu.outerHeight()
                };
            var size_b = {
                width: this.cButton.outerWidth(),
                height: this.cButton.outerHeight()
                };
            var pos_b  = this.cButton.offset();
            var size_d = {
                width: $(window).width(),
                height: $(window).height()
                };
            var pos_d  = {
                top: $(window).scrollTop(),
                left: $(window).scrollLeft()
                };

            var x = pos_b.left;
            var y = pos_b.top + size_b.height;

            if ((x + size_m.width) > (size_d.width + pos_d.left)) {
                x = pos_b.left + size_b.width - size_m.width;
            }

            if ((y + size_m.height) > (size_d.height + pos_d.top)) {
                y = pos_b.top - size_m.height;
            }

            x = (x < 0) ? 0 : x;
            y = (y < 0) ? 0 : y;

            this.cMenu.css({
                top: y,
                left: x
            });
        },

        prepareDiv: function (elm)
        {
            elm.css({
                'top': '-500px',
                'left': '-500px',
                'display': 'block'
            });
        },

        itemClick: function (e) {
            jipMenu.close();
            if (e.data.target) {
                window.location = e.data.link;
            } else {
                return jipWindow.open(e.data.link);
            }
            return false;
        }
    });
    
})(jQuery);

var jipMenu = new MZZ.jipMenu;
