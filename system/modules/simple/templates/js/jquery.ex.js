/* 
 * Сахарный довесок для jQuery из Prototype
 */

jQuery.noConflict();
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

    MZZ = { /* MZZ top-level namespace */ };

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