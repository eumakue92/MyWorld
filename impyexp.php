<?php
include "componentes/head.php";
include "componentes/nav.php";
?>

        <div class="container">
            <?php impyexpquery(); ?>
            <div class="row">
                <h3>Importar y exportar</h3>
                <div class="col-sm-6">
                    <form action="impyexplanza.php" enctype="multipart/form-data" method="POST" id="subida">
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                        <div class="form-group">
                            <br>
                            <label class="btn btn-success btn-file">
                                <b><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp; Importar</b>
                                <input type="file" name="archivo" style="display: none;" id="archivo" accept=".txt" />
                            </label>
                            <button type="button" class="btn btn-success pull-right disabled" id="subir"><span class="glyphicon glyphicon-floppy-open"></span> Subir</button>
                            <input type="text" class="form-control" style="margin-top: 3px;" name="nombrearchivo" readonly />
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <?php
                        impyexplista();
                    ?>
                </div>
                <?php
                    if(isset($_SESSION['fichero']) && $_SESSION['fichero'] != ''){
                        echo '<div class="col-sm-12">';
                        echo '<a href="descarga.php?fichero='.$_SESSION['fichero'].'"><button type="button" class="btn btn-success pull-right">Descargar fichero</button></a>';
                        echo '</div>';
                        $_SESSION['fichero'] = '';
                    }
                ?>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="mainmenu.php" style="float:right;"><button type="button" class="btn btn-warning">Inicio</button></a>
            </div>
        </div>

        <script>
            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });
            
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {
                    $('[name="nombrearchivo"]').val(label);
                    $('[name="nombrearchivo"]').attr('title',label);
                    //console.log(numFiles);
                    //console.log(label);
                });
            });

            $('[type="file"]').change(function(){
                if($(this).val() != '')
                    $('#subir').removeClass('disabled');
                else
                    $('#subir').addClass('disabled');
            });

            $('#subir').click(function(){
                if($(this).hasClass('disabled')){}
                else
                    $('form#subida').submit();
            });
        </script>
<?php
include "componentes/footer.php";
?>
    </body>
</html>