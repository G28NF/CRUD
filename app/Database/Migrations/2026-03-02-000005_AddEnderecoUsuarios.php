<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddEnderecoUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios',[
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => true
            ],
            'logradouro' => [
                
            ],
            'numero' => [

            ],
            'complemento' => [

            ],
            'bairro' => [

            ],
            'cidade' => [

            ],
            'uf' => [

            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', ['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf']);
    }
}