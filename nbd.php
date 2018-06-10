<?php
include "componentes/head.php";
include "componentes/nav.php";?>

        <div class="container">
            <?php nbdquery()?>
            
            <div class="row">
                <div class="col-sm-12">
                    <h3>Nueva base de datos</h3>
                </div>
            </div>
            <form method="post" action="nbdlanza.php" id="formnbd">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="nombd">Introduce el nombre de la nueva BD:</label>
                        <input class="form-control" type="text" id="nombd" placeholder="Nombre de la BD" title="Nombre" name="nombrebd"/>
                    </div>
                    <div class="col-sm-6 form group">
                        <label for="cote">Elije el cotejamiento de la BD:</label>
                        <?php include "componentes/cotejamiento.php" ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nbd" title="Crear" onclick="confnbd()" id="botonnbd">Crear</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
                    </div>
                </div>
                
                <div class="modal fade" id="nbd" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content bg-claro">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">¿Está seguro de que desea crear la base de datos?</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger hide" id="nonombrebd">Falta el nombre de la base de datos</div>
                                <p id="nbdlin1" class="infor"></p>
                                <p id="nbdcom1" class="infor"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <input type="button" onclick="nbd()" class="btn btn-success" value="Crear"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

<?php
include "componentes/footer.php";
?>
    </body>
</html>