<?php
include "componentes/head.php";
include "componentes/nav.php";
$bd     = $_SESSION['bdselected'];
$i=0;
$_SESSION['contreg'] = $i;
?>

        <div class="container">
            <?php ntblquery()?>
            
            <div class="row">
                <div class="col-sm-12">
                    <h3>Nueva tabla en la base de datos '<?php echo strtoupper($bd); ?>'</h3>
                </div>
            </div>
            <!-- FORMULARIO -->
            <form method="post" action="ntbllanza.php" id="formntbl">
                <input type="hidden" name="contreg" id="contreg" value="1"/>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="nomtbl">Introduce el nombre de la nueva tabla:</label>
                        <input class="form-control" type="text" id="nomtbl" placeholder="Nombre de la tabla" title="Nombre" name="nombretbl" required />
                    </div>
                    <div class="col-sm-4 form group">
                        <label for="cote">Elije el cotejamiento de la tabla:</label>
                        <?php include "componentes/cotejamiento.php" ?>
                    </div>
                    <div class="col-sm-4 form group">
                        <label for="motor">Elije el motor de la tabla:</label>
                        <?php motor() ?>
                    </div>
                </div>
                <hr/>
                <div class="registros">
                    <div class="row" id="0">
                        <div class="col-sm-3 form-group">
                            <label for=<?php echo '"coltbl'.$i.'"'; ?>>Nombre columna:</label>
                            <input class="form-control" type="text" id=<?php echo '"coltbl'.$i.'"'; ?> placeholder="Nombre columna" title="Nombre de la columna" name=<?php echo '"coltbl'.$i.'"'; ?> required />
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for=<?php echo '"tipotbl'.$i.'"'; ?>>Tipo:</label>
                            <?php tipo($i) ?>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label><span title="Clave primaria">PK</span><br><input type="checkbox" name=<?php echo '"pk'.$i.'"'; ?> id=<?php echo '"pk'.$i.'"'; ?> style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>
                            <label><span title="No nulo">NN</span><br><input type="checkbox" name=<?php echo '"nn'.$i.'"'; ?> id=<?php echo '"nn'.$i.'"'; ?> style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>
                            <label><span title="Index único">UQ</span><br><input type="checkbox" name=<?php echo '"uq'.$i.'"'; ?> id=<?php echo '"uq'.$i.'"'; ?> style="margin-top: 15px; margin-left: 5px; margin-right: 4px;" disabled></label>
                            <label><span title="Columna binaria">BI</span><br><input type="checkbox" name=<?php echo '"bi'.$i.'"'; ?> id=<?php echo '"bi'.$i.'"'; ?> style="margin-top: 15px; margin-left: 3px; margin-right: 4px;" ></label>
                            <label><span title="Columna no negativa">UN</span><br><input type="checkbox" name=<?php echo '"un'.$i.'"'; ?> id=<?php echo '"un'.$i.'"'; ?> style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>
                            <label><span title="Completar registro con ceros">ZF</span><br><input type="checkbox" name=<?php echo '"zf'.$i.'"'; ?> id=<?php echo '"zf'.$i.'"'; ?> style="margin-top: 15px; margin-left: 3px; margin-right: 4px;" ></label>
                            <label><span title="Columna autoincremental">AI</span><br><input type="checkbox" name=<?php echo '"ai'.$i.'"'; ?> id=<?php echo '"ai'.$i.'"'; ?> style="margin-top: 15px; margin-left: 2px; margin-right: 4px;" ></label>
                            <label><span title="Columna generada por otras columnas">GC</span><br><input type="checkbox" name=<?php echo '"gc'.$i.'"'; ?> id=<?php echo '"gc'.$i.'"'; ?> style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" disabled></label>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for=<?php echo '"lontbl'.$i.'"'; ?>>Longitud:</label>
                            <input class="form-control" type="text" id=<?php echo '"lontbl'.$i.'"'; ?> placeholder="Longitud del campo" title="Longitud del campo" name=<?php echo '"lontbl'.$i.'"'; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ntbl" title="Crear" onclick="confntbl(1)" id="botonntbl">Crear</button>
                        <button type="button" class="btn btn-success" title="Añadir registro" id="regtbl"><span class="glyphicon glyphicon-plus-sign"></span> Añadir registro</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
                    </div>
                </div>
                
                <div class="modal fade" id="ntbl" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-claro">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">¿Está seguro de que desea crear la siguiente tabla?</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger hide" id="faltandatos">Faltan datos por rellenar</div>
                                <p id="ntbllin" class="infor"></p>
                                <p id="ntblcom" class="infor"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <input type="button" onclick="ntbl()" id="creartbl" class="btn btn-success" value="Crear"/>
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