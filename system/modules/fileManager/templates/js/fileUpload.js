/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($){

    if(typeof MZZ.fileUpload == 'undefined') {
        MZZ.fileUpload = DUI.Class.create({
            
            init: function()
            {
                this._forms = {};
            },

            create: function(name, cb)
            {
                if (name) {
                    var frm = $('#' + name);
                    if (frm.length) {
                        frm.attr('enctype', 'multipart/form-data');
                        frm.attr('target', name + '_fileUpload');
                        frm.unbind();
                        frm.bind('submit', function (e){fileUpload.sendForm(name, e);});

                        this._forms[name] = {form: frm, callback: cb};
                    } else {
                        console.log('fileUpload::create() form "' + name + '" not found');
                    }
                } else {
                    console.log('fileUpload::create() form name not set');
                }
            },

            sendForm: function(name, e)
            {
                if (this._forms[name]) {
                    var res = this.notify(name, 'submit');
                    if (typeof res == 'boolean' && res == false) {
                        e.preventDefault();
                        return;
                    }

                    var iframe = $('#' + name + '_fileUpload');

                    if (iframe.length) {
                        iframe.remove();
                    }

                    iframe = $('<iframe name="' + name + '_fileUpload" id="' + name + '_fileUpload" style="border: 0; width: 0; height: 0; display: none" src="about:blank"></iframe>');

                    this._forms[name].form.before(iframe);

                    iframe.bind('load', function(){fileUpload.loadFrame(name, this);});
                }
            },

            loadFrame: function(name, frame) {
                if (this._forms[name]) {
                    var frame = $(frame);
                    var success = frame.contents().find('#status').html();
                    var messages = [];
                    frame.contents().find('#messages').find('span').each(function(){messages.push($(this).html());});
                    this.notify(name, 'complete', success, messages);
                    frame.unbind();
                }
            },

            notify: function(name, event, success, messages)
            {
                if (this._forms[name]) {
                    var cb = this._forms[name].callback;
                    var form = this._forms[name].form;
                    if ($.isFunction(cb)) {
                        return cb.call(form, event, success, messages);
                    } else {
                        if (event == 'submit' && cb.submit) {
                           return cb.submit.call(form);
                        } else if (event == 'complete' && $.isFunction(cb.complete)) {
                           cb.complete.call(form, success, messages);
                            if (success == 1 && $.isFunction(cb.success)) {
                               cb.success.call(form, messages);
                            } else if ($.isFunction(cb.error)) {
                               cb.error.call(form, messages);
                            }
                        }
                    }
                }
                
                return false;
            }

        });

        MZZ.fileUpload = new MZZ.fileUpload;
    }
    
})(jQuery);

var fileUpload = MZZ.fileUpload;