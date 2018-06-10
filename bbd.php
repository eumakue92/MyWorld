<?php
include "componentes/head.php";
include "componentes/nav.php";?>

        <div class="container">
            <?php bbdquery()?>
            
            <div class="row">
                <div class="col-sm-12">
                    <h3>Borrar bases de datos</h3>
                </div>
            </div>
            <form method="post" action="bbdlanza.php" id="formbbd">
                <input type="text" class="hide" id="bbdcont" name="bbdcont"/>
                
                        <?php bbdlista(); ?>
                
                
                <div class="col-sm-6">
                    <br>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bbd" title="Eliminar" onclick="bbdconf()" id="bbdboton">Eliminar</button>
                </div>
                <div class="col-sm-6">
                    <br>
                    <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
                </div>
                
                
                <div class="modal fade" id="bbd" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content bg-claro">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">¿Está seguro de que desea borrar la base de datos?</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger hide" id="bbdnobd">No ha seleccionado ninguna base de datos para borrar</div>
                                <p id="bbdlin1" class="infor"></p>
                                <p id="bbdcom1" class="infor"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <input type="button" onclick="bbd()" class="btn btn-success" value="Eliminar"/>
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