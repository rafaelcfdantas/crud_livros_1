$(function () {
    // prevent conflict of jQuery UI tooltip with Bootstrap tooltip
    var bootstrapButton = $.fn.button.noConflict();
    $.fn.bootstrapBtn = bootstrapButton;
});

function openDialog(msg, title = 'Atenção') {
    if (typeof $('#dialog').dialog('instance') != 'undefined') {
        $('#dialog').dialog('destroy');
    }

    $('#dialog').html(
        '<p> ' + msg + '</p>'
    );

    $('#dialog').dialog({
        modal: true,
        title: title,
        draggable: false,
        resizable: false,
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });
}
