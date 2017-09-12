$(document).ready(function() {
    $(document).on('click', '.toggleOrderSummary', function() {
        var btn = $(this);
        var tr = $(this).closest('tr').next('tr');
        if (tr.hasClass('out')) {
            tr.addClass('in');
            tr.slideDown();
            tr.removeClass('out');
            btn.removeClass('fa-plus');
            btn.addClass('fa-minus')
        } else {
            tr.addClass('out');
            tr.slideUp();
            tr.removeClass('in');
            btn.removeClass('fa-minus');
            btn.addClass('fa-plus')
        }
    });
});