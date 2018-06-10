<?php include "componentes/head.php";
include "componentes/nav.php";?>
    

        <div class="container">
          <div class="row content">
            <div class="col-sm-12">
              <div class="jumbotron">
                <h3>Información sobre MyWorld<br><small>Esta aplicación web trata de ser más familiar y amigable que la propia PhpMyAdmin, que puede llegar a ser algo complicada para los que no están iniciados en el mundo de las bases de datos<br>De momento no posee grandes funcionalidades, pero al ser de codigo abierto, cualquiera puede añadir funcionalidades a esta pequeña aplicación</small></h3>
              </div>
                
              <div class="row">
                <div class="col-sm-6">
                  <div class="well informacion">
                    <h4>Últimas sesiones</h4> 
                      <?php
                        ultimas_sesiones();
                      ?>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="well informacion">
                    <h4>Información del servidor</h4> 
                      <?php
                        informacion_sistema();
                      ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="container-fluid center" style="padding-top:30px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="well centrado informacion banner">
                        <h4>La comunicación sencilla con tu base de datos - Bienvenido <?php echo strtoupper(nombre()) ?></h4> 
                    </div>
                </div>
            </div>
        </div>
<?php include "componentes/footer.php";?>
    </body>
</html>