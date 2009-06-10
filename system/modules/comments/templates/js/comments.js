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
                nowHolder.append(formElem);

                $(aElemTrigger).closest('div.entry-comments').find('a.selected').removeClass('selected');

                $(aElemTrigger).addClass('selected');
                formElem.show();
                formElem.attr('action', aElemTrigger.href);
                formElem.find('textarea').focus();
            }
        }
    }
})(jQuery);