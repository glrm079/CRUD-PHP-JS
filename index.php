<?php
    $hasNoData = false;

    class Usuario {
        // Propriedades da classe
        public $id;
        public $nome;
        public $idade;
        public $email;
        public $telefone;

        // Método construtor
        public function __construct($id, $nome, $idade, $email, $telefone) {
            $this->id = $id; 
            $this->nome = $nome;
            $this->idade = $idade;
            $this->email = $email;
            $this->telefone = $telefone;
        }

        // Método para exibir informações
        public function exibirInformacoes() {
            echo "<h1 class='text-center text-danger'>";
            echo "#" . $this->id . " Nome: " . $this->nome . ", Idade: " . $this->idade . ", Email: " . $this->email . ", Telefone: " . $this->telefone;
            echo "</h1>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
        insertDatabase();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&  isset($_POST['editar'])) {
        $id = $_POST['id'];

        if(!$id || $id <= 0){
            die("Erro na requisição.");
        }

        editaLinha();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])) {
        excluiLinha();
    }

    function insertDatabase(){
        $userName = $_POST['nome'];
        $age = $_POST['idade'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['telefone'];

        if(isset($userName) && isset($age) && isset($email) && isset($phoneNumber)){
            $servidor = "localhost:3307"; //colocar o localhost aqui
            $usuario = "root"; //colcoar este usuario no banco
            $senha = "root"; //colcoar essa senha no banco
            $banco = "CRUD"; //adicionar o banco com esta informação

            // Cria a conexão
            $conexao = new mysqli($servidor, $usuario, $senha, $banco);

            // Verifica a conexão
            if ($conexao->connect_error) {
                die("Conexão falhou: " . $conexao->connect_error);
            }

            $sql = "INSERT INTO Usuario (nome, idade, email, telefone) VALUES (?, ?, ?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("siss", $userName, $age, $email, $phoneNumber);
                
            $stmt->execute();
            $stmt->close();

            // Fecha a conexão
            $conexao->close();
            
            $userName = "";
            $age = "";
            $email = "";
            $phoneNumber = "";
        }
    }

    function editaLinha(){
        $user_id = $_POST['id'];
        $userName = $_POST['nome'];
        $age = $_POST['idade'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['telefone'];

        if(isset($userName) && isset($age) && isset($email) && isset($phoneNumber))
        {
            $servidor = "localhost:3307"; //colocar o localhost aqui
            $usuario = "root"; //colcoar este usuario no banco
            $senha = "root"; //colcoar essa senha no banco
            $banco = "CRUD"; //adicionar o banco com esta informação

            // Cria a conexão
            $conexao = new mysqli($servidor, $usuario, $senha, $banco);

            // Verifica a conexão
            if ($conexao->connect_error) {
                die("Conexão falhou: " . $conexao->connect_error);
            }

            $sql = "UPDATE Usuario SET 
                nome = IF(LENGTH(?) = 0, nome, ?),
                idade = IF(LENGTH(?) = 0, idade, ?),
                email = IF(LENGTH(?) = 0, email, ?),
                telefone = IF(LENGTH(?) = 0, telefone, ?)
                WHERE id = ?";

            $stmt = $conexao->prepare($sql);

            if (!$stmt) {
                die("Erro na preparação da declaração: " . $conexao->error);
            }

            // Vincular os parâmetros
            $stmt->bind_param("ssiissssi", $userName, $userName, $age, $age, $email, $email, $phoneNumber, $phoneNumber, $user_id);

            $stmt->execute();

            $stmt->close();
            $conexao->close();
        }
    }

    function excluiLinha(){
        $id = $_POST['user_id'];

        if(isset($id))
        {
            $servidor = "localhost:3307"; //colocar o localhost aqui
            $usuario = "root"; //colcoar este usuario no banco
            $senha = "root"; //colcoar essa senha no banco
            $banco = "CRUD"; //adicionar o banco com esta informação

            $conexao = new mysqli($servidor, $usuario, $senha, $banco);
            if ($conexao->connect_error) {
                die(json_encode(["success" => false, "message" => "Conexão falhou: " . $conexao->connect_error]));
            }
        
            $sql = "DELETE FROM usuario WHERE id = ?";
        
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            $conexao->close();
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Cadastro</title>
    </head>
    <body>
    <header>
        <h1>CRUD</h1>
    </header>
    <section class="formulario">
        <form class="form" method="POST" onsubmit="return validaForm()">
            <div class="container-form align-items-center">
                <div class="input-12 form-inline">
                    <div class="input-valido">
                        <input type="text" id="id" placeholder="" name="id">
                    </div>
                    <div class="form-floating mb-4 input-9">
                        <input type="text" class="form-control" id="nome" placeholder="" name="nome">
                        <label for="nome">Nome</label>
                        <div id="nome-invalido" class="form-text input-valido text-danger">Nome obrigatório!</div>
                    </div>
                    <div class="form-floating mb-4 input-3">
                        <input type="number" class="form-control" id="idade" placeholder="" name="idade">
                        <label for="idade">Idade</label>
                        <div id="idade-invalido" class="form-text input-valido text-danger">Idade inválida!</div>
                    </div>
                </div>
                <div class="form-floating mb-4 input-12">
                    <input type="email" class="form-control" id="email" placeholder="" name="email">
                    <label for="email">Email</label>
                    <div id="email-invalido" class="form-text input-valido text-danger">E-mail inválido!</div>
                </div>
                <div class="form-floating mb-4 input-12">
                    <input type="tel" class="form-control" id="telefone" placeholder="" name="telefone">
                    <label for="telefone">Telefone</label>
                    <div id="telefone-invalido" class="form-text input-valido text-danger">Telefone inválido!</div>
                </div>
            </div>
            <div class="flex-row">
                <button style="margin-right: 4px; display: inline;" class="btn btn-primary submit" id="enviar" name="enviar">Enviar</button>
                <button style="display: none;" class="btn btn-success submit" id="editar" name="editar">Atualizar</button>
                <button class="btn btn-danger submit" name="reset" type="reset" onclick="resetForm()">Resetar</button>
            </div>
        </form>
    </section>
        <section class="container-grid">
            <table class="table table-striped-columns table-dark border-table">
                <thead>
                    <tr>
                        <!-- <th scope="col">#</th> -->
                        <th scope="col">Nome</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        loadGrid();

                        function loadGrid(){
                            global $hasNoData;
                            // Criando um array para armazenar os objetos
                            $usuarios = [];

                            $servidor = "localhost:3307"; //colocar o localhost aqui
                            $usuario = "root"; //colcoar este usuario no banco
                            $senha = "root"; //colcoar essa senha no banco
                            $banco = "CRUD"; //adicionar o banco com esta informação
                        
                            // Cria a conexão
                            $conexao = new mysqli($servidor, $usuario, $senha, $banco);
                        
                            // Verifica a conexão
                            if ($conexao->connect_error) {
                                die("Conexão falhou: " . $conexao->connect_error);
                            }

                            $sql = "select * from usuario";

                            $resultado = $conexao->query($sql);
                        
                            if ($resultado->num_rows > 0) {
                                // Loop através dos resultados e exibe o nome
                                while ($row = $resultado->fetch_assoc()) {
                                    $usuarios[] = new Usuario($row['Id'], $row['Nome'], $row['Idade'], $row['Email'], $row['Telefone']);
                                }

                                createTableBody($usuarios);
                            }
                            else
                            {
                                echo "<tr><td colspan='5'><h3 class='text-center' style='color: white; align-content: center; padding: 1% 0;'>Nenhum usuário cadastrado</h3></td></tr>";
                            }
                        
                            // Fecha a conexão
                            $conexao->close();
                        }

                        function createTableBody($usuarios){
                            foreach ($usuarios as $usuario) {
                                // "<tr>$usuario->id</tr>"
                                echo"<tr>
                                        <th scope='row'>$usuario->nome</th>
                                        <td>$usuario->idade</td>
                                        <th scope='row'>$usuario->email</th>
                                        <td>$usuario->telefone</td>
                                        <td>
                                            <div class='d-flex justify-content-evenly text-center'>
                                                <form onsubmit='return false'>
                                                    <input class='input-valido' id='id$usuario->id' value='$usuario->id'>
                                                    <input class='input-valido' id='nome$usuario->id' value='$usuario->nome'>
                                                    <input class='input-valido' id='idade$usuario->id' value='$usuario->idade'>
                                                    <input type='text' class='input-valido' id='email$usuario->id' value='$usuario->email'>
                                                    <input type='text' class='input-valido' id='telefone$usuario->id' value='$usuario->telefone'>
                                                    <button class='btn btn-sm btn-warning' name='editar' onclick='editaLinha($usuario->id)'>Editar</button>
                                                </form>
                                                <form method='POST'>
                                                    <input class='input-valido' name='user_id' id='user_id' value='$usuario->id'>
                                                    <button class='btn btn-sm btn-danger' name='excluir'>Excluir</button>
                                                </form>
                                            </div> 
                                        </td>
                                    </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </section>
    </body>
    <script>
        function validaForm() {
            let isValid = true;
            
            let userName = document.getElementById('nome');
            let age = document.getElementById('idade');
            let email = document.getElementById('email');
            let phoneNumber = document.getElementById('telefone');

            let nameInv = document.getElementById('nome-invalido');
            let ageInv = document.getElementById('idade-invalido');
            let emailInv = document.getElementById('email-invalido');
            let numberInv = document.getElementById('telefone-invalido');

            // Validar Nome
            if (!userName.value.trim()) {
                document.getElementById("nome-invalido").style.display = "block";
                userName.classList.add('input-value-invalido');
                isValid = false;
            }
            else
            {
                nameInv.style.display = "none";
                userName.classList.remove('input-value-invalido');
            }
        
            // Validar Idade
            const idade = parseInt(age.value);
            if (!idade || idade < 18 || idade > 120) {
                document.getElementById("idade-invalido").style.display = "block";
                age.classList.add('input-value-invalido');
                isValid = false;
            }
            else
            {
                ageInv.style.display = "none";
                age.classList.remove('input-value-invalido');
            }
        
            // Validar Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                document.getElementById("email-invalido").style.display = "block";
                email.classList.add('input-value-invalido');
                isValid = false;
            }
            else{
                emailInv.style.display = "none";
                email.classList.remove('input-value-invalido');
            }
        
            // Validar Telefone (apenas um exemplo básico)
            const telefone = phoneNumber.value.trim();
            const telefoneRegex = /^\(\d{2}\) \d{5}-\d{4}$/;
            if (!telefoneRegex.test(telefone)) {
                document.getElementById("telefone-invalido").style.display = "block";
                phoneNumber.classList.add('input-value-invalido');
                isValid = false;
            }
            else{
                numberInv.style.display = "none";
                phoneNumber.classList.remove('input-value-invalido');
            }
            
            return isValid;
        }

        function editaLinha(id){
            const user_id = document.getElementById(`id${id}`).value;
            const nome = document.getElementById(`nome${id}`).value;
            const idade = document.getElementById(`idade${id}`).value;
            const email = document.getElementById(`email${id}`).value;
            const telefone = document.getElementById(`telefone${id}`).value;

            document.getElementById('id').value = id;            
            document.getElementById('nome').value = nome;
            document.getElementById('idade').value = idade;
            document.getElementById('email').value = email;
            document.getElementById('telefone').value = telefone;

            document.getElementById('enviar').style.display = "none";
            document.getElementById('editar').style.display = "inline";
        }

        function resetForm(){
            window.location.reload(true);
        }
        
    </script>
</html>