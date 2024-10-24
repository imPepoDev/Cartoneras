<?php

require_once __DIR__ . '/../../db/conn.php';

class CodeGen extends Database
{
    public function genCode()
    {
        // Gera um código aleatório criptografado (por exemplo, com SHA-256)
        $codigo = hash('sha256', uniqid(mt_rand(), true));
        $data_expira = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Armazena o código na tabela
        $query = "INSERT INTO codes (codigo, data_expira) VALUES (:codigo, :data_expira)";
        $this->executeQuery($query, ['codigo' => $codigo, 'data_expira' => $data_expira]);

        return $codigo;
    }
}
