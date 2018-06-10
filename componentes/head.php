<?php
include "componentes/funciones.php";
seguridad();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.2.2/css/autoFill.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.4.1/css/colReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/keytable/2.3.2/css/keyTable.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.4.4/css/scroller.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/autofill/2.2.2/js/dataTables.autoFill.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/keytable/2.3.2/js/dataTables.keyTable.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/scroller/1.4.4/js/dataTables.scroller.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
        
        
        <link rel="icon" type="image/png" href="favicon3.ico">
        <title>MyWorld</title>
        <style>
            .bg-azul{
                background-color: #99ccff;
            }
            .jumbotron{
                background-color: #a6a6a6;
                color: #f1f1f1;
                border: solid 1px #f1f1f1;
            }
            .bg-claro{
                background-color:#99ccff;
            }
            .bg-oscuro{
                background-color: #e6e6e6;
            }
            hr{
                border-radius: 20px;
                border: solid 1px #333;
                background-color: #333;
            }
            .informacion{
                border: solid 1px #a6a6a6;
            }
            .centrado{
                text-align: center;
            }
            .banner{
                background-color: #333;
                color: #9d9d9d;
            }
            @media (max-width: 1320px) {
                .navbar-header {
                    float: none;
                }
                .navbar-left,.navbar-right {
                    float: none !important;
                }
                .navbar-toggle {
                    display: block;
                }
                .navbar-collapse {
                    border-top: 1px solid transparent;
                    box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
                }
                .navbar-fixed-top {
                    top: 0;
                    border-width: 0 0 1px;
                }
                .navbar-collapse.collapse {
                    display: none!important;
                }
                .navbar-nav {
                    float: none!important;
                    margin-top: 7.5px;
                }
                .navbar-nav>li {
                    float: none;
                }
                .navbar-nav>li>a {
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                .collapse.in{
                    display:block !important;
                }
            }
            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
        </style>
        <script>
            $(document).ready(function(){
                $("#cambcolor").click(function(){
                    if(!($("body").hasClass("bg-oscuro"))){
                        $("body").addClass("bg-oscuro");
                        $("body").removeClass("bg-claro");
                    }
                    else{
                        $("body").addClass("bg-claro");
                        $("body").removeClass("bg-oscuro");
                    }
                });
                //$("a.pag").click(function(){
                //    var pagina;
                //    pagina = $(this).attr("id");
                //    document.find("div.pag");
                //});
                $('table').DataTable({
                    "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "scrollX": true
                });

                var contreg = 0;
                $('#regtbl').click(function(){
                    <?php $_SESSION['contreg']++; ?>
                    contreg++;
                    $('#contreg').attr("value",contreg+1);
                    $('#botonntbl').attr("onclick","confntbl("+(contreg+1)+")");
                    $('.registros').append('<div class="row" id="'+contreg+'">'+
                        '<div class="col-sm-3 form-group">'+
                        '<label for="coltbl'+contreg+'">Nombre columna:</label>'+
                        '<input class="form-control" type="text" id="coltbl'+contreg+'" placeholder="Nombre columna" title="Nombre de la columna" name="coltbl'+contreg+'" required />'+
                        '</div>'+
                        '<div class="col-sm-2 form-group">'+
                        '<label for="tipotbl'+contreg+'">Tipo:</label>'+
                        '<select class="form-control" name="tipotbl'+contreg+'" id="tipotbl'+contreg+'">'+
                        '  <option title="Un entero de 4 bytes; el rango con signo es de 2147483648 a 2147483647, el rango sin signo es de 0 a 4294967295">INT</option>'+
                        '  <option title="Una cadena de longitud variable (0-65,535), la longitud máxima está asociada al tamaño máximo de un registro" selected>VARCHAR</option>'+
                        '  <option title="Una columna de texto con una longitud máxima de 65535 (2^16 - 1) caracteres, almacenado con un prefijo de 2 bytes que indica la longitud del valor en bytes">TEXT</option>'+
                        '  <option title="Una fecha, el rango válido es de «1000-01-01» a «9999-12-31»">DATE</option>'+
                        '  <optgroup label="Numérico">'+
                        '      <option title="Un entero de 1 byte; el rango con signo es de -128 a 127, el rango sin signo es de 0 a 255">TINYINT</option>'+
                        '      <option title="Un entero de 2 bytes; el rango con signo es de -32768 a 32767, el rango sin signo es de 0 a 65535">SMALLINT</option>'+
                        '      <option title="Un entero de 3 bytes; el rango con signo es de -8388608 a 8388607, el rango sin signo es de 0 a 16777215">MEDIUMINT</option>'+
                        '      <option title="Un entero de 4 bytes; el rango con signo es de 2147483648 a 2147483647, el rango sin signo es de 0 a 4294967295">INT</option>'+
                        '      <option title="En entero de 8 bytes; el rango con signo es de -9223372036854775808 a 9223372036854775807, el rango sin signo es de 0 a 18446744073709551615">BIGINT</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Un número decimal fijo (M, D) - la mayor cantidad de dígitos (M) es 65 (valor predeterminado de 10), el mayor número posible de decimales (D) es 30 (valor predeterminado de 0)">DECIMAL</option>'+
                        '      <option title="Un número de coma flotante pequeño; los valores posibles son de -3.402823466E+38 a -1.175494351E-38, 0 y de 1.175494351E-38 a 3.402823466E+38">FLOAT</option>'+
                        '      <option title="Un número de coma flotante de precisión doble; los valores permitidos son de -1.7976931348623157E+308 a -2.2250738585072014E-308, 0 y de 2.2250738585072014E-308 a 1.7976931348623157E+308">DOUBLE</option>'+
                        '      <option title="Sinónimo de DOUBLE (excepción: si el modo SQL «REAL_AS_FLOAT» está activo es sinónimo de FLOAT)">REAL</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Una máscara de bits (M), almacenando M bits por valor (valor predeterminado de 1, máximo de 64)">BIT</option>'+
                        '      <option title="Sinónimo de TINYINT(1), un valor de cero es considerado falso, cualquier valor distinto de cero es considerado verdadero">BOOLEAN</option>'+
                        '      <option title="Un sinónimo de BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE">SERIAL</option>'+
                        '  </optgroup>'+
                        '  <optgroup label="Fecha y marca temporal">'+
                        '      <option title="Una fecha, el rango válido es de «1000-01-01» a «9999-12-31»">DATE</option>'+
                        '      <option title="Una combinación de fecha y marca temporal, el rango válido es de «1000-01-01 00:00:00» a «9999-12-31 23:59:59»">DATETIME</option>'+
                        '      <option title="Una marca temporal; el rango es de «01-Ene-1970 00:00:01» UTC a «09-Ene-2038 03:14:07» UTC almacenados como la cantidad de segundos desde el «epoch» («01-Ene-1970 00:00:00» UTC)">TIMESTAMP</option>'+
                        '      <option title="Una marca temporal, el rango es de «-838:59:59» a «838:59:59»">TIME</option>'+
                        '      <option title="Un año en formato de cuatro dígitos (4, el valor predeterminado) o dos dígitos (2); los valores posibles son de 70 (1970) a 69 (2069) ó de 1901 a 2155 y 0000">YEAR</option>'+
                        '  </optgroup>'+
                        '  <optgroup label="Cadena">'+
                        '      <option title="Una cadena de longitud fija (de 0 a 255, valor predeterminado de 1) que es siempre completada a la derecha con espacios hasta la longitud especificada al ser almacenada">CHAR</option>'+
                        '      <option title="Una cadena de longitud variable (0-65,535), la longitud máxima está asociada al tamaño máximo de un registro">VARCHAR</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Una columna de texto con una longitud máxima de 255 (2^8 - 1) caracteres, almacenado con un prefijo de 1 byte que indica la longitud del valor en bytes">TINYTEXT</option>'+
                        '      <option title="Una columna de texto con una longitud máxima de 65535 (2^16 - 1) caracteres, almacenado con un prefijo de 2 bytes que indica la longitud del valor en bytes">TEXT</option>'+
                        '      <option title="Una columna de texto con una longitud máxima de 16777215 (2^24 - 1) caracteres, almacenado con un prefijo de 3 bytes que indica la longitud del valor en bytes">MEDIUMTEXT</option>'+
                        '      <option title="Una columna de texto con una longitud máxima de 4294967295 ó 4Gb (2^32 - 1) caracteres, almacenado con un prefijo de 4 bytes que indica la longitud del valor en bytes">LONGTEXT</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Similar al tipo CHAR, pero almacena cadenas binarias de bytes en lugar de cadenas de caracteres no binarios">BINARY</option>'+
                        '      <option title="Similar al tipo VARCHAR, pero almacena cadenas binarias de bytes en lugar de cadenas de caracteres no binarios">VARBINARY</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 255 (2^8 - 1) bytes. Cada valor TINYBLOB es almacenado con un prefijo de 1 byte que indica la cantidad de bytes en el valor">TINYBLOB</option>'+
                        '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 16777215 (2^24 - 1) bytes, almacenado con un prefijo de 3 bytes que indica la longitud del valor">MEDIUMBLOB</option>'+
                        '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 65535 (2^16 - 1) bytes, almacenado con un prefijo de 2 bytes que indica la longitud del valor">BLOB</option>'+
                        '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 4294967295 (2^32 - 1) bytes (4GB), almacenado con un prefijo de 4 bytes que indica la longitud del valor">LONGBLOB</option>'+
                        '      <option disabled="disabled">-</option>'+
                        '      <option title="Una enumeración, elegida de una lista de hasta 65535 valores o el valor especial de error">ENUM</option>'+
                        '      <option title="Un único valor elegido de un conjunto de hasta 64 elementos">SET</option>'+
                        '  </optgroup>'+
                        '  <optgroup label="Espacial">'+
                        '      <option title="Un tipo que puede almacenar una geometría de cualquier tipo">GEOMETRY</option>'+
                        '      <option title="Un punto en espacio de dos dimensiones">POINT</option>'+
                        '      <option title="Una curva con interpolación lineal entre puntos">LINESTRING</option>'+
                        '      <option title="Un polígono">POLYGON</option>'+
                        '      <option title="Una colección de puntos">MULTIPOINT</option>'+
                        '      <option title="Una colección de curvas con interpolación lineal entre puntos">MULTILINESTRING</option>'+
                        '      <option title="Una colección de polígonos">MULTIPOLYGON</option>'+
                        '      <option title="Una colección de objetos geométricos de cualquier tipo">GEOMETRYCOLLECTION</option>'+
                        '  </optgroup>'+
                        '  <optgroup label="JSON">'+
                        '      <option title="Almacena y permite el acceso eficiente a datos en documentos JSON (JavaScript Object Notation)">JSON</option>'+
                        '  </optgroup>'+
                        '</select>'+
                        '</div>'+
                        '<div class="col-sm-3 form-group">'+
                        '<label><span title="Clave primaria">PK</span><br><input type="checkbox" name="pk'+contreg+'" id="pk'+contreg+'" style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>  '+
                        '<label><span title="No nulo">NN</span><br><input type="checkbox" name="nn'+contreg+'" id="nn'+contreg+'" style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>  '+
                        '<label><span title="Index único">UQ</span><br><input type="checkbox" name="uq'+contreg+'" id="uq'+contreg+'" style="margin-top: 15px; margin-left: 5px; margin-right: 4px;" disabled></label>  '+
                        '<label><span title="Columna binaria">BI</span><br><input type="checkbox" name="bi'+contreg+'" id="bi'+contreg+'" style="margin-top: 15px; margin-left: 3px; margin-right: 4px;" ></label>  '+
                        '<label><span title="Columna no negativa">UN</span><br><input type="checkbox" name="un'+contreg+'" id="un'+contreg+'" style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" ></label>  '+
                        '<label><span title="Completar registro con ceros">ZF</span><br><input type="checkbox" name="zf'+contreg+'" id="zf'+contreg+'" style="margin-top: 15px; margin-left: 3px; margin-right: 4px;" ></label>  '+
                        '<label><span title="Columna autoincremental">AI</span><br><input type="checkbox" name="ai'+contreg+'" id="ai'+contreg+'" style="margin-top: 15px; margin-left: 2px; margin-right: 4px;" ></label>  '+
                        '<label><span title="Columna generada por otras columnas">GC</span><br><input type="checkbox" name="gc'+contreg+'" id="gc'+contreg+'" style="margin-top: 15px; margin-left: 4px; margin-right: 4px;" disabled></label>  '+
                        '</div>'+
                        '<div class="col-sm-3 form-group">'+
                            '<label for="lontbl'+contreg+'">Longitud:</label>'+
                            '<input class="form-control" type="text" id="lontbl'+contreg+'" placeholder="Longitud del campo" title="Longitud del campo" name="lontbl'+contreg+'"/>'+
                        '</div>'+
                        '<div class="col-sm-1 form-group">'+
                            '<button type="button" id="elireg" class="btn btn-danger" title="Eliminar registro" onclick="regeli('+contreg+')" style="margin-top: 25px;"><span class="glyphicon glyphicon-remove-circle" style="margin-top: 1px; color: white; cursor: pointer;"></span></button>'+
                        '</div>'+
                        '</div>');

                });
            });
        </script>
        <script>
            function nbd(){
                var nombrebd;
                nombrebd=document.getElementById("nombd").value;
                if(nombrebd!='' && nombrebd!='SIN NOMBRE'){
                    document.getElementById("formnbd").submit();
                }
            };
        </script>
        <script>
            function confnbd(){
                var nombre,cotejamiento;
                nombre=document.getElementById("nombd").value;
                if(nombre=='' && nombre!='SIN NOMBRE'){
                    nombre="SIN NOMBRE";
                    $("#nonombrebd").removeClass("hide");
                }
                else{
                    $("#nonombrebd").addClass("hide");
                }
                $('.infor').empty();
                //$("#nbdlin2").hide();
                //$("#nbdcom2").hide();
                cotejamiento=document.getElementById("cote").value;
                if(nombre!='' && nombre!='SIN NOMBRE'){
                    $("#nbdlin1").append("<span id=\"nbdlin2\">Se va a lanzar el siguiente comando al servidor: </span>");
                    $("#nbdcom1").append("<span id=\"nbdcom2\"><strong>CREATE DATABASE `"+nombre+"` COLLATE "+cotejamiento+";</strong></span>");
                }
            };
        </script>
        <script>
            function bbdconf(){
                /*var seleccion,i,j,k;
                i=0;
                j=i.toString();
                localStorage.setItem("i",i);
                seleccion=[];
                localStorage.setItem("seleccion",seleccion);
                while(document.getElementById(i).getAttribute){
                    seleccion.push(document.getElementById(i).getAttribute);
                    localStorage.setItem("seleccion",seleccion);
                    i++;
                    localStorage.setItem("i",i);
                }*/
                var seleccion,i;
                seleccion=[];
                i=0;
                $('.infor').empty();
                localStorage.setItem("longitud",seleccion.length);
                $('.bbdcheckbox:checked').each(
                    function() {
                        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
                        seleccion.push($(this).val());
                        localStorage.setItem("seleccion",seleccion);
                        localStorage.setItem("longitud",seleccion.length);
                    }
                );
                if(seleccion.length==0){
                    $('#bbdnobd').removeClass('hide');
                    i=0;
                }
                else{
                    $('#bbdnobd').addClass('hide');
                    $('#bbdlin1').append("<span class=\"bbdlin2\">Se va a lanzar el siguiente bloque al servidor: </span>");
                    while(i<seleccion.length){
                        $('#bbdcom1').append("<span class=\"bbdcom2\"><strong>DROP DATABASE `"+seleccion[i]+"`;</strong></span><br>\n");
                        i++;
                    }
                }
                $('#bbdcont').attr({'value':i});
            };
        </script>
        <script>
            function bbd(){
                if(localStorage.getItem("longitud")!=0)
                    document.getElementById("formbbd").submit();
            }
        </script>
        <script>
            function regeli(reg){
                $(document).find('#'+reg).remove();
            }
            function confntbl(reg){
                var conf = "true";
                // Variables
                var tabla       = $(document).find('#nomtbl').val();
                var bd          = '<?php if(isset($_SESSION['bdselected'])) echo $_SESSION['bdselected']; ?>';
                var ok          = 'false';
                var totales     = 0;
                var cuenta      = 0;
                var motor       = $(document).find('#motor').val();
                var coteja      = $(document).find('#cote').val();

                // Si el nombre de la tabla está vacío, limpiamos los mensajes posibles y mostramos el error
                if(tabla==''){
                    $('#faltandatos').removeClass('hide');
                    $('#creartbl').addClass('disabled');
                    $('.infor').empty();
                    conf = "false";
                }
                var i = 0;
                while(i<reg){
                    // Si existe el DIV y el nombre de la tabla no está vacío, entramos
                    // Si algún nombre de registro se encuentra vacío, limpiamos los mensajes posibles y mostramos el error
                    if ($(document).find('#'+i).length != 0 && conf == "true") {
                        //console.log(i);
                        //console.log($(document).find('#'+i));
                        //console.log($(document).find('#'+i).find('#coltbl'+i));
                        //console.log($(document).find('#'+i).find('#coltbl'+i).val());
                        if($(document).find('#'+i).find('#coltbl'+i).val() == ''){
                            $('#faltandatos').removeClass('hide');
                            $('#creartbl').addClass('disabled');
                            $('.infor').empty();
                            break;
                        }
                        // En caso de que no haya ningún campo vacío, ocultamos el error y habilitamos el botón
                        else{
                            $('#faltandatos').addClass('hide');
                            $('#creartbl').removeClass('disabled');
                            ok = 'true';
                            totales++;
                        }
                    }
                    i++;
                }
                // Si el botón está habilitado, comenzamos a generar los mensajes
                if(ok == 'true'){
                    $('.infor').empty();
                    $('#ntbllin').append('Se va a lanzar el siguiente bloque al servidor: ');
                    $('#ntblcom').append('<b><span style="color:purple">CREATE TABLE</span> `'+bd+'`.`'+tabla+'` <span style="color:purple">(</span></b>');
                    i = 0;
                    while(i<reg){
                        // Variables de registros
                        var registro    = $(document).find('#'+i).find('#coltbl'+i).val();
                        var tipo        = $(document).find('#'+i).find('#tipotbl'+i).val();
                        var longitud    = $(document).find('#'+i).find('#lontbl'+i).val();
                        cuenta++;

                        if($(document).find('#'+i).length != 0){
                            $('#ntblcom').append('<br><b>`'+registro+'` <span style="color:green;">'+tipo+'</span></b>');
                            // Si existe longitud del campo, se añade
                            if(longitud != 0)
                                $('#ntblcom').append('<span style="color:green;"><b>('+longitud+')</b></span>');
                            else
                                $('#ntblcom').append('<span style="color:green;"><b>(10)</b></span>');
                            if($(document).find('#'+i).find('#bi'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>BINARY</b></span>');
                            if($(document).find('#'+i).find('#un'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>UNSIGNED</b></span>');
                            if($(document).find('#'+i).find('#zf'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>ZEROFILL</b></span>');
                            if($(document).find('#'+i).find('#pk'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>PRIMARY KEY</b></span>');
                            //console.log($(document).find('#'+i).find('#nn'+i+':checked'));
                            if($(document).find('#'+i).find('#nn'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>NOT NULL</b></span>');
                            if($(document).find('#'+i).find('#ai'+i+':checked').length != 0)
                                $('#ntblcom').append(' <span style="color:red;"><b>AUTO_INCREMENT</b></span>');
                            // Si hay mas registros, añadimos una ',' al final de la línea
                            if(totales != cuenta)
                                $('#ntblcom').append('<b>,</b>');
                        }
                        i++;
                    }
                    // Añadimos la coletilla
                    $('#ntblcom').append('<br><span style="color:purple"><b>) ENGINE = '+motor+' COLLATE '+coteja+';</b></span>');
                }
            }
            function ntbl(){
                if($(document).find('#creartbl').hasClass('disabled') == false)
                    document.getElementById("formntbl").submit();
            }
        </script>
    </head>