<?php

    $mensagemInvalido = "input-valido";
    $inputInvalido = "";    

    $tipos = [
        "UserName",
        "Age",
        "Email",
        "phoneNumber"
    ];
    
    $nomes = [];
    $emails = [];
    $idades = [];
    $telefones = [];

    $userName = ""; //$_POST['nome'];
    $age = ""; //$_POST['idade'];
    $email = ""; //$_POST['email'];
    $phoneNumber = ""; //$_POST['telefone'];

    $isValid = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
        // echo "<h1 class='text-center text-danger'>VAI SE FODER</h1>";
        validaForm();
    }


    function validaForm(){
        $userName = $_POST['nome'];
        $age = $_POST['idade'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['telefone'];

        if(isset($_POST['nome']) === 1 && isset($_POST['idade']) === 1 && isset($_POST['email']) === 1 && isset($_POST['telefone']) === 1){
            echo "<h1 class='text-center text-danger'>VAI SE FODER</h1>";

            $isValid = true;
        
            validaCampo($userName, $tipos[0]);
            validaCampo($age, $tipos[1]);
            validaCampo($email, $tipos[2]);
            validaCampo($phoneNumber, $tipos[3]);
            
            if($isValid === true){
                $userName = "";
                $age = "";
                $email = "";
                $phoneNumber = "";
    
                $nomes.push($userName);
                $idades.push($age);
                $emails.push($email);
                $telefones.push($phoneNumber);
    
                alert("Informações inseridas realizado com sucesso!");
    
                createNewLinha();

                // echo "<script> window.location.reload(true); </script>";
            } 
        }        
    }


    function resetForm(){
        if(isset($_POST['reset'])){
            $_POST['nome'] = "";
            $_POST['idade'] = "";
            $_POST['email'] = "";
            $_POST['telefone'] = "";
        } 
    }

    function validaCampo($value, $tipo){
        switch ($tipo){
            case $tipos[0]:
                  {
                    
                    if($value && $value !== ""){
                        $mensagemInvalido = "input-valido";
                        $inputInvalido = "";
                        // console.log("o nome é valido!");
                    }
                    else
                    {                            
                        $mensagemInvalido = "";
                        $inputInvalido = "input-value-invalido";
                        // console.log("o nome é invalido!");
    
                        $isValid = false;
                    }
                }
              break;
            case $tipos[1]:  		            
                {
                    

                    if($value && $value > 17 && $value < 120){                            
                        $mensagemInvalido = "input-valido";
                        $inputInvalido = "";
                    }
                    else
                    {                            
                        $mensagemInvalido = "";
                        $inputInvalido = "input-value-invalido";
    
                        $isValid = false;
                    }
                }
              break;
            case $tipos[2]:
                  {
                    if(!$value && $value === "" && !$value.includes('@')){
                        $mensagemInvalido = "input-valido";
                        $inputInvalido = "";
                    }
                    else
                    {                            
                        $mensagemInvalido = "";
                        $inputInvalido = "input-value-invalido";
    
                        $isValid = false;
                    }
                }
              break;
            case $tipos[3]:
                {
                    if(!$value && $value === ""){
                        $mensagemInvalido = "input-valido";
                        $inputInvalido = "";
                    }
                    else
                    {                            
                        $mensagemInvalido = "";
                        $inputInvalido = "input-value-invalido";
    
                        $isValid = false;
                    }
                }
              break;
              default:
                echo "<script>console.log('Tipo inválido!')</script>";
        }
    }

    function createNewLinha(){
        // const linha = document.createElement("nome da tag");
        //utilizar o apio aqui em baixo


        //adicionarAcoes(); //cria o "<tr>"/ linha das ações (padrão editar/ex)
    }

    function adicionarAcoes(){
        //
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="index.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Teste - CRUD</title>
</head>
<body>
        <header>
            <h1>Projeto - CRUD</h1>
        </header>
        <section class="formulario">
            <form class="form" method="POST" action="">
                <div class="container-form align-items-center">
                    <div class="input-12 form-inline">
                        <div class="form-floating mb-4 input-9">
                            <input type="text" class="form-control <?php echo $inputInvalido; ?>" id="nome" placeholder="" name="nome">
                            <label for="nome">Nome</label>
                            <div id="nome-invalido" class="form-text <?php echo $mensagemInvalido; ?> text-danger">Nome obrigatório!</div>
                        </div>
                        <div class="form-floating mb-4 input-3">
                            <input type="number" class="form-control <?php echo $inputInvalido; ?>" id="idade" placeholder="" name="idade">
                            <label for="idade">Idade</label>
                            <div id="idade-invalido" class="form-text <?php echo $mensagemInvalido; ?> text-danger">Idade inválida!</div>
                        </div>
                    </div>
                    <div class="form-floating mb-4 input-12">
                        <input type="email" class="form-control <?php echo $inputInvalido; ?>" id="email" placeholder="" name="email">
                        <label for="email">Email</label>
                        <div id="email-invalido" class="form-text <?php echo $mensagemInvalido; ?> text-danger">E-mail inválido!</div>
                    </div>           
                    <div class="form-floating mb-4 input-12">
                        <input type="text" class="form-control" id="telefone" placeholder="" name="telefone">
                        <label for="telefone">Telefone</label>
                        <div id="telefone-invalido" class="form-text <?php echo $mensagemInvalido; ?> text-danger">Telefone inválido!</div>
                    </div>
                </div>
                <div class="flex-row">
                    <button class="btn btn-primary submmit" name="enviar">Enviar</button>
                    <button class="btn btn-danger submmit" name="reset">Resetar</button>
                </div> 
            </form>
        </section>
        <section class="container-grid">        
            <table class="table table-striped-columns table-dark border-table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
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
                </tbody>
            </table>        
        </section>
    </body>
    <script>
    </script>
</html>