<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateTableUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'nascimento' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
                'unique' => true,
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => false,
            ],
            'logradouro' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'complemento' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'cidade' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'uf' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios', true);
    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true);
    }
}