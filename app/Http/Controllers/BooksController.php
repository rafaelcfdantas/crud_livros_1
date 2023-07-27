<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function get()
    {
        return view('welcome');
    }

    public function read($id = null)
    {
        return view('welcome');
    }

    public function post($id = null)
    {
        return view('welcome');
    }

    public function delete($id)
    {
        return view('welcome');
    }
}
