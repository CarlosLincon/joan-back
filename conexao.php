<?php
// conexao.php
$servername = "localhost";
$username = "root";
$password = "";
$database = "vendas";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
