<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class UsuarioControll extends BaseController
{
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function creat()
    {
        $usuario = $this->request->getPost('dados');

        if(empty($usuario)){
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        if($this->usuarioModel->where('email', $usuario['email'])->first()){
            return redirect()->back()->with('error', 'Email já cadastrado.');
        }

        $this->usuarioModel->insert($usuario);
    }
}