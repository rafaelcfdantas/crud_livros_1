@extends('_base')

@section('content')
<form action="/book{{ $book['id'] ? ('/' . $book['id']) : '' }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
    @csrf
    <div id="formHelp" class="form-text mb-3">* Campos obrigatórios</div>

    <div class="mb-3">
        <label for="titulo" class="form-label">Título*</label>
        <input type="text" name="titulo" value="{{ $book['titulo'] }}" class="form-control" id="titulo" required>
    </div>

    <div class="mb-3">
        <label for="autor" class="form-label">Autor*</label>
        <input type="text" name="autor" value="{{ $book['autor'] }}" class="form-control letters" id="autor" required>
    </div>

    <div class="mb-3">
        <label for="capa" class="form-label">Capa*</label>
        @if($book['capa'] !== '')
            <div class="w-50 mb-3">
                <img src="{{ $book['capa'] }}" class="img-thumbnail" alt="{{ $book['capa'] }}">
            </div>
        @endif
        <input type="file" name="capa" class="form-control" id="capa" accept="image/*" @unless($book['capa']) required @endunless>
    </div>

    <div class="mb-3">
        <label for="cep" class="form-label">CEP do autor*</label>
        <input type="text" name="cep" value="{{ $book['cep'] }}" class="form-control cep" id="cep" required>
    </div>

    @isset($book['descricao'])
    <div class="form-floating mb-3">
        <textarea class="form-control" id="descricao" style="height: 160px;" placeholder="Descrição" readonly>{{ $book['descricao'] }}</textarea>
        <label for="descricao" class="form-label">Descrição</label>
    </div>
    @endisset

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script type="text/javascript" src="{{ asset('assets/js/form_validation.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/form_masks.js') }}"></script>
@endsection
