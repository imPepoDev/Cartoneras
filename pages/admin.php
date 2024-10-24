<?php
require_once __DIR__ . '/../php/email/codeGen.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Sao_Paulo');

$codeGen = new CodeGen();

// Gerar e enviar o código ao abrir a página
$codigo = bin2hex(random_bytes(8)); // Código aleatório
$dataExpira = date('Y-m-d H:i:s', strtotime('+10 minutes'));
$criadoEm = date('Y-m-d H:i:s');

// Salvar o código na tabela
$query = "INSERT INTO codes (codigo, data_expira, criado_em) VALUES (:codigo, :data_expira, :criado_em)";
$codeGen->executeQuery($query, [
    'codigo' => $codigo,
    'data_expira' => $dataExpira,
    'criado_em' => $criadoEm
]);

// Enviar o e-mail com o código
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $_ENV['ENV_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['ENV_EMAIL'];
    $mail->Password   = $_ENV['ENV_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // Configurar remetente e destinatário
    $mail->setFrom($_ENV['ENV_EMAIL'], 'Sistema');
    $mail->addAddress('pedrinhouhggez@gmail.com', 'Usuário');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Código de Verificação';
    $mail->Body    = "Seu código de verificação é: <b>$codigo</b>";

    // Enviar o e-mail
    $mail->send();
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoInserido = $_POST['codigo'];

    echo "Código inserido: $codigoInserido <br>";
    echo "Hora atual: " . date('Y-m-d H:i:s') . "<br>";

    // Validar o código
    $query = "SELECT * FROM codes 
            WHERE codigo = :codigo 
            AND usado = 0 
              AND data_expira >= criado_em"; // Use NOW() para pegar a hora atual do banco de dados
    $result = $codeGen->executeQuery($query, ['codigo' => $codigoInserido]);

    if ($result) {
        // Marcar o código como usado e definir o tempo de liberação
        $liberadoPor = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $updateQuery = "UPDATE codes 
                        SET usado = 1, liberadoPor = :liberadoPor 
                        WHERE codigo = :codigo";
        $codeGen->executeQuery($updateQuery, [
            'liberadoPor' => $liberadoPor,
            'codigo' => $codigoInserido,
        ]);

        // Redirecionar para a área liberada
        header("Location: acessoLiberado.php?token=$codigoInserido");
        exit();
    } else {
        $erro = "Código inválido ou expirado.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Código</title>
</head>

<body>
    <h1>Digite o Código de Verificação</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <button type="submit">Validar</button>
    </form>
</body>

</html>