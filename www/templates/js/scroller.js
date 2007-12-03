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
            var elmWidth = _this.elm.getWidth();
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
                var currentMargin = parseInt(_this.elm.getStyle('margin-left'));
                elm = $$('img.previewScroll').first().up();
                elm.setStyle({display: (currentMargin >= 0) ? 'none' : 'block'});

                var elmWidth = _this.elm.getWidth();
                if (Prototype.Browser.Opera || Prototype.Browser.IE) {
                    elmWidth += currentMargin;
                }
                elm = $$('img.previewScroll').last().up();
                elm.setStyle({display: (elmWidth < _this.options.get('minWidth')) ? 'none' : 'block'});
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