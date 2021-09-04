<?php
    session_start();
    require 'DBConnection.php';
    require 'links.php';
    $ids = "";
    $msg = "";

    $usuarios = $dataBase->getReference('Users')->getSnapshot()->getValue();
    foreach($usuarios as $usuario):           
            $ids = $ids ."|". $usuario["id"];                                  
    endforeach;

    $ids = explode("|",$ids);
    $ids = end($ids);
    $ids++;

    if(isset($_POST['uName'])) :
        $novoUser = [
            "id" => $ids,
            "User" => $_POST['uName']            
        ];
        $dataBase->getReference('Users/'.$ids)->set($novoUser);
        $msg = "200";      
    endif;

    if($msg == "200"):
        header("Location:index.php");
    endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - PHP</title>
</head>
<body>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Registre seu nome</h4>
            </div>
            <div class="modal-body">
                <form action="registerUser.php" method="POST">                    
                    <p>
                        <label for="nome">Nome:</label>
                        <input type="text" name="uName" id="uName" class="form-control" autocomplete="off">                        
                    </p>                    
                    <p>            
                        <input type="submit" name="submit" value="Enviar" class="btn btn-primary" style="float: right;">
                    </p>
                </form>
             </div>
        </div>
    </div>
</body>
</html>