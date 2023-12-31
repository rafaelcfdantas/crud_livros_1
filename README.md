<a name="readme-top"></a>

[![LinkedIn][linkedin-shield]][linkedin-url]

<br />
<div align="center">
  <h3 align="center">CRUD de livros</h3>

  <p align="center">
    Criação de um CRUD básico de gerenciamento de livros, utilizando serviços de APIs públicas e APIs customizadas.
  </p>
</div>



<details>
  <summary>Sumário</summary>
  <ol>
    <li><a href="#sobre-o-projeto">Sobre o Projeto</a></li>
    <li><a href="#frameworks-e-bibliotecas-utilizadas">Frameworks e Bibliotecas Utilizadas</a></li>
    <li><a href="#pré-requisitos">Pré-requisitos</a></li>
    <li><a href="#instalação">Instalação</a></li>
    <li><a href="#contato">Contato</a></li>
  </ol>
</details>



## Sobre o Projeto

O desafio deste projeto é criar um CRUD de livros utilizando Laravel e as API's do GoogleBooks/ViaCEP/Amazon S3
para complementar informações. Além disso, criar um endpoint de API para consultar um livro específico
com base no código ISBN, ou criar um livro novo caso não exista.

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Frameworks e Bibliotecas Utilizadas

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]
* [![Laradock][Laradock.com]][Laradock-url]

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Pré-requisitos

* Git
* Docker

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Instalação

Utilize o Prompt de Comando para o Windows e o Terminal padrão para o Linux.

1. Clone o repositório no destino de sua preferência e entre na pasta do laradock
   ```sh
   git clone https://github.com/rafaelcfdantas/crud_livros_1.git
   cd crud_livros_1/laradock_crud_livros_1
   ```
2. Caso seu sistema operacional seja Linux, abra o arquivo .env e altere o valor 
da diretiva COMPOSE_PATH_SEPARATOR para ``:``
3. Inicialize o Docker e entre no container do MySQL
   ```sh
   docker-compose up -d apache2 mysql
   docker-compose exec mysql bash
   ```
4. Execute o seguinte comando para criar o banco de dados. Se solicitar senha, utilize ``root``
   ```sh
   mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql
   ```
5. Saia do container do MySQL com o comando ``exit`` e entre no container do workspace
   ```sh
   docker-compose exec workspace bash
   ```
6. Instale as dependências do composer, execute as migrations e saia do container 
com o comando ``exit``
   ```sh
   composer install
   php artisan migrate
   ```
O projeto estará pronto com a URL `http://localhost/`

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Contato

[Rafael Dantas][user-url] - rafael.cfd1999@gmail.com - [LinkedIn][linkedin-url]

[Link do Projeto][project-url]

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



[user-url]: https://github.com/rafaelcfdantas/
[project-url]: https://github.com/rafaelcfdantas/crud_livros_1
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/rafael-dantas-2019/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com
[Laradock.com]: https://img.shields.io/badge/Laradock-7E57C2?style=for-the-badge&logo=docker&logoColor=white
[Laradock-url]: https://laradock.io/
