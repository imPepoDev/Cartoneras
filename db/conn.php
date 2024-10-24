<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'kpluginsKKKKKKKK';
    private $username = 'usuario';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;

    // Construtor: Inicia a conexão ao banco
    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    // Função para executar qualquer query com segurança
    public function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            // Retorna o resultado, se for uma query de SELECT
            if (stripos($query, 'SELECT') === 0) {
                return $stmt->fetchAll();
            }
            return true;  // Para INSERT, UPDATE, DELETE
        } catch (PDOException $e) {
            echo "Erro na query: " . $e->getMessage();
            return false;
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
