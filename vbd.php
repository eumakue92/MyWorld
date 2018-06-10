<?php
include "componentes/head.php";
include "componentes/nav.php";?>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Seleccionar base de datos</h3>
                </div>
            </div>
            
                    <?php vbdlista(); ?>
            
            <div class="col-sm-6">
                <br>
                <a href="nbd.php"><button type="button" class="btn btn-success">Insertar BD</button></a>
                <a href="bbd.php"><button type="button" class="btn btn-success">Borrar BD</button></a>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>
        
        
<?php
include "componentes/footer.php";
?>
    </body>
</html>