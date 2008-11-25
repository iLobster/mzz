var photoPreviewsScroller = Class.create({
    initialize: function(elmId, options)
    {
        this.scrollInterval = false;
        this.elm = $(elmId);
        this.options = $H({
            minWidth: 279,
            scrollStep: 88
        });
        Object.extend(this.options, options || { });

        this.startScrollEvent = this.startScroll.bindAsEventListener(this);
        this.stopScrollEvent = this.stopScroll.bindAsEventListener(this);

        /*Event.observe(this.elm, "mousewheel", this.startScroll.bindAsEventListener(this));
        Event.observe(this.elm, "DOMMouseScroll", this.startScroll.bindAsEventListener(this));*/
        this.elm.observe("mousewheel", this.startScrollEvent);
        this.elm.observe("DOMMouseScroll", this.startScrollEvent);
    },

    scrollTo: function(step)
    {
        step = step || 1;

        var currentMargin = parseInt(this.elm.getStyle('margin-left'));
        var elmWidth = this._getElementWidth();
        if (Prototype.Browser.Opera || Prototype.Browser.IE) {
            elmWidth += currentMargin;
        }

        var viewed = parseInt(this.options.get('minWidth') / this.options.get('scrollStep'));
        var total = parseInt(this._getElementWidth() / this.options.get('scrollStep'));
        var rightSkip = parseInt((viewed - 1) / 2);
        //var leftSkip = viewed - rightSkip;
        step -= rightSkip;
        //  var difference =
        if (step <= 0) return;


        $$('img.previewScroll').each(function(elm) {
            elm = elm.up();
            if (elm.getStyle('display') == 'none') {
                elm.setStyle({display: 'block'});
            }
        });
        currentMargin -= this.options.get('scrollStep') * step;

        this.elm.setStyle({marginLeft: currentMargin + 'px'});

        // прячем кнопки, если ими нельзя скроллить
        this._hideButtons();

    },

    _hideButtons: function()
    {
        var currentMargin = parseInt(this.elm.getStyle('margin-left'));
        elm = $$('img.previewScroll').first().up();
        elm.setStyle({display: (currentMargin >= 0) ? 'none' : 'block'});
        if (elm.style.display == 'none') {
            elm.onmouseup();
        }

        var elmWidth = this._getElementWidth();

        elm = $$('img.previewScroll').last().up();
        elm.setStyle({display: (elmWidth < this.options.get('minWidth')) ? 'none' : 'block'});
        if (elm.style.display == 'none') {
            elm.onmouseup();
        }
    },

    _getElementWidth: function()
    {
        var elmWidth = this.elm.getWidth();
        if (Prototype.Browser.Opera || Prototype.Browser.IE || navigator.userAgent.indexOf('Firefox') > -1) {
            var currentMargin = parseInt(this.elm.getStyle('margin-left'));
            elmWidth += currentMargin;
        }
        return elmWidth;
    },

    startScroll: function(direction)
    {
        // direction: 0 - left, 1 - right
        direction = direction == 'right' ? 1 : direction;
        if (this.scrollInterval) {
            return;
        }
        var  isWheel = false;
        if(typeof(direction) == 'object') {
            isWheel = true;
            direction.stop();
            if (direction.wheelDelta) { // IE & Opera
                direction = direction.wheelDelta;
                direction = direction > 0;
            } else if (direction.detail) { // W3C
                direction = direction.detail;
                direction = direction < 0;
            } else {
                return false;
            }
        }

        this.elm.observe('mouseout', this.stopScrollEvent);

        var _this = this;
        var scrollFunc = function() {//alert((!direction && _this.elm.getWidth() > _this.options.get('minWidth')) || (direction && currentMargin < 0));
            var currentMargin = parseInt(_this.elm.getStyle('margin-left'));
            var elmWidth = _this._getElementWidth();
            if (Prototype.Browser.Opera || Prototype.Browser.IE) {
                elmWidth += currentMargin;
            }

            var allowRigthScroll = direction && currentMargin < 0;
            var allowLeftScroll = !direction && elmWidth > _this.options.get('minWidth');


            if (allowRigthScroll || allowLeftScroll) {

                if (direction) {
                    currentMargin += _this.options.get('scrollStep');
                } else {
                    $$('img.previewScroll').each(function(elm) {
                        elm = elm.up();
                        if (elm.getStyle('display') == 'none') {
                            elm.setStyle({display: 'block'});
                        }
                    });
                    currentMargin -= _this.options.get('scrollStep');
                }
                _this.elm.setStyle({marginLeft: currentMargin + 'px'});

                // прячем кнопки, если ими нельзя скроллить
                _this._hideButtons();
            }
        };

        if (!isWheel) {
            this.scrollInterval = setInterval(scrollFunc, 500);
        }

        scrollFunc();
    },

    stopScroll: function()
    {
        this.elm.stopObserving('mouseout', this.stopScrollEvent);
        clearInterval(this.scrollInterval);
        this.scrollInterval  = false;
    }
});