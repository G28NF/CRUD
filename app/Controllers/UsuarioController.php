<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function index()
    {
        $usuarios = $this->read();
        return view('home', ['usuarios' => $usuarios]);
    }

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function create()
    {
        $usuario = $this->request->getPost();

        if(empty($usuario)) {
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        if($this->usuarioModel->where('email', $usuario['email'])->first()) {
            return redirect()->back()->with('error', 'Email já cadastrado.');
        }

        $this->usuarioModel->insert([
            'nome' => $usuario['nome'],
            'nascimento' => $usuario['nascimento'],
            'email' => $usuario['email'],
            'senha' => $usuario['senha'],
            'cep' => $usuario['cep'],
            'logradouro' => $usuario['logradouro'],
            'numero' => $usuario['numero'],
            'complemento' => $usuario['complemento'] ?? null,
            'bairro' => $usuario['bairro'],
            'cidade' => $usuario['cidade'],
            'uf' => $usuario['uf']
        ]);
        
        return redirect()->to('/home')->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function read()
    {
        $usuarios = $this->usuarioModel->findAll();
        return $usuarios;
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
        $usuario = $this->request->getPost('id');

        if(empty($usuario)) {
            return redirect()->back()->with('error', 'Dados do usuário não fornecidos.');
        }

        $usuario = $this->usuarioModel->where('id', $usuario)->first();

        if(!$usuario){
        return redirect()->back()->with('erro', 'Usuário não encontrado.');
        }

        $this->usuarioModel->delete($usuario['id']);

        return redirect()->back()->with('success', 'Usuário deletado com sucesso.');
    }
}