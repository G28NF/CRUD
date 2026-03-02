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
    protected $allowedFields  = ['nome', 'nascimento', 'email', 'senha'];
    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'nome'          => 'required|string|min_length[10]|max_length[250]',
        'nascimento'    => 'required|date',
        'email'         => 'required|string|min_length[9]|max_length[250]|is_unique[usuarios.email]',
        'senha'         => 'required|numeric|min_length[6]|max_length[250]',
    ];
}