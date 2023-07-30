$(function () {
});

function openModal(msg, title = 'Atenção') {
    $('body').append(
        `<div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default-title" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-default-title">${title}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-default-msg">${msg}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>`
    );

    $('#modal-default').modal('show');

    $('#modal-default').on('hidden.bs.modal', function(){
        $('#modal-default').remove();
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
