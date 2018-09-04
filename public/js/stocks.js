$('[name=radio-change]').click(function() {
    if ($('input[name=lang]:eq(1)').prop('checked')) {
        $('input[name=lang]:eq(0)').prop('checked', true);
    } else {
        $('input[name=lang]:eq(1)').prop('checked', true);
    }
});