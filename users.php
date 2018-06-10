<?php
include "componentes/head.php";
include "componentes/nav.php";
?>

        <div class="container">
            <?php usersquery(); ?>
            <?php userslista(); ?>
            <?php if(permisos()){ ?>
            <div class="col-sm-6">
                <br>
                <button type="button" data-toggle="modal" data-target="#usersreg" class="btn btn-success">Agregar usuario</button>
                <button type="button" data-toggle="modal" data-target="#usersborrar" class="btn btn-success">Borrar usuario</button>
            </div>
            <?php } ?>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>

        <?php if(permisos()){ ?>
        <div class="modal fade" id="usersreg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='userslanza.php' id='usersregistro'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nuevo Usuario</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hide" id="faltandatos">Faltan campos por rellenar</div>
                            <?php
                                informacion($reg = 1);
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" id="crearusers" class="btn btn-success" value="Insertar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="usersborrar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='userslanza.php' id='usersborrado'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">¿Desea borrar los siguientes usuarios?</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" name="checkeados" class="hide" />
                                <div class="col-sm-12">
                                    <div class="alert alert-danger col-sm-12">
                                        No se han seleccionado usuarios para borrar
                                    </div>
                                </div>
                                <div class="col-sm-12" id='mensajes'>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="borrarregistro" class="btn btn-success disabled">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>

            $('input[type="checkbox"]').change(function(){
                var borrados = $('input[type="checkbox"]:checked');
                //console.log(borrados);
                //COMRPOBAR UNO A UNO SI ESTAN CHECKEADOS
                if(typeof checkeados == 'undefined')
                    var checkeados = [];
                for(var i = 0; i < borrados.length; i++){
                        checkeados.push($(document).find(borrados[i]).attr('name'));
                    //console.log($(document).find(borrados[i]).attr('name'));
                }
                if(checkeados.length != 0){
                    $('#borrarregistro').removeClass('disabled');
                    
                    $('div#usersborrar').find('div.alert').addClass('hide');
                    
                }
                else{
                    $('#borrarregistro').addClass('disabled');
                    
                    $('div#usersborrar').find('div.alert').removeClass('hide');
                    
                }

                $('input[name="checkeados"]').val(checkeados);
                //console.log($('input[name="checkeados"]').val());
                var bd  = '<?php echo "mysql"; $bd = "mysql"; ?>';
                var tbl = '<?php echo "user"; $tbl = "mysql"; ?>';
                //console.log(checkeados);
                $('div#mensajes').empty();
                

                var cabecera = '<?php 
                $sql        = "SELECT * FROM `mysql`.`user`";
                $consulta   = mysqli_query(conexion(),$sql);
                $cabecera = dame_cabecera($consulta);
                for($i = 0; $i < count($cabecera); $i++){ 
                    echo $cabecera[$i];
                    if($i != count($cabecera)-1) echo ",";
                }  ?>';
                cabecera = cabecera.split(',');
                //console.log(cabecera);

                var datos = $('div#usersdiv3').find('tbody').find('tr');
                var dat= [];
                //console.log(datos);
                for(var i = 0; i < datos.length; i++)
                    for(var j = 0; j < checkeados.length; j++)
                        if(i == checkeados[j])
                            dat.push(datos[i]);
                //console.log(dat);
                var datos = [];
                for(var i = 0; i < dat.length; i++)
                    datos.push($(document).find(dat[i]).find('td'));
                

                for(var i = 0; i < checkeados.length; i++){
                    mensaje = '<p><b><span style="color:purple">DROP USER </span>';
                    mensaje += '<span style="color:blue">"'+$(document).find(datos[i][2]).html()+'"</span><span style="color:red">@</span><span style="color:blue">"'+$(document).find(datos[i][1]).html()+'"</span>;';
                    mensaje += '</b></p>';
                     $('div#mensajes').append(mensaje);
                }

                <?php $_SESSION['reg'] = 0; $reg = 0; ?>

            });

            $('#borrarregistro').click(function(){
                if($(this).hasClass('disabled')){}
                else $('form#usersborrado').submit();
            });
        </script>
        <?php } ?>
<?php
include "componentes/footer.php";
?>
    </body>
</html>