function deleteBookEvent() {
    $('.btn.btn-danger').unbind('click').click(function (e) {
        e.preventDefault();
        const deleteButton = $(this);

        deleteButton.html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span class="ms-2" role="status">Carregando...</span>');

        $.ajax({
            url: deleteButton.attr('href'),
            type: "DELETE",
            dataType: "json",
            data: {'_token': $("meta[name='csrf-token']").attr("content")},
            error: function (data) {
                openDialog('Erro interno no servidor! (1001)');
            },
            success: function (data) {
                addAlert('success', 'O livro foi excluído com sucesso!');

                deleteButton.closest('tr').remove();

                if (!$('table tbody tr').length) {
                    $('table tbody').html('<tr><td colSpan="5">Nenhum livro encontrado no banco de dados</td></tr>');
                }
            },
            complete: function (data) {
                deleteButton.html('Excluir');
            }
        });
    })
}

$(function () {
    deleteBookEvent();
});
