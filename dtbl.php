<?php
include "componentes/head.php";
include "componentes/nav.php";
$tbl    = $_SESSION['tbl'] = $_REQUEST['tbl'];
$bd     = $_SESSION['bdselected'];
?>

        <div class="container">
            <?php dtblquery(); ?>
            <div class="row">
                <div class="col-sm-12">
                    <h3>Información general de la tabla '<?php echo strtoupper($bd)."'.'".strtoupper($tbl); ?>'</h3>
                </div>
            <?php
                dtbllista($bd,$tbl);
            ?>
            </div>
            <div class="row">
                <div class="col-sm-10 col-xs-3">
                    <br>
                    <button type="button" data-toggle="modal" data-target="#dtblreg" class="btn btn-success">Nuevo Registro</button>
                    <button type="button" data-toggle="modal" data-target="#dtblborrar" class="btn btn-success">Borrar Registros</button>
                    <button type="button" data-toggle="modal" data-target="#dtblmodificar" class="btn btn-success">Modificar Registros</button>
                </div>
                <div class="col-sm-2">
                    <br>
                    <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="dtblreg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='dtbllanza.php' id='dtblregistro'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nuevo registro</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hide" id="faltandatos">Faltan campos por rellenar</div>
                            <?php
                                nuevo_registro($bd,$tbl);
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" id="creartbl" class="btn btn-success" value="Insertar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="dtblborrar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='dtbllanza.php' id='dtblborrado'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">¿Desea borrar los siguientes registros?</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" name="checkeados" class="hide" />
                                <div class="col-sm-12">
                                    <div class="alert alert-danger col-sm-12">
                                        No se han seleccionado registros para borrar
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

        <div class="modal fade" id="dtblmodificar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='dtbllanza.php' id='dtblmodificar'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Indique las modificaciones</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" name="modificados" value="1" class="hide">
                                <div class="col-sm-12" id='modificaciones'>
                                    <?php dtbllista3($bd,$tbl,$reg=1) ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="modificarregistro" class="btn btn-success disabled">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
include "componentes/footer.php";
?>
<script>
    $('#dtblreg').find('input[type="text"]').change(function(){
        var registros = $('#dtblreg').find('input[type="text"]');
        //console.log(registros);
        for(var i = 0; i < registros.length; i++){
            //console.log(registros[i]);
            //console.log($('#dtblreg').find(registros[i]).attr('id'));
            //console.log($('#dtblreg').find(registros[i]).val());
            var id      = $('#dtblreg').find(registros[i]).attr('id');
            var valor   = $('#dtblreg').find(registros[i]).val();
            if(valor == '') valor = 'NULL';
            $('#dtblreg').find('span#'+id).empty();
            $('#dtblreg').find('span#'+id).append(valor);
        }
    });

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
            
            $('div#dtblborrar').find('div.alert').addClass('hide');
            
        }
        else{
            $('#borrarregistro').addClass('disabled');
            
            $('div#dtblborrar').find('div.alert').removeClass('hide');
            
        }

        $('input[name="checkeados"]').val(checkeados);
        //console.log($('input[name="checkeados"]').val());
        var bd  = '<?php echo $bd; ?>';
        var tbl = '<?php echo $tbl; ?>';
        //console.log(checkeados);
        $('div#mensajes').empty();
        

        var cabecera = '<?php 
        $sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
        $consulta   = mysqli_query(conexion(),$sql);
        $cabecera = dame_cabecera($consulta);
        for($i = 0; $i < count($cabecera); $i++){ 
            echo $cabecera[$i];
            if($i != count($cabecera)-1) echo ",";
        }  ?>';
        cabecera = cabecera.split(',');
        //console.log(cabecera);

        var datos = $('div#dtbldiv3').find('tbody').find('tr');
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
            mensaje = '<p><b><span style="color:purple">DELETE FROM</span> <span style="color:blue">`'+bd+'`</span>.<span style="color:blue">`'+tbl+'`</span> <span style="color:purple">WHERE</span> ';
            for(var j = 0; j < cabecera.length; j++){
                mensaje += cabecera[j];
                mensaje += ' = <span style="color:red">"';
                mensaje += $(document).find(datos[i][j+1]).html();
                if(j != cabecera.length-1)
                    mensaje += '"</span> <span style="color:purple">AND</span> ';
                else
                    mensaje += '"</span>;';
            }
            mensaje += '</b></p>';
             $('div#mensajes').append(mensaje);
        }

        <?php $_SESSION['reg'] = 0; $reg = 0; ?>

    });

    $('#borrarregistro').click(function(){
        if($(this).hasClass('disabled')){}
        else $('form#dtblborrado').submit();
    });

    $('#modificaciones').find('input[type="text"]').change(function(){
        var recogedor = $('#dtblmodificar').find('input[type="text"]');
        var j = -1;
        for(var i = 0; i < recogedor.length; i++){
            if($(recogedor[i]).attr('id') != $(recogedor[i]).val()){
                //console.log(recogedor[i]);
                j++;
            }
        }
        //console.log(j);
        if(j != 0)
            $('#modificarregistro').removeClass('disabled');
        else 
            $('#modificarregistro').addClass('disabled');
    });

    $('#modificarregistro').click(function(){
        if($(this).hasClass('disabled')){}
        else $('form#dtblmodificar').submit();
    });    
</script>
    </body>
</html>