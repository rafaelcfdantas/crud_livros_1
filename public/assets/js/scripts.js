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

function addAlert(type, text) {
    $('#alert-wrapper').html(
        `<div class="w-50 text-center mx-auto alert alert-${type} alert-dismissible fade show" role="alert">
            ${text}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`
    );
}
