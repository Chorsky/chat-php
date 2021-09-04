<?php
    session_start();
    require 'DBConnection.php';
    require 'links.php';

    if(isset($_GET['userId'])):
        $_SESSION['userId'] = $_GET['userId'];
        header("location:chatbox.php");
    endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat-PHP</title>
</head>
<body>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Por favor selecione sua conta</h4>
            </div>
            <div class="modal-body">
                <ol>
                    <?php
                        $usuarios = $dataBase->getReference('Users')->getSnapshot()->getValue();

                        foreach($usuarios as $usuario):
                            echo '<li>  
                                        <a href="index.php?userId='.$usuario["id"].'">'.$usuario["User"].'</a>
                                </li> 
                                ' ;
                        endforeach;
                    ?>
                </ol>
                <a href="registerUser.php" style="float:right">Clique aqui para se registrar</a>
             </div>
        </div>
    </div>
</body>
</html>