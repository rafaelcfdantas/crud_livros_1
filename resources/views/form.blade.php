@extends('_base')

@section('content')
<form action="/book{{ $book['id'] ? ('/' . $book['id']) : '' }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" value="{{ $book['titulo'] }}" class="form-control" id="titulo" required>
    </div>

    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" value="{{ $book['autor'] }}" class="form-control" id="autor" required>
    </div>

    <div class="mb-3">
        <label for="cep" class="form-label">CEP do autor</label>
        <input type="text" name="cep" value="{{ $book['cep'] }}" class="form-control cep" id="cep" required>
    </div>

    @isset($book['descricao'])
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea readonly class="form-control" id="descricao" rows="6">{{ $book['descricao'] }}</textarea>
    </div>
    @endisset

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script type="text/javascript" src="{{ asset('assets/js/form_validation.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/form_masks.js') }}"></script>
@endsection
