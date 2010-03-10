/* 
 * Сахарный довесок для jQuery из Prototype
 */

var $j = jQuery.noConflict();

/**
 * Cookie tools
 * Made by Vinnie Garcia
 */
var Cookie = {
    set: function(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    },

    get: function(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);
        if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
        } else {
            begin += 2;
        }
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
        return unescape(dc.substring(begin + prefix.length, end));
    },

    remove: function(name, path, domain) {
        if (Cookie.get(name)) {
            document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        }
    }
};

(function ($){

    $.isString = function(object) {
        return typeof object == "string";
    };

    $.isNumber = function(object) {
        return typeof object == "number";
    };

    $.isObject = function(object) {
        return typeof object == "object";
    };
    
    $.isUndefined = function(object) {
        return typeof object == "undefined";
    };

    Array.prototype.remove = function(from, to) {
      var rest = this.slice((to || from) + 1 || this.length);
      this.length = from < 0 ? this.length + from : from;
      return this.push.apply(this, rest);
    };

    MZZ = { /* MZZ top-level namespace */ };
    
    MZZ.tools = {
        AUTO_ID: 1000,

        getId: function() {
            return ++MZZ.tools.AUTO_ID;
        },

        /* simple helper to mark table rows as even or odd in tbody section */
        zebra: function(tableId) {
            $().ready(function(){
                $.each($(tableId).find('tbody tr'), function(index){
                    $(this).addClass(((index % 2 == 0) ? 'even' : 'odd'));
                });
            });
        }
    }
    
    MZZ.browser = DUI.Class.create({

      init: function() {
            this.msie = false;
            this.ie6 = false;
            this.ie7 = false;
            this.ie8 = false;
            this.opera = false;
            this.webkit = false;
            this.konqueror = false;
            this.chrome = false;
            this.safari = false;
            this.gecko = false;
            this.ff = false;

            this.userAgent = navigator.userAgent.toLowerCase();

            if (false /*@cc_on || @_jscript_version < 5.7 @*/) {
                this.msie = this.ie6 = true;
            } else if (false /*@cc_on || @_jscript_version == 5.7 @*/) {
                this.msie = this.ie7 = true;
            } else if (false /*@cc_on || @_jscript_version > 5.7 @*/) {
                this.msie = this.ie8 = true;
            } else if (!!window.opera) {
                this.opera = true;
            } else if (document.childNodes && ( !document.all || navigator.accentColorName ) && !navigator.taintEnabled) {
                this.webkit = true;
                this.konqueror = (navigator.vendor == 'KDE');
                this.chrome = /chrome/.test( this.userAgent );
                this.safari = !this.chrome && /safari/.test( this.userAgent );
            } else if (navigator.product == 'Gecko' && !navigator.savePreferences) {
                this.gecko = true;
                this.ff = /firefox/.test( this.userAgent );
            }
      }

    });

    MZZ.browser = new MZZ.browser;
})(jQuery);

/* IE && Opera`s console.log fix */
if (!window.console) {
	window.console = {
        log: function() {
           if (window.opera) {
               opera.postError(arguments); //use of native opera postError
           } else {
 //              alert(arguments); //other`s ???
           }
        }
    };
}