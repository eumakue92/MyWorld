<?php
include "componentes/funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <link rel="icon" type="image/png" href="favicon3.ico">
        <title>MyWorld</title>
        <style>
            .centrado{
                text-align: center;
            }
            .bg-azul{
                background-color: #99ccff;
                border: solid 1px #2e6da4;
            }
            .bg-azuloscuro{
                background-color: #286090;
                border: solid 1px #2e6da4;
            }
            .blanco{
                color:white;
            }
            .letra{
                font-size: 15px;
            }
            .bg-gris{
                background-color: #f2f2f2;
            }
            form{
                display: none;
            }
            footer{
                font-size: 11px;
            }
            #cabecera{
                border-radius: 20px;
                margin-top: 10px;
            }
            hr{
                border-radius: 20px;
                border: solid 1px #2e6da4;
                background-color: #2e6da4;
            }
            body{
                display: none;
            }
        </style>
        <?php
            if(isset($_SESSION['fallo'])){
                if($_SESSION['fallo']===true){
                    echo "<script>$(document).ready(function(){
                    $(\"form\").show(1000);});</script>";
                }
            }
        ?>
        <script>
            $(document).ready(function(){
                $("body").fadeIn("slow");
                $("#cabecera").click(function(){
                   $("form").show(1000); 
                });
                $("#reset").click(function(){
                    $("#restablecer").removeClass("hide");
                    if(!($("#nouser").hasClass("hide"))) $("#nouser").addClass("hide");
                    if(!($("#noserv").hasClass("hide"))) $("#noserv").addClass("hide");
                });
                $("#cabecera").on({
                    mouseenter: function(){
                        $(this).removeClass("bg-azul");
                        $(this).addClass("bg-azuloscuro");
                        $("#titulo").css({"color":"white"});
                        $("#cabecera").animate({"opacity":"0.95"},"fast");
                    },
                    mouseleave: function(){
                        $(this).removeClass("bg-azuloscuro");
                        $(this).addClass("bg-azul");
                        $("#titulo").css({"color":"black"});
                        $("#cabecera").animate({"opacity":"1"},"fast");
                    }
                });
                $("#contenedor-cabecera").on({
                    mouseenter: function(){
                        
                    },
                    mouseleave: function(){
                        
                    }
                })
            });
        </script>
        <script>
            function enviar(){
                var user, serv;
                user=document.getElementById("user").value;
                serv=document.getElementById("serv").value;
                if(user==''||serv==''){
                    if(user=='')
                        $("#nouser").removeClass("hide");
                    if(serv=='')
                        $("#noserv").removeClass("hide");
                    if(!($("#restablecer").hasClass("hide"))) $("#restablecer").addClass("hide");
                }
                else{
                    document.getElementById("formulario").submit();
                }
            };
        </script>
    </head>
    <body class="bg-gris">
        <div class="container-fluid" id="contenedor-cabecera">
            <div class="jumbotron bg-azul centrado" id="cabecera">
                <h1 id="titulo">Bienvenido a MyWorld</h1>
                <small class="blanco letra">LA COMUNICACIÓN SENCILLA CON TU BASE DE DATOS</small><br><br><small class="blanco">Pulsa para acceder</small>
            </div>
        </div>
        <div class="container">
            <div class="alert alert-success hide" id="restablecer">Todos los campos han sido borrados</div>
            <div class="alert alert-danger hide" id="nouser">Usuario no introducido</div>
            <div class="alert alert-danger hide" id="noserv">Servidor no introducido</div>
            <form action="conntest.php" method="post" id="formulario">
                <br><br>
                <div class="row">
                    <div class="form-group col-sm-6" id="usuario">
                        <label for="user">Usuario:</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Usuario de la base de datos" value="<?php echo nombre(); ?>"/>
                    </div>
                    <div class="form-group col-sm-6" id="password">
                        <label for="pass">Contraseña:</label>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña del usuario de la base de datos" value="<?php echo contrasena(); ?>"/>
                    </div>
                    <div class="form-group col-sm-12" id="servidor">
                        <label for="serv">Servidor:</label>
                        <input type="text" class="form-control" id="serv" name="serv" placeholder="Servidor a conectarse" value="<?php echo servidor(); ?>"/>
                    </div>
                    <div class="checkbox col-sm-12">
                        <label><input type="checkbox" class="checkbox" id="rec" name="rec" checked/>Recuérdame</label>
                    </div>
                </div>
                <div class="btn-group">
                    <input type="button" class="btn btn-primary bg-azul" onclick="enviar()" value="Entrar"/>
                    <input type="reset" class="btn btn-primary bg-azul" id="reset"/>
                </div>
                <br><br>
            </form>
        </div>
        <footer class="container-fluid text-right">
        <hr/>
            <p><strong>Copyright &copy; 2018 | Eugenio Perojil Pérez</strong>
                <br><strong>Contacto: 677 17 71 85</strong>
                <br><strong><a href="mailto:eumakue92@gmail.com">eumakue92@gmail.com</a></strong>
                <br><strong>&reg;MyWord</strong></p>
        </footer>
    </body>
</html>