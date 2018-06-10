<?php
include "componentes/head.php";
include "componentes/nav.php";
?>

        <div class="container">
            <?php funcyprocquery(); ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <h3>Funciones</h3>
                        <?php
                            funciones();
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h3>Procedimientos</h3>
                        <?php
                            procedimientos();
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>

        <div class="modal fade" id="funcyprocborrar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-claro">
                    <form method='POST' action='funcyproclanza.php' id='funcyprocborrado'>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">¿Desea eliminar la siguiente función o procedimiento?</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" name="funcyproceli" class="hide" />
                                <input type="text" name="tipo" class="hide" />
                                <div class="col-sm-12" id='mensajes'>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="borrarfunc" class="btn btn-success">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $('button#eliminar').click(function(){
                var funcyproc   = $(this).parent().parent().siblings('a').find('b').html();
                var tipo        = $(this).val();
                //console.log(funcyproc);
                //console.log(tipo);
                $('input[name="funcyproceli"]').val(funcyproc);
                $('input[name="tipo"]').val(tipo);
                $('#mensajes').empty();
                $('#mensajes').append('<b><span style="color:purple;">DROP '+tipo+'</span><span style="color:blue;"> '+funcyproc+'</span>;</b>');
            });

            $('#borrarfunc').click(function(){
                $('form#funcyprocborrado').submit();
            });
        </script>
<?php
include "componentes/footer.php";
?>
    </body>
</html>