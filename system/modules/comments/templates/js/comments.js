var comments;
(function($) {
    comments = {
        moveForm: function(commentId, folderId, aElemTrigger) {
            if ($(aElemTrigger).hasClass('selected')) {
                return false;
            }

            var formElem = $('#commentForm_' + folderId);
            var nowHolder = $('#answerForm_' + folderId + '_' + commentId);

            if (formElem && nowHolder) {
                var errors = formElem.find('dl.errors');
                if (errors) {
                    errors.remove();
                }
                nowHolder.append(formElem);

                $(aElemTrigger).closest('div.entry-comments').find('a.selected').removeClass('selected');

                $(aElemTrigger).addClass('selected');
                formElem.show();
                formElem.attr('action', aElemTrigger.href);
                formElem.find('textarea').focus();
            }
        },
        postForm: function(formElem) {
            formElem = $(formElem);
            var formParent = formElem.parent();
            var reg = /^answerForm_(\d+)_(\d+)$/;
            var matches = formParent.attr('id').match(reg);
            if (matches) {
                var formUrl = formElem.attr('action');
                var formData = formElem.serialize();

                formElem.find('input, textarea, select').attr('disabled', 'disabled');
                var folderId = matches[1];
                var replyTo = matches[2];

                var baseHolder = (replyTo == 0) ? $('#comments_' + folderId) : formElem.closest('.hcomment');
                $.ajax({
                    url: formUrl,
                    type: "POST",
                    data: formData,
                    success: function(msg) {
                        if (baseHolder) {
                            formParent.empty();
                            if (msg.match(/<li class="hcomment new">/)) {
                                baseHolder.closest('div.entry-comments').find('a.selected').removeClass('selected');
                                if (replyTo != 0) {
                                    baseHolder.append($('<ul/>').append(msg));
                                } else {
                                    baseHolder.append(msg);
                                }

                                var newComment = baseHolder.find('li.new');
                                if (newComment) {
                                    newComment.removeClass('new');
                                }
                            } else {
                                formParent.html(msg);
                            }
                        }
                    }
                });
            }
        }
    }
})(jQuery);