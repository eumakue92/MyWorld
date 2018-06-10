    <body class="bg-azul">
        <nav class="navbar navbar-inverse visible">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navegacion">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <a href="#" class="navbar-brand active" id="cambcolor"><span class="glyphicon glyphicon-adjust"></span> MyWorld</a>
                    </div>
                </div>
            <div class="collapse navbar-collapse col-sm-12" id="navegacion">
                <ul class="nav navbar-nav">
                    <li><a href="mainmenu.php">Inicio</a></li>
                    <li><a href="users.php">Usuarios</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Bases de Datos <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="nbd.php">Nueva base de datos</a></li>
                            <li><a href="bbd.php">Borrar base de datos</a></li>
                            <li><a href="vbd.php">Seleccionar base de datos</a></li>
                        </ul>
                    </li>
                    <li><a href="vbd.php">Tablas y vistas</a>
                    </li>
                    <li><a href="funcyproc.php">Funciones y procedimientos</a></li>
                    <li><a href="impyexp.php">Importar y Exportar</a></li>
                    <li><a href="shell.php">Consola</a></li>
                    <li><a href="info.php"><span class="glyphicon glyphicon-user"></span> Información</a></li>
                    <li><button type="button" class=" btn btn-danger navbar-btn navbar-right" data-toggle="modal" data-target="#salir"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</button></li>
                </ul>
            </div>
          </div>
        </nav>
        
        <div class="modal fade" id="salir" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content bg-claro">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Está a punto de abandonar MyWorld</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que quiere cerrar sesión?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a href="bye.php"><button type="button" class="btn btn-danger">Salir</button></a>
                    </div>
                </div>
            </div>
        </div>