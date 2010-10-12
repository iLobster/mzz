// REQUIRE:dui.js
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

    // Tries to execute a number of functions. Returns immediately the return value of the
    // first non-failed function without executing successive functions, or null.
    $.Try = function(){
        for (var i = 0, l = arguments.length; i < l; i++){
            try {
                return arguments[i]();
            } catch(e){}
        }
        return null;
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
        },

        lastzIndex: function(selector, minz) {
            var minz = minz || 10000;
            var selector = selector || 'body > *';
            var z = Math.max.apply(null,$.map($(selector), function(e,n){
                if($(e).css('position')=='absolute') {
                    return parseInt($(e).css('z-index'))||1 ;
                }
            }));

            return (z < minz) ? minz : z;
        }
    }

    // Browser detection, taken from mootools # http://mootools.net/docs/core/Core/Browser

    MZZ.Browser = {
        Engine: {name: 'unknown', version: 0},

        Platform: {name: (window.orientation != undefined) ? 'ipod' : (navigator.platform.match(/mac|win|linux/i) || ['other'])[0].toLowerCase()},

        Features: {xpath: !!(document.evaluate), air: !!(window.runtime), query: !!(document.querySelector)},

        Engines: {

            presto: function(){
                return (!window.opera) ? false : ((arguments.callee.caller) ? 960 : ((document.getElementsByClassName) ? 950 : 925));
            },

            trident: function(){
                return (!window.ActiveXObject) ? false : ((window.XMLHttpRequest) ? ((document.querySelectorAll) ? 6 : 5) : 4);
            },

            webkit: function(){
                return (navigator.taintEnabled) ? false : ((MZZ.Browser.Features.xpath) ? ((MZZ.Browser.Features.query) ? 525 : 420) : 419);
            },

            gecko: function(){
                return (!document.getBoxObjectFor && window.mozInnerScreenX == null) ? false : ((document.getElementsByClassName) ? 19 : 18);
            }

        },

        Plugins: {},

        _detect: function(){

            for (var engine in this.Engines){
                var version = this.Engines[engine]();
                if (version){
                    this.Engine = {
                        name: engine,
                        version: version
                    };
                    this.Engine[engine] = this.Engine[engine + version] = true;
                    break;
                }
            }

            return {
                name: engine,
                version: version
            };

        }
    };

    MZZ.Browser.Platform[MZZ.Browser.Platform.name] = true;
    MZZ.Browser._detect();

    MZZ.Browser.Request = function(){
        return $.Try(function(){
            return new XMLHttpRequest();
        }, function(){
            return new ActiveXObject('MSXML2.XMLHTTP');
        }, function(){
            return new ActiveXObject('Microsoft.XMLHTTP');
        });
    };

    MZZ.Browser.Features.xhr = !!(MZZ.Browser.Request());

    MZZ.Browser.Plugins.Flash = (function(){
        var version = ($.Try(function(){
            return navigator.plugins['Shockwave Flash'].description;
        }, function(){
            return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version');
        }) || '0 r0').match(/\d+/g);
        return {
            version: parseInt(version[0] || 0 + '.' + version[1], 10) || 0,
            build: parseInt(version[2], 10) || 0
            };
    })();

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