<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        h1 { font-size: 1.75rem; font-weight: bold; }
        .card-header h2 { margin: 0; font-size: 1.5rem; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="text-center p-4 bg-primary text-white rounded">
            <h1>Sistema de Registro de Vendas</h1>
        </div>
        <!-- Formulário para Adicionar/Editar Venda -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h2 id="formTitulo">Registrar Nova Venda</h2>
            </div>
            <div class="card-body">
                <form id="vendaForm">
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="nome_cliente" class="form-label">Nome do Cliente</label>
                        <input type="text" id="nome_cliente" class="form-control" placeholder="Digite o nome do cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="produto" class="form-label">Produto</label>
                        <input type="text" id="produto" class="form-control" placeholder="Digite o nome do produto" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" id="quantidade" class="form-control" placeholder="Digite a quantidade vendida" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_venda" class="form-label">Data da Venda</label>
                        <input type="date" id="data_venda" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="salvarBtn" onclick="adicionarOuEditar()">Salvar</button>
                </form>
            </div>
        </div>
        <!-- Tabela para Exibir Vendas -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h2>Vendas Registradas</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="vendasTableBody">
                        <!-- Os registros de venda serão adicionados aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Função para formatar a data no formato brasileiro
        function formatarData(data) {
            var partes = data.split('-');
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
        }

        // Função para carregar as vendas
        function carregarVendas() {
            $.ajax({
                url: 'acoes.php',
                method: 'POST',
                data: { action: 'listar' },
                success: function(data) {
                    $('#vendasTableBody').html(data);
                }
            });
        }

        // Função para adicionar ou editar uma venda
        function adicionarOuEditar() {
            var id = $('#id').val();
            var nome_cliente = $('#nome_cliente').val();
            var produto = $('#produto').val();
            var quantidade = $('#quantidade').val();
            var data_venda = $('#data_venda').val();
            var action = id ? 'editar' : 'adicionar';
            $.ajax({
                url: 'acoes.php',
                method: 'POST',
                data: {
                    action: action,
                    id: id,
                    nome_cliente: nome_cliente,
                    produto: produto,
                    quantidade: quantidade,
                    data_venda: data_venda
                },
                success: function(response) {
                    carregarVendas();
                    $('#vendaForm')[0].reset();
                    $('#formTitulo').text('Registrar Nova Venda');
                    $('#salvarBtn').text('Salvar');
                    $('#id').val('');
                }
            });
        }

        // Função para preparar os dados para edição
        function prepararEdicao(id) {
            $.ajax({
                url: 'acoes.php',
                method: 'POST',
                data: { action: 'obter', id: id },
                success: function(data) {
                    var venda = JSON.parse(data);
                    $('#id').val(venda.id);
                    $('#nome_cliente').val(venda.nome_cliente);
                    $('#produto').val(venda.produto);
                    $('#quantidade').val(venda.quantidade);
                    $('#data_venda').val(venda.data_venda);
                    $('#formTitulo').text('Editar Venda');
                    $('#salvarBtn').text('Atualizar');
                }
            });
        }

        // Função para deletar uma venda
        function deletarVenda(id) {
            $.ajax({
                url: 'acoes.php',
                method: 'POST',
                data: { action: 'deletar', id: id },
                success: function(response) {
                    carregarVendas();
                }
            });
        }

        $(document).ready(function() {
            carregarVendas();
        });
    </script>
</body>
</html>
