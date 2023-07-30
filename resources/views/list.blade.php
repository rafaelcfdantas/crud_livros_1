@extends('_base')

@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col" class="text-center w-25">Capa</th>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Data de publicação</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($books as $book)
            <tr>
                <td>{{ $book['id'] }}</td>
                <td><img src="{{ $book['capa'] }}" class="img-thumbnail mx-auto d-block" alt="{{ $book['capa'] }}"></td>
                <td>{{ $book['titulo'] }}</td>
                <td>{{ $book['autor'] }}</td>
                <td>{{ $book['data_publicacao']->format('d/m/Y') }}</td>
                <td>
                    <section>
                        <a class="btn btn-primary" href="/book/{{ $book['id'] }}" role="button">Editar</a>
                        <a class="btn btn-danger" href="/book/{{ $book['id'] }}" role="button">Excluir</a>
                    </section>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Nenhum livro encontrado no banco de dados</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script type="text/javascript" src="{{ asset('assets/js/delete_book.js') }}"></script>
@endsection
