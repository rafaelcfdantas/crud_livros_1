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

Este projeto é a resolução de um teste de conhecimento para desenvolvedor PHP júnior. O desafio é
criar um CRUD de livros utilizando Laravel e algumas API's para complementar informações.

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Frameworks e Bibliotecas Utilizadas

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![Laradock][Laradock.com]][Laradock-url]

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Pré-requisitos

* Git
* Docker

<p align="right">(<a href="#readme-top">voltar para o topo</a>)</p>



## Instalação

1. Clone o repositório
   ```sh
   git clone https://github.com/rafaelcfdantas/crud_livros_1.git
   ```
2. Entre na pasta do laradock
   ```sh
   cd crud_livros_1/laradock_crud_livros_1
   ```
3. Caso seu sistema operacional seja Linux, abra o arquivo .env e altere o valor da diretiva COMPOSE_PATH_SEPARATOR para " : " (sem as aspas)
4. Insira o comando abaixo para inicializar o Docker
   ```sh
   docker-compose up -d apache2 mysql
   ```

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
[Laradock.com]: https://img.shields.io/badge/Laradock-7E57C2?style=for-the-badge&logo=docker&logoColor=white
[Laradock-url]: https://laradock.io/
