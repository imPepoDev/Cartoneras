<?php
require_once __DIR__ . '/CodeGen.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload do Composer
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$codeGen = new CodeGen();

// Gerar código aleatório e salvar no banco
$codigo = bin2hex(random_bytes(8)); // Gera um código aleatório
$dataExpira = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Expira em 10 minutos
$query = "INSERT INTO codes (codigo, data_expira) VALUES (:codigo, :data_expira)";
$codeGen->executeQuery($query, ['codigo' => $codigo, 'data_expira' => $dataExpira]);

// Enviar o e-mail com o código gerado
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
    $mail->addAddress('usuario@exemplo.com', 'Usuário');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Código de Verificação';
    $mail->Body    = "Seu código de verificação é: <b>$codigo</b>";

    // Enviar o e-mail
    $mail->send();
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}

echo "E-mail enviado com sucesso. Verifique sua caixa de entrada.";
