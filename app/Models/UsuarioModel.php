<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table          = 'usuarios';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields  = true;
    protected $allowedFields  = ['nome', 'nascimento', 'email', 'senha', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf'];
    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'id'    => 'required|integer',
        'nome'          => 'required|min_length[3]|max_length[250]',
        'nascimento'    => 'required|valid_date',
        'email' => 'required|valid_email|min_length[6]|max_length[250]|is_unique[usuarios.email,id,{id}]',
        'senha'         => 'required|min_length[1]|max_length[250]',
        'cep'           => 'required|string|min_length[9]|max_length[10]',
        'logradouro'    => 'required|string|max_length[250]',
        'numero'        => 'required|string|max_length[10]',
        'complemento'   => 'permit_empty|string|max_length[250]',
        'bairro'        => 'required|string|max_length[250]',
        'cidade'        => 'required|string|max_length[250]',
        'uf'            => 'required|string|exact_length[2]',
    ];
}