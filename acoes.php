<?php
include 'conexao.php';

$action = $_POST['action'] ?? '';

if ($action == 'listar') {
    $query = "SELECT * FROM vendas";
    $result = $conn->query($query);
    $output = '';
    while ($row = $result->fetch_assoc()) {
        $data_formatada = date('d/m/Y', strtotime($row['data_venda']));
        $output .= "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nome_cliente']}</td>
            <td>{$row['produto']}</td>
            <td>{$row['quantidade']}</td>
            <td>{$data_formatada}</td>
            <td>
                <button class='btn btn-warning btn-sm' onclick='prepararEdicao({$row['id']})'>Editar</button>
                <button class='btn btn-danger btn-sm' onclick='deletarVenda({$row['id']})'>Deletar</button>
            </td>
        </tr>";
    }
    echo $output;
} elseif ($action == 'obter') {
    $id = $_POST['id'];
    $query = "SELECT * FROM vendas WHERE id = $id";
    $result = $conn->query($query);
    $venda = $result->fetch_assoc();
    $venda['data_venda'] = date('Y-m-d', strtotime($venda['data_venda']));
    echo json_encode($venda);
} elseif ($action == 'adicionar') {
    $nome_cliente = $_POST['nome_cliente'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $data_venda = $_POST['data_venda'];
    $query = "INSERT INTO vendas (nome_cliente, produto, quantidade, data_venda) VALUES ('$nome_cliente', '$produto', '$quantidade', '$data_venda')";
    $conn->query($query);
} elseif ($action == 'editar') {
    $id = $_POST['id'];
    $nome_cliente = $_POST['nome_cliente'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $data_venda = $_POST['data_venda'];
    $query = "UPDATE vendas SET nome_cliente = '$nome_cliente', produto = '$produto', quantidade = '$quantidade', data_venda = '$data_venda' WHERE id = $id";
    $conn->query($query);
} elseif ($action == 'deletar') {
    $id = $_POST['id'];
    $query = "DELETE FROM vendas WHERE id = $id";
    $conn->query($query);
}
?>
