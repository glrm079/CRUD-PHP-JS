<?php

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
        sendDatabase();
    }

    function sendDatabase(){
        $userName = $_POST['nome'];
        $age = $_POST['idade'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['telefone'];

        if(isset($userName) && isset($age) && isset($email) && isset($phoneNumber)){
            // echo "<h1 class='text-center text-danger'>$userName - $age - $email - $phoneNumber</h1>";

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
            // echo "Conectado com sucesso";

            $sql = "INSERT INTO Usuario (nome, idade, email, telefone) VALUES (?, ?, ?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("siss", $userName, $age, $email, $phoneNumber);
                
            if (!$stmt->execute()) {
                echo "Informações não inseridas... <br>Erro: " . $stmt->error;
            }
        
            $stmt->close();

            // Fecha a conexão
            $conexao->close();
            
            $userName = "";
            $age = "";
            $email = "";
            $phoneNumber = "";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- <script src="index.js" defer></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Teste - CRUD</title>
</head>
<body>
    <header>
        <h1>Projeto - CRUD</h1>
    </header>
    <section class="formulario">
        <form class="form" method="POST" action="" onsubmit="return validaForm()">
            <div class="container-form align-items-center">
                <div class="input-12 form-inline">
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
                <button class="btn btn-primary submit" name="enviar">Enviar</button>
                <button class="btn btn-danger submit" name="reset" type="reset" onclick="resetForm()">Resetar</button>
            </div>
        </form>
        </section>
        <section class="container-grid">
            <table class="table table-striped-columns table-dark border-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
                            loadGrid();
                        }
                        function loadGrid(){
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
                            } else {
                                echo "Nenhum resultado encontrado.";
                            }

                            createTableBody($usuarios);
                            //não sei onde colocar isso ainda...
                            // array_push($nomes, $userName);
                            // array_push($idades, $age);
                            // array_push($emails, $email);
                            // array_push($telefones, $phoneNumber);
                        
                            //lógica para conectar no banco novamente??...
                            //lógica para fazer o get no banco
                            //$dados = banco.get(); //(em json)
                        
                        
                        
                            // Fecha a conexão
                            $conexao->close();
                        }

                        function createTableBody($usuarios){
                            foreach ($usuarios as $usuario) {
                                echo"<tr>
                                        <td>$usuario->id</td>
                                        <th scope='row'>$usuario->nome</th>
                                        <td>$usuario->idade</td>
                                        <td>$usuario->email</td>
                                        <td>$usuario->telefone</td>
                                        <td>
                                            <div class='d-flex justify-content-evenly text-center'>
                                                <form>
                                                    <button class='btn btn-sm btn-warning' name='editar' onclick='editaLinha()'>Editar</button>
                                                    <button class='btn btn-sm btn-danger' name='excluir' onclick='excluiLinha()'>Excluir</button>
                                                </form>
                                            </div> 
                                        </td>
                                    </tr>";
                            }
                        }
                    ?>
                    <!-- <tr>
                        <td>#2</td>
                        <th scope="row">Matheus Morais</th>
                        <td>15</td>
                        <td>matheus@gmail.com</td>
                        <td>(11)9999-9999</td>
                        <td>
                            <div class="d-flex justify-content-evenly text-center">
                                <button class="btn btn-sm btn-warning" name="editar" onclick="editaLinha()">Editar</button>
                                <button class="btn btn-sm btn-danger" name="excluir" onclick="excluiLinha()">Excluir</button>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td>#3</td>
                        <th scope="row">Matheus Morais</th>
                        <td>15</td>
                        <td>matheus@gmail.com</td>
                        <td>(11)9999-9999</td>
                        <td>
                            <div class="d-flex justify-content-evenly text-center">
                                <button class="btn btn-sm btn-warning" name="editar" onclick="editaLinha()">Editar</button>
                                <button class="btn btn-sm btn-danger" name="excluir" onclick="excluiLinha()">Excluir</button>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td>#4</td>
                        <th scope="row">Matheus Morais</th>
                        <td>15</td>
                        <td>matheus@gmail.com</td>
                        <td>(11)9999-9999</td>
                        <td>
                            <div class="d-flex justify-content-evenly text-center">
                                <button class="btn btn-sm btn-warning" name="editar" onclick="editaLinha()">Editar</button>
                                <button class="btn btn-sm btn-danger" name="excluir" onclick="excluiLinha()">Excluir</button>
                            </div> 
                        </td>
                    </tr> -->
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
            if (!idade || idade <= 18 || idade > 120) {
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
            if (telefone.length < 10 && telefone.lenght > 13) {
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

        function editaLinha(){
            const id = document.getElementById("user_id").value;
            
            console.log("Editando tal linha...");
        }

        function excluiLinha(){
            console.log("Excluindo tal linha...");
        }

        function resetForm(){
            window.location.reload(true);
        }

        function apoio(){
            const button = document.createElement("button");
            button.classList.add("button"); // adicionando a classe ".button" no elemento - os estilos serão aplicados a este elemento.
            button.innerText = 'Hello, world!';
            document.body.appendChild(button);
        }
    </script>
</html>