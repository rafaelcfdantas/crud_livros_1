<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CRUD Livros</title>

        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        {{-- jQuery --}}
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

        {{-- IgorEscobar jQuery Masks --}}
        <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>

        {{-- Commom functions --}}
        <script type="text/javascript" src="{{ asset('assets/js/scripts.js') }}"></script>
    </head>
    <body>
        <header class="my-5 d-flex justify-content-evenly align-items-center">
            <a class="link-dark link-underline link-underline-opacity-0" href="/" role="button">
                <h1>CRUD Livros</h1>
            </a>

            <section>
                <a class="btn btn-secondary" href="/" role="button">Página Inicial</a>
                <a class="btn btn-success" href="/book" role="button">Novo Livro +</a>
            </section>
        </header>

        <main class="container">
            <hr class="mb-5">
            <section id="alert-wrapper">
                @isset($alert)
                    <x-alert :type="$alert['type']" :message="$alert['message']"/>
                @endisset
            </section>

            @yield('content')
        </main>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>
