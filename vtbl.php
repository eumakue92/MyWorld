<?php
include "componentes/head.php";
include "componentes/nav.php";
if(isset($_REQUEST['bd'])) $bd=$_SESSION['bdselected']=$_REQUEST['bd'];
?>

        <div class="container">
            <?php vtblquery(); ?>
            <div class="row">
                <div class="col-sm-6">
                    <h3>Tablas en '<?php echo strtoupper($_SESSION['bdselected']); ?>'</h3>
                </div>
            </div>
            <?php vtbllista2(); ?>
            <div class="col-sm-6">
                <br>
                <a href="ntbl.php"><button type="button" class="btn btn-success">Insertar Tabla</button></a>
                <button type="button" data-toggle="modal" data-target="#vtblborrar" class="btn btn-success">Borrar Tablas</button>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>
        
        <div class="modal fade" id="vtblborrar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='vtbllanza.php' id='vtblborrado'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">¿Desea borrar las siguientes tablas?</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" name="checkeados" class="hide" />
                                <div class="col-sm-12">
                                    <div class="alert alert-danger col-sm-12">
                                        No se han seleccionado tablas para borrar
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
                
                $('div#vtblborrar').find('div.alert').addClass('hide');
                
            }
            else{
                $('#borrarregistro').addClass('disabled');
                
                $('div#vtblborrar').find('div.alert').removeClass('hide');
                
            }

            $('input[name="checkeados"]').val(checkeados);
            //console.log($('input[name="checkeados"]').val());
            var bd  = '<?php echo $bd; ?>';
            //console.log(checkeados);
            $('div#mensajes').empty();
            
            for(var i = 0; i < checkeados.length; i++){
                nombre = $(document).find('a[name="'+checkeados[i]+'"]').text();
                var mensaje = '<p><b><span style="color:purple">DROP TABLE</span> <span style="color:blue">`'+bd+'`</span>.<span style="color:blue">`'+nombre+'`</span>;</b></p>';
                $('div#mensajes').append(mensaje);
            }
        });
        $('#borrarregistro').click(function(){
            if($(this).hasClass('disabled')){}
            else $('form#vtblborrado').submit();
        });
    </script>
<?php
include "componentes/footer.php";
?>
    </body>
</html>