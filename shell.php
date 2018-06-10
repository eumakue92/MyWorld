<?php
include "componentes/head.php";
include "componentes/nav.php";
?>

        <div class="container">
            <div class="alert alert-warning hide" id="advertencia">La consola se encuentra vacía</div>
            <div class="row">
                <div class="col-sm-12 form-group" id="contenedor">
                    <label for="consola"><h3>Consola</h3></label>
                    <textarea class="form-control" id="consola" title="Separe cada consulta con ';' y respete las mayúsculas para las etiquetas SQL" rows="15" style="background-color: #ECF0F1"></textarea>
                </div>
                <div class="col-sm-6" id="iframe">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-warning" id="select">SELECT</button>
                    <button type="button" class="btn btn-warning" id="update">UPDATE</button>
                    <button type="button" class="btn btn-warning" id="insert">INSERT</button>
                    <button type="button" class="btn btn-warning" id="delete">DELETE</button>
                    <button type="button" class="btn btn-warning" id="createt">CREATE TABLE</button>
                    <button type="button" class="btn btn-warning" id="createb">CREATE DB</button>
                    <button type="button" class="btn btn-warning" id="dropt">DROP TABLE</button>
                    <button type="button" class="btn btn-warning" id="dropb">DROP DB</button>
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <button type="button" class="btn btn-success" id="lanzar">Lanzar Comando</button>
                <button type="button" class="btn btn-success" id="limpiar">Limpiar Shell</button>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>

        <script>
            $('#limpiar').click(function(){
                $('#consola').val('');
            });

            $('#lanzar').click(function(){
                if($('#consola').val() == ''){
                    $('#advertencia').removeClass('hide');
                }
                else{
                    var comando = $('#consola').val();
                    //sessionStorage.setItem('shell',comando);
                    $.post('consola.php',{
                        comando
                    });
                    $('#contenedor').removeClass('col-sm-12').addClass('col-sm-6');
                    $('#iframe').empty();
                    $('#iframe').append('<h3>Resultado</h3><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="consola.php" id="iframe" style="border-radius: 4px;" allowfullscreen></iframe></div>');
                }
            });

            $('#consola').change(function(){
                if($('#consola').val() != '') {
                    if($('#advertencia').hasClass('hide')){}
                    else $('#advertencia').addClass('hide');
                }
            });

            $('#select').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'SELECT * FROM `#bd#`.`#tabla#`;');
            });
            $('#update').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'UPDATE `#bd#`.`#tabla#` SET #columna# = #valor#, #columna# = #valor#, ... WHERE #condición#;');
            });
            $('#insert').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'INSERT INTO `#bd#`.`#tabla#` (#columna1#, #columna2#, #columna3#,...) VALUES (#valor1#, #valor2#, #valor3#,...);\n');
            });
            $('#delete').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'DELETE FROM `#bd#`.`#tabla#` WHERE #condición#;');
            });
            $('#createt').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'CREATE TABLE `#bd#`.`#tabla#` (\n#variable# #tipo#(#longitud#) #extras#,\n#variable# #tipo#(#longitud#) #extras#\n) ENGINE = #motor# COLLATE #cotejamiento#;');
            });
            $('#createb').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'CREATE DATABASE `#bd#` COLLATE #cotejamiento#;');
            });
            $('#dropb').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'DROP DATABASE `#bd#`;');
            });
            $('#dropt').click(function(){
                var valor = $('#consola').val();
                $('#consola').val(valor+'DROP TABLE `#bd#`.`#tabla#`;');
            });
        </script>
<?php
include "componentes/footer.php";
?>
    </body>
</html>