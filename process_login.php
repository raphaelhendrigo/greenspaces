<?php
session_start(); // Inicia uma nova sessão ou resume a existente

// Substitua os valores abaixo com as informações do seu banco de dados
$hostname = "seu_host";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Cria a conexão com o banco de dados
$conn = new mysqli($hostname, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recupera os dados do formulário
$user = $_POST['username'];
$pass = $_POST['password'];

// Proteção básica contra SQL injection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);

// Aqui você deve aplicar hashing na senha antes de verificar no banco de dados
// $pass = hash('sha256', $pass);

// Query de seleção no banco de dados
$sql = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login bem-sucedido
    $_SESSION['username'] = $user;
    // Redireciona para a página do dashboard ou página principal
    header("Location: dashboard.html");
} else {
    // Login falhou
    echo "Usuário ou senha incorretos";
}

$conn->close();
?>
