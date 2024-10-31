
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

// document.getElementById('enviar').addEventListener('click',()=>{
//     validaForm(ev);
// })

isValid = true;

$isValidNome = true;
$isValidEmail = true;
$isValidIdade = true;
$isValidTelefone = true;


function validaForm(ev){
    ev.preventDefault();
    let userName = document.getElementById('nome');
    let age = document.getElementById('idade');
    let email = document.getElementById('email');
    let phoneNumber = document.getElementById('telefone');
    isValid = true;            
    
    validaCampo(userName.value, $tipos[0]);
    validaCampo(age.value, $tipos[1]);
    validaCampo(email.value, $tipos[2]);
    validaCampo(phoneNumber.value, $tipos[3]);
    
    if(isValid === true){
        userName.value = "";
        age.value = "";
        email.value = "";
        phoneNumber.value = "";

        $nomes.push(userName.value);
        $idades.push(age.value);
        $emails.push(email.value);
        $telefones.push(phoneNumber.value);

        alert("Informações inseridas realizado com sucesso!");

        createNewLinha();
    }            
}

function resetForm(){
    window.location.reload(true);
}

function validaCampo(value, tipo){
    let userName = document.getElementById('nome');
    let age = document.getElementById('idade');
    let email = document.getElementById('email');
    let phoneNumber = document.getElementById('telefone');

    switch (tipo){
        case $tipos[0]:  		            
              {
                let nameInv = document.getElementById('nome-invalido');


                if(value && value !== ""){
                    nameInv.classList.add('input-invalido');
                    userName.classList.remove('input-value-invalido');
                    console.log("o nome é valido!");
                }
                else
                {                            
                    nameInv.classList.remove('input-invalido');
                    userName.classList.add('input-value-invalido');
                    console.log("o nome é invalido!");

                    isValid = false;
                }
            }
          break;
        case $tipos[1]:  		            
            {
                let ageInv = document.getElementById('idade-invalido');

                if(value && value > 17 && value < 120){                            
                    ageInv.classList.add('input-invalido');
                    age.classList.remove('input-value-invalido');
                    console.log("a idade é valido!");
                }
                else
                {                         
                    ageInv.classList.remove('input-invalido');
                    age.classList.add('input-value-invalido');
                    console.log("a idade é invalido!");

                    isValid = false;
                }
            }
          break;
        case $tipos[2]:
              {
                let emailInv = document.getElementById('email-invalido');

                if(value && value!== "" && value.includes('@')){ //&& value.toString().includes('@')
                      //Utilizar regex para validar o email 
                     emailInv.classList.add('input-invalido');
                     email.classList.remove('input-value-invalido');
                     console.log("o email é valido!");
                }
                else
                {                            
                    emailInv.classList.remove('input-invalido');
                    email.classList.add('input-value-invalido');
                    console.log("o email é invalido!");
                    
                    isValid = false;
                }
            }
          break;
        case $tipos[3]:
            {                                                
                let numberInv = document.getElementById('telefone-invalido');

                if(value && value !== "" && value){
                    numberInv.classList.add('input-invalido');
                    phoneNumber.classList.remove('input-value-invalido');
                    console.log("o telefone é valido!");
                }
                else
                {
                    numberInv.classList.remove('input-invalido');
                    phoneNumber.classList.add('input-value-invalido');
                    console.log("o telefone é invalido!");

                    isValid = false;
                }
            }
          break;
          default:
            console.log('Tipo inválido!');
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

function apoio(){
    const button = document.createElement("button");
    button.classList.add("button"); // adicionando a classe ".button" no elemento - os estilos serão aplicados a este elemento.
    button.innerText = 'Hello, world!';
    document.body.appendChild(button);
}