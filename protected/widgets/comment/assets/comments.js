
$(document).ready(function() {

    var incCommentCounters = function(commentType, materialId) {
        $counters = $('.comments[data-comment-type=' + commentType + '][data-material-id=' + materialId + ']');
        $counters.each(function(i, item) {
            var $counter = $(item);
            $counter.text(+$counter.text() + 1);
        });
    };

    var decCommentCounters = function(commentType, materialId) {
        $counters = $('.comments[data-comment-type=' + commentType + '][data-material-id=' + materialId + ']');
        $counters.each(function(i, item) {
            var $counter = $(item);
            $counter.text(+$counter.text() -1);
        });
    };

    $('.comments').on('click', '.remove-comment', function(e) {
        var $this = $(this);
        var $comment = $this.closest('.item');
        var commentId = $comment.data('id');
        var commentType = $comment.data('comment-type');
        var materialId = $comment.data('material-id');
        $.post('',
            {
            CommentWidget: {
                action: 'delete',
                id: commentId,
                type: commentType
            }}, function(data) {
            $comment.remove();
            decCommentCounters(commentType, materialId);
        });
        return false;
    });

});