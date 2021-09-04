<?php
    session_start();
    require 'DBConnection.php';
    require 'links.php';

    $User = $dataBase->getReference('Users/'.$_SESSION['userId'])->getSnapshot()->getValue();


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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <p>Olá, <?=$User['User']?></p>
                <input type="text" id="fromUser" value="<?=$User['id']?>" hidden>

                <p>Enviar menssagem para:</p>
                <ul>
                    <?php
                        $usuarios = $dataBase->getReference('Users')->getSnapshot()->getValue();

                        foreach($usuarios as $usuario):
                            echo '<li><a href="?toUser='.$usuario["id"].'">'.$usuario["User"].'</a></li>';
                        endforeach;
                    ?>
                </ul>
                <a href="index.php"><---Voltar</a>
            </div>
            <div class="col-md-4">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>
                                <?php 
                                    if(isset($_GET["toUser"])):                                        
                                        $usuarioNome = $dataBase->getReference('Users/'.$_GET["toUser"])->getSnapshot()->getValue();                                                       
                                        echo '<input type="text" value='.$_GET["toUser"].' id="toUser" hidden>';
                                        echo $usuarioNome['User'];
                                    else:
                                        $usuarioNome = $dataBase->getReference('Users/0')->getSnapshot()->getValue();                                                       
                                        $_SESSION["toUser"] = $usuarioNome["id"];
                                        echo '<input type="text" value='.$_SESSION["toUser"].' id="toUser" hidden>';
                                        echo $usuarioNome['User'];                                        
                                    endif;
                                ?>
                            </h4>
                        </div>
                        <div class="modal-body" id="msgBody" style="height: 400px;overflow-y:scroll;overflow-x:hidden">                            
                            <?php
                                if(isset($_GET['toUser'])):
                                   $chats = mysqli_query($connect,"SELECT * FROM messages WHERE (FromUser = '".$_SESSION["userId"]."' AND toUser = '".$_GET["toUser"]."') OR (FromUser = '".$_GET['toUser']."' AND ToUser= '".$_SESSION['userId']."')");                                   
                                else:
                                    $chats = mysqli_query($connect,"SELECT * FROM messages WHERE (FromUser = '".$_SESSION["userId"]."' AND toUser = '".$_SESSION["toUser"]."') OR (FromUser = '".$_SESSION['toUser']."' AND ToUser= '".$_SESSION['userId']."')");                                    
                                endif;                                                    

                                while($chat = mysqli_fetch_assoc($chats)):
                                    if($chat["FromUser"] == $_SESSION["userId"]):
                                        echo "<div style='text-align:right'>
                                                <p style='background-color:lightblue;word-wrap:break-word;display:inline-block;padding:5px;border-radius:10px;max-width:70%'>
                                                    ".$chat['Message']."
                                                </p>    
                                            </div>";
                                    else:
                                        echo "<div style='text-align:left'>
                                                <p style='background-color:yellow;word-wrap:break-word;display:inline-block;padding:5px;border-radius:10px;max-width:70%'>
                                                    ".$chat['Message']."
                                                </p>    
                                            </div>";         
                                    endif;
                                endwhile;
                            ?>
                        </div>
                        <div class="modal-footer">
                            <textarea id="message" class="form-control" style="height:70px;"></textarea>
                            <button id="send" class="btn btn-primary" style="height:70%;">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(() => {
        $("#send").on("click",() => {
            $.ajax({
                url:"insertMessage.php",
                type: "post",
                data:{
                    fromUser:$("#fromUser").val(),
                    toUser:$("#toUser").val(),
                    message:$("#message").val()
                },
                dataType:"text",
                success:function(data){                    
                    $("#message").val("");
                }
            });
        });
        setInterval(() => {
            $.ajax({
                url:"realTimeChat.php",
                type:"post",
                data:{
                    fromUser:$("#fromUser").val(),
                    toUser:$("#toUser").val()                    
                },
                dataType:"text",
                success:function(data){
                    $("#msgBody").html(data);                    
                }
            });
        },600);
    });
</script>
</html>