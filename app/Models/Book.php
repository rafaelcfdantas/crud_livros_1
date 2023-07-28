<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn', 'titulo' , 'autor', 'data_publicacao', 'capa',
        'descricao', 'cep', 'rua', 'bairro', 'cidade', 'estado'
    ];

    public $timestamps = false;
}
