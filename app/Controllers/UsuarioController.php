<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function index()
    {
        return view('home');
    }
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function create()
    {
        $usuario = $this->request->getPost('');

        if(empty($usuario)) {
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        if($this->usuarioModel->where('email', $usuario['email'])->first()) {
            return redirect()->back()->with('error', 'Email já cadastrado.');
        }

        $this->usuarioModel->insert($usuario);

        return redirect()->back()->with('success', 'Usuário criado com sucesso.');
    }

    public function read()
    {
        $usuarios = $this->usuarioModel->findAll();
        return view('usuarios/list', ['usuarios' => $usuarios]);
    }

    public function update()
    {
        $usuario = $this->request->getPost('dados');

        if(empty($usuario)) {
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        if(!$this->usuarioModel->where('email', $usuario['email'])->first()) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        if($usuario['senha'] !== $this->usuarioModel->where('email', $usuario['email'])->first()['senha']) {
            return redirect()->back()->with('error', 'Senha incorreta.');
        }

        $this->ususarioModel->where('email', $usuario['email'])->update($usuario);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso.');
    }

    public function delete()
    {
        $usuario = $this->request->getPost('dados');

        if(empty($usuario)) {
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        if($usuario['senha'] !== $this->usuarioModel->where('email', $usuario['email'])->first()['senha']) {
            return redirect()->back()->with('error', 'Senha incorreta.');
        }

        $this->usuarioModel->where('email', $usuario['email'])->delete();

        return redirect()->back()->with('success', 'Usuário deletado com sucesso.');
    }
}