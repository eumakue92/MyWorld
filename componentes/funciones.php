<?php session_start();

/**
 * Este archivo contendrá las funciones que vayamos requiriendo para una o varias páginas y, además, nos iniciará las sesiones de cada página.
 * 
 * @author Eugenio Perojil
 *         
 */
 
/**
 * <strong>Función <i>remember()</i></strong>
 *
 * Nos permite guardar en una variable de sesión si el check de <i>recordar</i> está marcado.
 * 
 * @author Eugenio Perojil
 * @return boolean $ret Si el check está activo, devolverá <strong>True</strong>.
 */

function remember(){
    $ret=false;
    if(isset($_SESSION['remember'])){
        $ret=true;
    }
    return $ret;
}

/**
 * <strong>Función <i>nombre()</i></strong>
 * 
 * Guarda en una variable de sesión el nombre del usuario si <i>remember()</i> devuelve <strong>True</strong>.
 * 
 * @author Eugenio Perojil
 * @return string $nom Si el check está activo, devolverá el <strong>usuario</strong>.
 */
function nombre(){
    $nom='';
    if(remember()){
        $nom = $_SESSION['remember']['nombre'];
    }
    return $nom;
}

/**
 * <strong>Función <i>contrasena()</i></strong>
 * 
 * Guarda en una variable de sesión la contraseña si <i>remember()</i> devuelve <strong>True</strong>.
 * 
 * @author Eugenio Perojil
 * @return string $nom Si el check está activo, devolverá la <strong>contraseña</strong>.
 */
function contrasena(){
    $con='';
    if(remember()){
        $con = @$_SESSION['remember']['contrasena'];
    }
    return $con;
}

/**
 * <strong>Función <i>servidor()</i></strong>
 * 
 * Guarda en una variable de sesión el servidor si <i>remember()</i> devuelve <strong>True</strong>.
 * 
 * @author Eugenio Perojil
 * @return string $nom Si el check está activo, devolverá el <strong>servidor</strong>.
 */
function servidor(){
    $ser='';
    if(remember()){
        $ser=$_SESSION['remember']['servidor'];
    }
    return $ser;
}

/**
 * <strong>Función <i>conectar()</i></strong>
 * 
 * Se hace una prueba de conexión con las credenciales facilitadas y en el servidor indicado.
 * Si la conexión es posible se guardan las credenciales y el servidor en variables de sesión.
 * Si la conexión se lleva a cabo, se redirige a la persona al menú inicial de la página.
 * Si fracasa, se devuelve al usuario a la página de login.
 * 
 * @author Eugenio Perojil
 */
function conectar(){
    $user=$_POST['user'];
    $serv=$_POST['serv'];
    if(isset($_POST['pass'])) $pass=$_POST['pass'];
    else $pass='';
    $conn=mysqli_connect($serv,$user,$pass);
    if($conn){
        $_SESSION['remember']['nombre']=$_POST['user'];
        $_SESSION['remember']['contrasena']=$_POST['pass'];
        $_SESSION['remember']['servidor']=$_POST['serv'];
        $_SESSION['fallo']=false;
        header('location:MainMenu.php');
    } 
    else{
        $_SESSION['fallo']=true;
        $_SESSION['remember']['nombre']=$_POST['user'];
        $_SESSION['remember']['servidor']=$_POST['serv'];
        header('location:Index.php');
    }
}

/**
 * <strong>Función <i>desconectar()</i></strong>
 * 
 * Nos permite destruir la sesión y devolver al usuario al login (cierra sesión).
 * 
 * @author Eugenio Perojil
 */
function desconectar(){
    session_destroy();
    header("location:index.php");
}

/**
 * <strong>Función <i>seguridad()</i></strong>
 * 
 * Si cualquier intruso trata de entrar a cualquier página sin una sesión iniciada, se le devolverá al login.
 * Se incluye en la cabecera de cada página.
 * 
 * @author Eugenio Perojil
 */
function seguridad(){
    if($_SESSION['fallo']==true || !isset($_SESSION['fallo'])) header('location:index.php');
}

/**
 * <strong>Función <i>conexion()</i></strong>
 * 
 * Realiza la conexión con el servidor para cualquier operación llevada a cabo.
 * 
 * @author Eugenio Perojil
 * @return boolean $conn Devuelve el valor de la conexión.
 */
function conexion(){
    $conn=mysqli_connect(servidor(),nombre(),contrasena());
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

/**
 * <strong>Función <i>nbdlanza()</i></strong>
 * 
 * Recogemos el <strong>nombre de la BD</strong> y el <strong>cotejamiento</strong>.
 * Si es posible llevar a cabo la <i>query</i>, lanzamos la línea al servidor y guardamos
 * un valor <strong>True</strong> o <strong>False<strong> según el resultado para mostrar un <i>alert</i>.
 * 
 * @author Eugenio Perojil
 */
function nbdlanza(){
    $bd=$_POST['nombrebd'];
    $cotejamiento=$_POST['cotejamiento'];
    $query="CREATE DATABASE `$bd` COLLATE $cotejamiento;";
    echo $query;
    if(mysqli_query(conexion(),$query)){
        mysqli_query(conexion(),$query);
        $_SESSION['query']=true;
    }
    else{
        $_SESSION['query']=false;
        mysqli_close();
    }
    header("location:nbd.php");
}

/**
 * <strong>Función <i>nbdquery()</i></strong>
 * 
 * Una vez se intenta realizar la creación de la BD, creamos la alerta de <strong>éxito</strong> o de <strong>fracaso</strong>.
 * 
 * @author Eugenio Perojil
 */
function nbdquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query']===true){
            echo "<div class=\"row\">
                <div class=\"col-sm-12\">
                    <div class=\"alert alert-success\" id=\"nbdquerytrue\">Base de datos creada con éxito</div>
                </div>
            </div>";
            $_SESSION['query']='';
        }
        elseif($_SESSION['query']===false){
            echo "<div class=\"row\">
                <div class=\"col-sm-12\">
                    <div class=\"alert alert-danger\" id=\"nbdqueryfalse\">Base de datos imposible de crear</div>
                </div>
            </div>";
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

/**
 * <strong>Función <i>bbdlista()</i></strong>
 * 
 * Con esta función pedimos al servidor que muestre todas las bases de datos que el usuario puede ver con sus credenciales.
 * Una vez recogidas, creamos una tabla con <i>checkbox</i> por cada fila para que pueda marcar tantas BD como quiera borrar
 * y el nombre de la BD a continuación.
 * 
 * @author Eugenio Perojil
 */
function bbdlista(){
    $query="SHOW DATABASES;";
    if(mysqli_query(conexion(),$query)){
        $almacen=mysqli_query(conexion(),$query);
        $name=0;
        echo "<div class='col-sm-12 bbddiv' id='bbddiv'>";
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th>Base de Datos</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th> Base de Datos</th>";
        echo "</tr>";
        echo "<tfoot>";
        echo "<tbody>";
        while($cursor=mysqli_fetch_array($almacen)){
            echo "<tr>
                            <td style=\"width:10px;text-align:right;\"><input class=\"checkbox bbdcheckbox\" type=\"checkbox\" name=\"$name\" id=\"$name\" value=\"".$cursor["Database"]."\"/></td>
                            <td><laber for=\"$name\">".$cursor["Database"]."</label></td>
                        </tr>";
            $name++;
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "\n";
        $_SESSION['bd']=$name;
    }
}

/**
 * <strong>Función <i>bbdlanza()</i></strong>
 * 
 * Por cada base de datos seleccionada se lanzará una instrucción tras comprobar que es válida.
 * Por cada ejecución guardaremos una variable de sesión con <strong>True</strong> o <strong>False</strong>
 * que se usará para los <i>alert</i>.
 * 
 * @author Eugenio Perojil
 */
function bbdlanza(){
    $bbdcont=$_POST['bbdcont'];
    $bbdaux=0;
    $bbdseleccion=0;
    $bbdcontenedor=array();
    while($bbdseleccion<$bbdcont){
        if(isset($_POST[$bbdaux])){
            $bbdcontenedor[]=$_POST[$bbdaux];
            $bbdseleccion++;
        }
        $bbdaux++;
    }
    print_r($bbdcontenedor);
    for($i=0;$i<=count($bbdcontenedor);$i++){
        $query="DROP DATABASE `".$bbdcontenedor[$i]."`;";
        $_SESSION['bbdquerybd'.$i]=$bbdcontenedor[$i];
        //echo $query;
        if(mysqli_query(conexion(),$query)){
            mysqli_query(conexion(),$query);
            $_SESSION['bbdquery'.$i]=true;
        }
        else{
            $_SESSION['bbdquery'.$i]=false;
        }
        $_SESSION['bbdquerycont']=$i;
    }
    header("location:bbd.php");
}

/**
 * <strong>Función <i>bbdquery()</i></strong>
 * 
 * Tras la ejecución del borrado de BD y regresar a la página, mostramos los <i>alert</i> correspondientes
 * a cada lanzamiento.
 * 
 * @author Eugenio Perojil
 */
function bbdquery(){
    if(isset($_SESSION['bbdquerycont'])){
        if($_SESSION['bbdquerycont']>=0){
            for($i=0;$i<$_SESSION['bbdquerycont'];$i++){
                if($_SESSION['bbdquery'.$i]===true){
                    echo "<div class=\"row\">
                        <div class=\"col-sm-12\">
                            <div class=\"alert alert-success\" id=\"bbdquerytrue\">Base de datos '".$_SESSION['bbdquerybd'.$i]."' eliminada con éxito</div>
                        </div>
                    </div>";
                }
                elseif($_SESSION['bbdquery'.$i]===false){
                    echo "<div class=\"row\">
                        <div class=\"col-sm-12\">
                            <div class=\"alert alert-danger\" id=\"bbdqueryfalse\">Base de datos '".$_SESSION['bbdquerybd'.$i]."' imposible de eliminar</div>
                        </div>
                    </div>";
                    $_SESSION['bbdquerycont']=-1;
                }
            }
        }
    }
    $_SESSION['bbdquerycont']=-1;
}

/**
 * <strong>Función <i>vbdlista()</i></strong>
 * 
 * Con esta función pedimos al servidor que muestre todas las bases de datos que el usuario puede ver con sus credenciales.
 * Una vez recogidas, creamos una tabla con el nombre de las bases de datos listas para redireccionar.
 * 
 * @author Eugenio Perojil
 */
function vbdlista(){
    $query="SHOW DATABASES;";
    if(mysqli_query(conexion(),$query)){
        $almacen=mysqli_query(conexion(),$query);
        $name=0;
        echo "<div class='col-sm-12 vbddiv' id='vbddiv'>";
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nombre de la Base de Datos</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "<th>Nombre de la Base de Datos</th>";
        echo "</tr>";
        echo "<tfoot>";
        echo "<tbody>";
        while($cursor=mysqli_fetch_array($almacen)){
            echo "<tr>";
            echo "<td style='color:white;'><a href='vtbl.php?bd=".$cursor['Database']."'><strong>".$cursor["Database"]."</strong></a></td>";
            echo "</tr>";
            $name++;
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "\n";
        $_SESSION['bd']=$name;
    }
}

/**
 * <strong>Función <i>cotejamiento()</i></strong>
 * 
 * Creamos una función que posea el <i>select</i> del cotejamiento por si fuera necesario incluirla más de una vez.
 * 
 * @author Eugenio Perojil
 */
function cotejamiento(){
    echo "<select name=\"cotejamiento\" id=\"cote\" class=\"form-control selectpicker show-menu-arrow\" data-live-search=\"true\" title=\"Cotejamiento\">
                            <optgroup label=\"armscii8\" title=\"ARMSCII-8 Armenian\">
                                <option value=\"armscii8_bin\" title=\"Armenio, binario\">armscii8_bin</option>
                                <option value=\"armscii8_general_ci\" title=\"Armenio, independiente de mayúsculas y minúsculas\">armscii8_general_ci</option>
                            </optgroup>
                            <optgroup label=\"ascii\" title=\"US ASCII\">
                                <option value=\"ascii_bin\" title=\"Europea occidental, binario\">ascii_bin</option>
                                <option value=\"ascii_general_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">ascii_general_ci</option>
                            </optgroup>
                            <optgroup label=\"big5\" title=\"Big5 Traditional Chinese\">
                                <option value=\"big5_bin\" title=\"Chino tradicional, binario\">big5_bin</option>
                                <option value=\"big5_chinese_ci\" title=\"Chino tradicional, independiente de mayúsculas y minúsculas\">big5_chinese_ci</option>
                            </optgroup>
                                <optgroup label=\"binary\" title=\"Binary pseudo charset\">
                                <option value=\"binary\" title=\"Binario\">binary</option>
                            </optgroup>
                            <optgroup label=\"cp1250\" title=\"Windows Central European\">
                                <option value=\"cp1250_bin\" title=\"Europeo central, binario\">cp1250_bin</option>
                                <option value=\"cp1250_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">cp1250_croatian_ci</option>
                                <option value=\"cp1250_czech_cs\" title=\"Checo, dependiente de mayúsculas y minúsculas\">cp1250_czech_cs</option>
                                <option value=\"cp1250_general_ci\" title=\"Europeo central, independiente de mayúsculas y minúsculas\">cp1250_general_ci</option>
                                <option value=\"cp1250_polish_ci\" title=\"Polaco, independiente de mayúsculas y minúsculas\">cp1250_polish_ci</option>
                            </optgroup>
                            <optgroup label=\"cp1251\" title=\"Windows Cyrillic\">
                                <option value=\"cp1251_bin\" title=\"Cirílico, binario\">cp1251_bin</option>
                                <option value=\"cp1251_bulgarian_ci\" title=\"Búlgaro, independiente de mayúsculas y minúsculas\">cp1251_bulgarian_ci</option>
                                <option value=\"cp1251_general_ci\" title=\"Cirílico, independiente de mayúsculas y minúsculas\">cp1251_general_ci</option>
                                <option value=\"cp1251_general_cs\" title=\"Cirílico, dependiente de mayúsculas y minúsculas\">cp1251_general_cs</option>
                                <option value=\"cp1251_ukrainian_ci\" title=\"Ucraniano, independiente de mayúsculas y minúsculas\">cp1251_ukrainian_ci</option>
                            </optgroup>
                            <optgroup label=\"cp1256\" title=\"Windows Arabic\">
                                <option value=\"cp1256_bin\" title=\"Árabe, binario\">cp1256_bin</option>
                                <option value=\"cp1256_general_ci\" title=\"Árabe, independiente de mayúsculas y minúsculas\">cp1256_general_ci</option>
                            </optgroup>
                            <optgroup label=\"cp1257\" title=\"Windows Baltic\">
                                <option value=\"cp1257_bin\" title=\"Báltico, binario\">cp1257_bin</option>
                                <option value=\"cp1257_general_ci\" title=\"Báltico, independiente de mayúsculas y minúsculas\">cp1257_general_ci</option>
                                <option value=\"cp1257_lithuanian_ci\" title=\"Lituano, independiente de mayúsculas y minúsculas\">cp1257_lithuanian_ci</option>
                            </optgroup>
                            <optgroup label=\"cp850\" title=\"DOS West European\">
                                <option value=\"cp850_bin\" title=\"Europea occidental, binario\">cp850_bin</option>
                                <option value=\"cp850_general_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">cp850_general_ci</option>
                            </optgroup>
                            <optgroup label=\"cp852\" title=\"DOS Central European\">
                                <option value=\"cp852_bin\" title=\"Europeo central, binario\">cp852_bin</option>
                                <option value=\"cp852_general_ci\" title=\"Europeo central, independiente de mayúsculas y minúsculas\">cp852_general_ci</option>
                            </optgroup>
                            <optgroup label=\"cp866\" title=\"DOS Russian\">
                                <option value=\"cp866_bin\" title=\"Ruso, binario\">cp866_bin</option>
                                <option value=\"cp866_general_ci\" title=\"Ruso, independiente de mayúsculas y minúsculas\">cp866_general_ci</option>
                            </optgroup>
                            <optgroup label=\"cp932\" title=\"SJIS for Windows Japanese\">
                                <option value=\"cp932_bin\" title=\"Japonés, binario\">cp932_bin</option>
                                <option value=\"cp932_japanese_ci\" title=\"Japonés, independiente de mayúsculas y minúsculas\">cp932_japanese_ci</option>
                            </optgroup>
                            <optgroup label=\"dec8\" title=\"DEC West European\">
                                <option value=\"dec8_bin\" title=\"Europea occidental, binario\">dec8_bin</option>
                                <option value=\"dec8_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">dec8_swedish_ci</option>
                            </optgroup>
                            <optgroup label=\"eucjpms\" title=\"UJIS for Windows Japanese\">
                                <option value=\"eucjpms_bin\" title=\"Japonés, binario\">eucjpms_bin</option>
                                <option value=\"eucjpms_japanese_ci\" title=\"Japonés, independiente de mayúsculas y minúsculas\">eucjpms_japanese_ci</option>
                            </optgroup>
                            <optgroup label=\"euckr\" title=\"EUC-KR Korean\">
                                <option value=\"euckr_bin\" title=\"Coreano, binario\">euckr_bin</option>
                                <option value=\"euckr_korean_ci\" title=\"Coreano, independiente de mayúsculas y minúsculas\">euckr_korean_ci</option>
                            </optgroup>
                            <optgroup label=\"gb18030\" title=\"China National Standard GB18030\">
                                <option value=\"gb18030_bin\" title=\"Desconocido, binario\">gb18030_bin</option>
                                <option value=\"gb18030_chinese_ci\" title=\"Desconocido, independiente de mayúsculas y minúsculas\">gb18030_chinese_ci</option>
                                <option value=\"gb18030_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">gb18030_unicode_520_ci</option>
                            </optgroup>
                            <optgroup label=\"gb2312\" title=\"GB2312 Simplified Chinese\">
                                <option value=\"gb2312_bin\" title=\"Chino simplificado, binario\">gb2312_bin</option>
                                <option value=\"gb2312_chinese_ci\" title=\"Chino simplificado, independiente de mayúsculas y minúsculas\">gb2312_chinese_ci</option>
                            </optgroup>
                            <optgroup label=\"gbk\" title=\"GBK Simplified Chinese\">
                                <option value=\"gbk_bin\" title=\"Chino simplificado, binario\">gbk_bin</option>
                                <option value=\"gbk_chinese_ci\" title=\"Chino simplificado, independiente de mayúsculas y minúsculas\">gbk_chinese_ci</option>
                            </optgroup>
                            <optgroup label=\"geostd8\" title=\"GEOSTD8 Georgian\">
                                <option value=\"geostd8_bin\" title=\"Georgiano, binario\">geostd8_bin</option>
                                <option value=\"geostd8_general_ci\" title=\"Georgiano, independiente de mayúsculas y minúsculas\">geostd8_general_ci</option>
                            </optgroup>
                            <optgroup label=\"greek\" title=\"ISO 8859-7 Greek\">
                                <option value=\"greek_bin\" title=\"Griego, binario\">greek_bin</option>
                                <option value=\"greek_general_ci\" title=\"Griego, independiente de mayúsculas y minúsculas\">greek_general_ci</option>
                            </optgroup>
                            <optgroup label=\"hebrew\" title=\"ISO 8859-8 Hebrew\">
                                <option value=\"hebrew_bin\" title=\"Hebreo, binario\">hebrew_bin</option>
                                <option value=\"hebrew_general_ci\" title=\"Hebreo, independiente de mayúsculas y minúsculas\">hebrew_general_ci</option>
                            </optgroup>
                            <optgroup label=\"hp8\" title=\"HP West European\">
                                <option value=\"hp8_bin\" title=\"Europea occidental, binario\">hp8_bin</option>
                                <option value=\"hp8_english_ci\" title=\"Inglés, independiente de mayúsculas y minúsculas\">hp8_english_ci</option>
                            </optgroup>
                            <optgroup label=\"keybcs2\" title=\"DOS Kamenicky Czech-Slovak\">
                                <option value=\"keybcs2_bin\" title=\"Checo-Eslovaco, binario\">keybcs2_bin</option>
                                <option value=\"keybcs2_general_ci\" title=\"Checo-Eslovaco, independiente de mayúsculas y minúsculas\">keybcs2_general_ci</option>
                            </optgroup>
                            <optgroup label=\"koi8r\" title=\"KOI8-R Relcom Russian\">
                                <option value=\"koi8r_bin\" title=\"Ruso, binario\">koi8r_bin</option>
                                <option value=\"koi8r_general_ci\" title=\"Ruso, independiente de mayúsculas y minúsculas\">koi8r_general_ci</option>
                            </optgroup>
                            <optgroup label=\"koi8u\" title=\"KOI8-U Ukrainian\">
                                <option value=\"koi8u_bin\" title=\"Ucraniano, binario\">koi8u_bin</option>
                                <option value=\"koi8u_general_ci\" title=\"Ucraniano, independiente de mayúsculas y minúsculas\">koi8u_general_ci</option>
                            </optgroup>
                            <optgroup label=\"latin1\" title=\"cp1252 West European\">
                                <option value=\"latin1_bin\" title=\"Europea occidental, binario\">latin1_bin</option>
                                <option value=\"latin1_danish_ci\" title=\"Danés, independiente de mayúsculas y minúsculas\">latin1_danish_ci</option>
                                <option value=\"latin1_general_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">latin1_general_ci</option>
                                <option value=\"latin1_general_cs\" title=\"Europea occidental, dependiente de mayúsculas y minúsculas\">latin1_general_cs</option>
                                <option value=\"latin1_german1_ci\" title=\"Alemán (ordenado según diccionario), independiente de mayúsculas y minúsculas\">latin1_german1_ci</option>
                                <option value=\"latin1_german2_ci\" title=\"Alemán (ordenado según libreta telefónica), independiente de mayúsculas y minúsculas\">latin1_german2_ci</option>
                                <option value=\"latin1_spanish_ci\" title=\"Español (moderno), independiente de mayúsculas y minúsculas\">latin1_spanish_ci</option>
                                <option value=\"latin1_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">latin1_swedish_ci</option>
                            </optgroup>
                            <optgroup label=\"latin2\" title=\"ISO 8859-2 Central European\">
                                <option value=\"latin2_bin\" title=\"Europeo central, binario\">latin2_bin</option>
                                <option value=\"latin2_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">latin2_croatian_ci</option>
                                <option value=\"latin2_czech_cs\" title=\"Checo, dependiente de mayúsculas y minúsculas\">latin2_czech_cs</option>
                                <option value=\"latin2_general_ci\" title=\"Europeo central, independiente de mayúsculas y minúsculas\">latin2_general_ci</option>
                                <option value=\"latin2_hungarian_ci\" title=\"Húngaro, independiente de mayúsculas y minúsculas\">latin2_hungarian_ci</option>
                            </optgroup>
                            <optgroup label=\"latin5\" title=\"ISO 8859-9 Turkish\">
                                <option value=\"latin5_bin\" title=\"Turco, binario\">latin5_bin</option>
                                <option value=\"latin5_turkish_ci\" title=\"Turco, independiente de mayúsculas y minúsculas\">latin5_turkish_ci</option>
                            </optgroup>
                            <optgroup label=\"latin7\" title=\"ISO 8859-13 Baltic\">
                                <option value=\"latin7_bin\" title=\"Báltico, binario\">latin7_bin</option>
                                <option value=\"latin7_estonian_cs\" title=\"Estonio, dependiente de mayúsculas y minúsculas\">latin7_estonian_cs</option>
                                <option value=\"latin7_general_ci\" title=\"Báltico, independiente de mayúsculas y minúsculas\">latin7_general_ci</option>
                                <option value=\"latin7_general_cs\" title=\"Báltico, dependiente de mayúsculas y minúsculas\">latin7_general_cs</option>
                            </optgroup>
                            <optgroup label=\"macce\" title=\"Mac Central European\">
                                <option value=\"macce_bin\" title=\"Europeo central, binario\">macce_bin</option>
                                <option value=\"macce_general_ci\" title=\"Europeo central, independiente de mayúsculas y minúsculas\">macce_general_ci</option>
                            </optgroup>
                            <optgroup label=\"macroman\" title=\"Mac West European\">
                                <option value=\"macroman_bin\" title=\"Europea occidental, binario\">macroman_bin</option>
                                <option value=\"macroman_general_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">macroman_general_ci</option>
                            </optgroup>
                            <optgroup label=\"sjis\" title=\"Shift-JIS Japanese\">
                                <option value=\"sjis_bin\" title=\"Japonés, binario\">sjis_bin</option>
                                <option value=\"sjis_japanese_ci\" title=\"Japonés, independiente de mayúsculas y minúsculas\">sjis_japanese_ci</option>
                            </optgroup>
                            <optgroup label=\"swe7\" title=\"7bit Swedish\">
                                <option value=\"swe7_bin\" title=\"Sueco, binario\">swe7_bin</option>
                                <option value=\"swe7_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">swe7_swedish_ci</option>
                            </optgroup>
                            <optgroup label=\"tis620\" title=\"TIS620 Thai\">
                                <option value=\"tis620_bin\" title=\"Tailandés, binario\">tis620_bin</option>
                                <option value=\"tis620_thai_ci\" title=\"Tailandés, independiente de mayúsculas y minúsculas\">tis620_thai_ci</option>
                            </optgroup>
                            <optgroup label=\"ucs2\" title=\"UCS-2 Unicode\">
                                <option value=\"ucs2_bin\" title=\"Unicode, binario\">ucs2_bin</option>
                                <option value=\"ucs2_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">ucs2_croatian_ci</option>
                                <option value=\"ucs2_czech_ci\" title=\"Checo, independiente de mayúsculas y minúsculas\">ucs2_czech_ci</option>
                                <option value=\"ucs2_danish_ci\" title=\"Danés, independiente de mayúsculas y minúsculas\">ucs2_danish_ci</option>
                                <option value=\"ucs2_esperanto_ci\" title=\"Esperanto, independiente de mayúsculas y minúsculas\">ucs2_esperanto_ci</option>
                                <option value=\"ucs2_estonian_ci\" title=\"Estonio, independiente de mayúsculas y minúsculas\">ucs2_estonian_ci</option>
                                <option value=\"ucs2_general_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">ucs2_general_ci</option>
                                <option value=\"ucs2_general_mysql500_ci\" title=\"Unicode (MySQL 5.0.0), independiente de mayúsculas y minúsculas\">ucs2_general_mysql500_ci</option>
                                <option value=\"ucs2_german2_ci\" title=\"Alemán (ordenado según libreta telefónica), independiente de mayúsculas y minúsculas\">ucs2_german2_ci</option>
                                <option value=\"ucs2_hungarian_ci\" title=\"Húngaro, independiente de mayúsculas y minúsculas\">ucs2_hungarian_ci</option>
                                <option value=\"ucs2_icelandic_ci\" title=\"Islandés, independiente de mayúsculas y minúsculas\">ucs2_icelandic_ci</option>
                                <option value=\"ucs2_latvian_ci\" title=\"Letón, independiente de mayúsculas y minúsculas\">ucs2_latvian_ci</option>
                                <option value=\"ucs2_lithuanian_ci\" title=\"Lituano, independiente de mayúsculas y minúsculas\">ucs2_lithuanian_ci</option>
                                <option value=\"ucs2_persian_ci\" title=\"Persa, independiente de mayúsculas y minúsculas\">ucs2_persian_ci</option>
                                <option value=\"ucs2_polish_ci\" title=\"Polaco, independiente de mayúsculas y minúsculas\">ucs2_polish_ci</option>
                                <option value=\"ucs2_roman_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">ucs2_roman_ci</option>
                                <option value=\"ucs2_romanian_ci\" title=\"Rumano, independiente de mayúsculas y minúsculas\">ucs2_romanian_ci</option>
                                <option value=\"ucs2_sinhala_ci\" title=\"Singalés, independiente de mayúsculas y minúsculas\">ucs2_sinhala_ci</option>
                                <option value=\"ucs2_slovak_ci\" title=\"Eslovaco, independiente de mayúsculas y minúsculas\">ucs2_slovak_ci</option>
                                <option value=\"ucs2_slovenian_ci\" title=\"Esloveno, independiente de mayúsculas y minúsculas\">ucs2_slovenian_ci</option>
                                <option value=\"ucs2_spanish2_ci\" title=\"Español (tradicional), independiente de mayúsculas y minúsculas\">ucs2_spanish2_ci</option>
                                <option value=\"ucs2_spanish_ci\" title=\"Español (moderno), independiente de mayúsculas y minúsculas\">ucs2_spanish_ci</option>
                                <option value=\"ucs2_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">ucs2_swedish_ci</option>
                                <option value=\"ucs2_turkish_ci\" title=\"Turco, independiente de mayúsculas y minúsculas\">ucs2_turkish_ci</option>
                                <option value=\"ucs2_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">ucs2_unicode_520_ci</option>
                                <option value=\"ucs2_unicode_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">ucs2_unicode_ci</option>
                                <option value=\"ucs2_vietnamese_ci\" title=\"Vietnamita, independiente de mayúsculas y minúsculas\">ucs2_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label=\"ujis\" title=\"EUC-JP Japanese\">
                                <option value=\"ujis_bin\" title=\"Japonés, binario\">ujis_bin</option>
                                <option value=\"ujis_japanese_ci\" title=\"Japonés, independiente de mayúsculas y minúsculas\">ujis_japanese_ci</option>
                            </optgroup>
                            <optgroup label=\"utf16\" title=\"UTF-16 Unicode\">
                                <option value=\"utf16_bin\" title=\"Unicode, binario\">utf16_bin</option>
                                <option value=\"utf16_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">utf16_croatian_ci</option>
                                <option value=\"utf16_czech_ci\" title=\"Checo, independiente de mayúsculas y minúsculas\">utf16_czech_ci</option>
                                <option value=\"utf16_danish_ci\" title=\"Danés, independiente de mayúsculas y minúsculas\">utf16_danish_ci</option>
                                <option value=\"utf16_esperanto_ci\" title=\"Esperanto, independiente de mayúsculas y minúsculas\">utf16_esperanto_ci</option>
                                <option value=\"utf16_estonian_ci\" title=\"Estonio, independiente de mayúsculas y minúsculas\">utf16_estonian_ci</option>
                                <option value=\"utf16_general_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf16_general_ci</option>
                                <option value=\"utf16_german2_ci\" title=\"Alemán (ordenado según libreta telefónica), independiente de mayúsculas y minúsculas\">utf16_german2_ci</option>
                                <option value=\"utf16_hungarian_ci\" title=\"Húngaro, independiente de mayúsculas y minúsculas\">utf16_hungarian_ci</option>
                                <option value=\"utf16_icelandic_ci\" title=\"Islandés, independiente de mayúsculas y minúsculas\">utf16_icelandic_ci</option>
                                <option value=\"utf16_latvian_ci\" title=\"Letón, independiente de mayúsculas y minúsculas\">utf16_latvian_ci</option>
                                <option value=\"utf16_lithuanian_ci\" title=\"Lituano, independiente de mayúsculas y minúsculas\">utf16_lithuanian_ci</option>
                                <option value=\"utf16_persian_ci\" title=\"Persa, independiente de mayúsculas y minúsculas\">utf16_persian_ci</option>
                                <option value=\"utf16_polish_ci\" title=\"Polaco, independiente de mayúsculas y minúsculas\">utf16_polish_ci</option>
                                <option value=\"utf16_roman_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">utf16_roman_ci</option>
                                <option value=\"utf16_romanian_ci\" title=\"Rumano, independiente de mayúsculas y minúsculas\">utf16_romanian_ci</option>
                                <option value=\"utf16_sinhala_ci\" title=\"Singalés, independiente de mayúsculas y minúsculas\">utf16_sinhala_ci</option>
                                <option value=\"utf16_slovak_ci\" title=\"Eslovaco, independiente de mayúsculas y minúsculas\">utf16_slovak_ci</option>
                                <option value=\"utf16_slovenian_ci\" title=\"Esloveno, independiente de mayúsculas y minúsculas\">utf16_slovenian_ci</option>
                                <option value=\"utf16_spanish2_ci\" title=\"Español (tradicional), independiente de mayúsculas y minúsculas\">utf16_spanish2_ci</option>
                                <option value=\"utf16_spanish_ci\" title=\"Español (moderno), independiente de mayúsculas y minúsculas\">utf16_spanish_ci</option>
                                <option value=\"utf16_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">utf16_swedish_ci</option>
                                <option value=\"utf16_turkish_ci\" title=\"Turco, independiente de mayúsculas y minúsculas\">utf16_turkish_ci</option>
                                <option value=\"utf16_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">utf16_unicode_520_ci</option>
                                <option value=\"utf16_unicode_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf16_unicode_ci</option>
                                <option value=\"utf16_vietnamese_ci\" title=\"Vietnamita, independiente de mayúsculas y minúsculas\">utf16_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label=\"utf16le\" title=\"UTF-16LE Unicode\">
                                <option value=\"utf16le_bin\" title=\"Unicode, binario\">utf16le_bin</option>
                                <option value=\"utf16le_general_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf16le_general_ci</option>
                            </optgroup>
                            <optgroup label=\"utf32\" title=\"UTF-32 Unicode\">
                                <option value=\"utf32_bin\" title=\"Unicode, binario\">utf32_bin</option>
                                <option value=\"utf32_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">utf32_croatian_ci</option>
                                <option value=\"utf32_czech_ci\" title=\"Checo, independiente de mayúsculas y minúsculas\">utf32_czech_ci</option>
                                <option value=\"utf32_danish_ci\" title=\"Danés, independiente de mayúsculas y minúsculas\">utf32_danish_ci</option>
                                <option value=\"utf32_esperanto_ci\" title=\"Esperanto, independiente de mayúsculas y minúsculas\">utf32_esperanto_ci</option>
                                <option value=\"utf32_estonian_ci\" title=\"Estonio, independiente de mayúsculas y minúsculas\">utf32_estonian_ci</option>
                                <option value=\"utf32_general_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf32_general_ci</option>
                                <option value=\"utf32_german2_ci\" title=\"Alemán (ordenado según libreta telefónica), independiente de mayúsculas y minúsculas\">utf32_german2_ci</option>
                                <option value=\"utf32_hungarian_ci\" title=\"Húngaro, independiente de mayúsculas y minúsculas\">utf32_hungarian_ci</option>
                                <option value=\"utf32_icelandic_ci\" title=\"Islandés, independiente de mayúsculas y minúsculas\">utf32_icelandic_ci</option>
                                <option value=\"utf32_latvian_ci\" title=\"Letón, independiente de mayúsculas y minúsculas\">utf32_latvian_ci</option>
                                <option value=\"utf32_lithuanian_ci\" title=\"Lituano, independiente de mayúsculas y minúsculas\">utf32_lithuanian_ci</option>
                                <option value=\"utf32_persian_ci\" title=\"Persa, independiente de mayúsculas y minúsculas\">utf32_persian_ci</option>
                                <option value=\"utf32_polish_ci\" title=\"Polaco, independiente de mayúsculas y minúsculas\">utf32_polish_ci</option>
                                <option value=\"utf32_roman_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">utf32_roman_ci</option>
                                <option value=\"utf32_romanian_ci\" title=\"Rumano, independiente de mayúsculas y minúsculas\">utf32_romanian_ci</option>
                                <option value=\"utf32_sinhala_ci\" title=\"Singalés, independiente de mayúsculas y minúsculas\">utf32_sinhala_ci</option>
                                <option value=\"utf32_slovak_ci\" title=\"Eslovaco, independiente de mayúsculas y minúsculas\">utf32_slovak_ci</option>
                                <option value=\"utf32_slovenian_ci\" title=\"Esloveno, independiente de mayúsculas y minúsculas\">utf32_slovenian_ci</option>
                                <option value=\"utf32_spanish2_ci\" title=\"Español (tradicional), independiente de mayúsculas y minúsculas\">utf32_spanish2_ci</option>
                                <option value=\"utf32_spanish_ci\" title=\"Español (moderno), independiente de mayúsculas y minúsculas\">utf32_spanish_ci</option>
                                <option value=\"utf32_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">utf32_swedish_ci</option>
                                <option value=\"utf32_turkish_ci\" title=\"Turco, independiente de mayúsculas y minúsculas\">utf32_turkish_ci</option>
                                <option value=\"utf32_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">utf32_unicode_520_ci</option>
                                <option value=\"utf32_unicode_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf32_unicode_ci</option>
                                <option value=\"utf32_vietnamese_ci\" title=\"Vietnamita, independiente de mayúsculas y minúsculas\">utf32_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label=\"utf8\" title=\"UTF-8 Unicode\">
                                <option value=\"utf8_bin\" title=\"Unicode, binario\">utf8_bin</option>
                                <option value=\"utf8_croatian_ci\" title=\"Croata, independiente de mayúsculas y minúsculas\">utf8_croatian_ci</option>
                                <option value=\"utf8_czech_ci\" title=\"Checo, independiente de mayúsculas y minúsculas\">utf8_czech_ci</option>
                                <option value=\"utf8_danish_ci\" title=\"Danés, independiente de mayúsculas y minúsculas\">utf8_danish_ci</option>
                                <option value=\"utf8_esperanto_ci\" title=\"Esperanto, independiente de mayúsculas y minúsculas\">utf8_esperanto_ci</option>
                                <option value=\"utf8_estonian_ci\" title=\"Estonio, independiente de mayúsculas y minúsculas\">utf8_estonian_ci</option>
                                <option value=\"utf8_general_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf8_general_ci</option>
                                <option value=\"utf8_general_mysql500_ci\" title=\"Unicode (MySQL 5.0.0), independiente de mayúsculas y minúsculas\">utf8_general_mysql500_ci</option>
                                <option value=\"utf8_german2_ci\" title=\"Alemán (ordenado según libreta telefónica), independiente de mayúsculas y minúsculas\">utf8_german2_ci</option>
                                <option value=\"utf8_hungarian_ci\" title=\"Húngaro, independiente de mayúsculas y minúsculas\">utf8_hungarian_ci</option>
                                <option value=\"utf8_icelandic_ci\" title=\"Islandés, independiente de mayúsculas y minúsculas\">utf8_icelandic_ci</option>
                                <option value=\"utf8_latvian_ci\" title=\"Letón, independiente de mayúsculas y minúsculas\">utf8_latvian_ci</option>
                                <option value=\"utf8_lithuanian_ci\" title=\"Lituano, independiente de mayúsculas y minúsculas\">utf8_lithuanian_ci</option>
                                <option value=\"utf8_persian_ci\" title=\"Persa, independiente de mayúsculas y minúsculas\">utf8_persian_ci</option>
                                <option value=\"utf8_polish_ci\" title=\"Polaco, independiente de mayúsculas y minúsculas\">utf8_polish_ci</option>
                                <option value=\"utf8_roman_ci\" title=\"Europea occidental, independiente de mayúsculas y minúsculas\">utf8_roman_ci</option>
                                <option value=\"utf8_romanian_ci\" title=\"Rumano, independiente de mayúsculas y minúsculas\">utf8_romanian_ci</option>
                                <option value=\"utf8_sinhala_ci\" title=\"Singalés, independiente de mayúsculas y minúsculas\">utf8_sinhala_ci</option>
                                <option value=\"utf8_slovak_ci\" title=\"Eslovaco, independiente de mayúsculas y minúsculas\">utf8_slovak_ci</option>
                                <option value=\"utf8_slovenian_ci\" title=\"Esloveno, independiente de mayúsculas y minúsculas\">utf8_slovenian_ci</option>
                                <option value=\"utf8_spanish2_ci\" title=\"Español (tradicional), independiente de mayúsculas y minúsculas\" selected=\"selected\">utf8_spanish2_ci</option>
                                <option value=\"utf8_spanish_ci\" title=\"Español (moderno), independiente de mayúsculas y minúsculas\">utf8_spanish_ci</option>
                                <option value=\"utf8_swedish_ci\" title=\"Sueco, independiente de mayúsculas y minúsculas\">utf8_swedish_ci</option>
                                <option value=\"utf8_turkish_ci\" title=\"Turco, independiente de mayúsculas y minúsculas\">utf8_turkish_ci</option>
                                <option value=\"utf8_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">utf8_unicode_520_ci</option>
                                <option value=\"utf8_unicode_ci\" title=\"Unicode, independiente de mayúsculas y minúsculas\">utf8_unicode_ci</option>
                                <option value=\"utf8_vietnamese_ci\" title=\"Vietnamita, independiente de mayúsculas y minúsculas\">utf8_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label=\"utf8mb4\" title=\"UTF-8 Unicode\">
                                <option value=\"utf8mb4_bin\" title=\"Unicode (UCA 4.0.0), binario\">utf8mb4_bin</option>
                                <option value=\"utf8mb4_croatian_ci\" title=\"Croata (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_croatian_ci</option>
                                <option value=\"utf8mb4_czech_ci\" title=\"Checo (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_czech_ci</option>
                                <option value=\"utf8mb4_danish_ci\" title=\"Danés (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_danish_ci</option>
                                <option value=\"utf8mb4_esperanto_ci\" title=\"Esperanto (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_esperanto_ci</option>
                                <option value=\"utf8mb4_estonian_ci\" title=\"Estonio (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_estonian_ci</option>
                                <option value=\"utf8mb4_general_ci\" title=\"Unicode (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_general_ci</option>
                                <option value=\"utf8mb4_german2_ci\" title=\"Alemán (ordenado según libreta telefónica) (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_german2_ci</option>
                                <option value=\"utf8mb4_hungarian_ci\" title=\"Húngaro (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_hungarian_ci</option>
                                <option value=\"utf8mb4_icelandic_ci\" title=\"Islandés (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_icelandic_ci</option>
                                <option value=\"utf8mb4_latvian_ci\" title=\"Letón (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_latvian_ci</option>
                                <option value=\"utf8mb4_lithuanian_ci\" title=\"Lituano (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_lithuanian_ci</option>
                                <option value=\"utf8mb4_persian_ci\" title=\"Persa (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_persian_ci</option>
                                <option value=\"utf8mb4_polish_ci\" title=\"Polaco (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_polish_ci</option>
                                <option value=\"utf8mb4_roman_ci\" title=\"Europea occidental (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_roman_ci</option>
                                <option value=\"utf8mb4_romanian_ci\" title=\"Rumano (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_romanian_ci</option>
                                <option value=\"utf8mb4_sinhala_ci\" title=\"Singalés (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_sinhala_ci</option>
                                <option value=\"utf8mb4_slovak_ci\" title=\"Eslovaco (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_slovak_ci</option>
                                <option value=\"utf8mb4_slovenian_ci\" title=\"Esloveno (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_slovenian_ci</option>
                                <option value=\"utf8mb4_spanish2_ci\" title=\"Español (tradicional) (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_spanish2_ci</option>
                                <option value=\"utf8mb4_spanish_ci\" title=\"Español (moderno) (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_spanish_ci</option>
                                <option value=\"utf8mb4_swedish_ci\" title=\"Sueco (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_swedish_ci</option>
                                <option value=\"utf8mb4_turkish_ci\" title=\"Turco (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_turkish_ci</option>
                                <option value=\"utf8mb4_unicode_520_ci\" title=\"Unicode (UCA 5.2.0), independiente de mayúsculas y minúsculas\">utf8mb4_unicode_520_ci</option>
                                <option value=\"utf8mb4_unicode_ci\" title=\"Unicode (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_unicode_ci</option>
                                <option value=\"utf8mb4_vietnamese_ci\" title=\"Vietnamita (UCA 4.0.0), independiente de mayúsculas y minúsculas\">utf8mb4_vietnamese_ci</option>
                            </optgroup>
                        </select><?php echo \"\n\"; ?>";
}

/*
function vtbllista(){
    $bd=$_SESSION['bdselected'];
    mysqli_select_db(conexion(),$bd);
    $query="SHOW FULL TABLES FROM $bd;";
    if(mysqli_query(conexion(),$query)){
        $almacen=mysqli_query(conexion(),$query);
        $name=0;
        $i=0;
        $flag=true;
        if(mysqli_num_rows($almacen)!=0){
            mysqli_num_rows($almacen)/10;
            echo "<div class=\"col-sm-12";
            echo "id=\"pag\">";
            echo "<ul class=\"pagination\">";
            for($j=0;$j<=mysqli_num_rows($almacen)/10;$j++){
                echo "<li";
                if($j==0){
                    echo " class=\"active\"";
                }
                echo "><a href=\"#\" class=\"pag\" id=\"$j\">$j</a></li>";
            }
            echo "</ul>";
            echo "</div>";
            while($cursor=mysqli_fetch_array($almacen)){
                if($i==10){
                    $name++;
                    $i=0;
                }
                if($i==0 && $flag==false){
                    echo "</table>
                    </div>";
                    $flag=true;
                }
                if($i==0 && $flag==true){
                    echo "<div class=\"col-sm-12 pag";
                    if($name!=0){
                        echo " hide";
                    }
                    echo "\" id=\"$name\">
                    <table class=\"table table-condensed banner\">
                        <tr>
                            <th style=\"font-size:17px; width:70%;\">Tablas en ".strtoupper($_SESSION['bdselected'])."</th>
                            <th style=\"font-size:17px;\">Tipo de tabla</th>
                        </tr>";
                    $flag=false;
                }
                echo "<tr>
                            <td style=\"color:white;\"><strong>".$cursor[0]."</strong></td>
                            <td style=\"color:white;\"><strong>".$cursor[1]."</strong></td>
                        </tr>";
                $i++;
            }
            if(mysqli_num_rows($almacen)%10!=0)
            echo "</table></div>";
            echo "\n";
        }
        else{
            echo "</div>
                <div class=\"alert alert-danger\" id=\"notablas\">No existen tablas en esta base de datos</div>";
        }
        $_SESSION['bd']=$name;
    }
}*/

/**
 * <strong>Función <i>vbdlista2()</i></strong>
 * 
 * Con esta función pedimos al servidor que muestre todas las tablas de la base de datos seleccionada y que el usuario
 * puede ver con sus credenciales. Una vez recogidas, creamos una tabla y mostramos cada una de ellas.
 * 
 * @author Eugenio Perojil
 */
function vtbllista2(){
    $bd     = $_SESSION['bdselected'];
    mysqli_select_db(conexion(),$bd);
    $query  = "SHOW FULL TABLES FROM $bd;";
    if(mysqli_query(conexion(),$query)){
        $almacen=mysqli_query(conexion(),$query);
        echo "<div class='col-sm-12 vtbldiv' id='vtbldiv'>";
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th style='width:70px;'>Borrar</th>";
        echo "<th style='width=70%;'>Tablas en ".strtoupper($_SESSION['bdselected'])."</th>";
        echo "<th>Tipo de tabla</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "<th style='width:70px;'>Borrar</th>";
        echo "<th style='width=70%;'>Tablas en ".strtoupper($_SESSION['bdselected'])."</th>";
        echo "<th>Tipo de tabla</th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "<tbody>";
        $j = 0;
        while($cursor=mysqli_fetch_array($almacen)){
            echo "<tr>";
            echo "<td><input type='checkbox' class='checkbox' name='".$j."' /></td>";
            echo "<td><a href='dtbl.php?tbl=".$cursor[0]."' name='".$j."'><strong>".$cursor[0]."</strong></a></td>";
            echo "<td><strong>".$cursor[1]."</strong></td>";
            echo "</tr>";
            $j++;
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}

function motor(){
    echo '<select class="form-control selectpicker show-menu-arrow" data-live-search="true" name="motor" id="motor">';
    echo '  <option>ARCHIVE</option>';
    echo '  <option>BLACKHOLE</option>';
    echo '  <option>CSV</option>';
    echo '  <option selected>InnoDB</option>';
    echo '  <option>MEMORY</option>';
    echo '  <option>MRG_MYISAM</option>';
    echo '  <option>MyISAM</option>';
    echo '</select>';
}

function tipo($i){
    echo '<select class="form-control" name="tipotbl'.$i.'" id="tipotbl'.$i.'">';
    echo '  <option title="Un entero de 4 bytes; el rango con signo es de 2147483648 a 2147483647, el rango sin signo es de 0 a 4294967295">INT</option>';
    echo '  <option title="Una cadena de longitud variable (0-65,535), la longitud máxima está asociada al tamaño máximo de un registro" selected>VARCHAR</option>';
    echo '  <option title="Una columna de texto con una longitud máxima de 65535 (2^16 - 1) caracteres, almacenado con un prefijo de 2 bytes que indica la longitud del valor en bytes">TEXT</option>';
    echo '  <option title="Una fecha, el rango válido es de «1000-01-01» a «9999-12-31»">DATE</option>';
    echo '  <optgroup label="Numérico">';
    echo '      <option title="Un entero de 1 byte; el rango con signo es de -128 a 127, el rango sin signo es de 0 a 255">TINYINT</option>';
    echo '      <option title="Un entero de 2 bytes; el rango con signo es de -32768 a 32767, el rango sin signo es de 0 a 65535">SMALLINT</option>';
    echo '      <option title="Un entero de 3 bytes; el rango con signo es de -8388608 a 8388607, el rango sin signo es de 0 a 16777215">MEDIUMINT</option>';
    echo '      <option title="Un entero de 4 bytes; el rango con signo es de 2147483648 a 2147483647, el rango sin signo es de 0 a 4294967295">INT</option>';
    echo '      <option title="En entero de 8 bytes; el rango con signo es de -9223372036854775808 a 9223372036854775807, el rango sin signo es de 0 a 18446744073709551615">BIGINT</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Un número decimal fijo (M, D) - la mayor cantidad de dígitos (M) es 65 (valor predeterminado de 10), el mayor número posible de decimales (D) es 30 (valor predeterminado de 0)">DECIMAL</option>';
    echo '      <option title="Un número de coma flotante pequeño; los valores posibles son de -3.402823466E+38 a -1.175494351E-38, 0 y de 1.175494351E-38 a 3.402823466E+38">FLOAT</option>';
    echo '      <option title="Un número de coma flotante de precisión doble; los valores permitidos son de -1.7976931348623157E+308 a -2.2250738585072014E-308, 0 y de 2.2250738585072014E-308 a 1.7976931348623157E+308">DOUBLE</option>';
    echo '      <option title="Sinónimo de DOUBLE (excepción: si el modo SQL «REAL_AS_FLOAT» está activo es sinónimo de FLOAT)">REAL</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Una máscara de bits (M), almacenando M bits por valor (valor predeterminado de 1, máximo de 64)">BIT</option>';
    echo '      <option title="Sinónimo de TINYINT(1), un valor de cero es considerado falso, cualquier valor distinto de cero es considerado verdadero">BOOLEAN</option>';
    echo '      <option title="Un sinónimo de BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE">SERIAL</option>';
    echo '  </optgroup>';
    echo '  <optgroup label="Fecha y marca temporal">';
    echo '      <option title="Una fecha, el rango válido es de «1000-01-01» a «9999-12-31»">DATE</option>';
    echo '      <option title="Una combinación de fecha y marca temporal, el rango válido es de «1000-01-01 00:00:00» a «9999-12-31 23:59:59»">DATETIME</option>';
    echo '      <option title="Una marca temporal; el rango es de «01-Ene-1970 00:00:01» UTC a «09-Ene-2038 03:14:07» UTC almacenados como la cantidad de segundos desde el «epoch» («01-Ene-1970 00:00:00» UTC)">TIMESTAMP</option>';
    echo '      <option title="Una marca temporal, el rango es de «-838:59:59» a «838:59:59»">TIME</option>';
    echo '      <option title="Un año en formato de cuatro dígitos (4, el valor predeterminado) o dos dígitos (2); los valores posibles son de 70 (1970) a 69 (2069) ó de 1901 a 2155 y 0000">YEAR</option>';
    echo '  </optgroup>';
    echo '  <optgroup label="Cadena">';
    echo '      <option title="Una cadena de longitud fija (de 0 a 255, valor predeterminado de 1) que es siempre completada a la derecha con espacios hasta la longitud especificada al ser almacenada">CHAR</option>';
    echo '      <option title="Una cadena de longitud variable (0-65,535), la longitud máxima está asociada al tamaño máximo de un registro">VARCHAR</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Una columna de texto con una longitud máxima de 255 (2^8 - 1) caracteres, almacenado con un prefijo de 1 byte que indica la longitud del valor en bytes">TINYTEXT</option>';
    echo '      <option title="Una columna de texto con una longitud máxima de 65535 (2^16 - 1) caracteres, almacenado con un prefijo de 2 bytes que indica la longitud del valor en bytes">TEXT</option>';
    echo '      <option title="Una columna de texto con una longitud máxima de 16777215 (2^24 - 1) caracteres, almacenado con un prefijo de 3 bytes que indica la longitud del valor en bytes">MEDIUMTEXT</option>';
    echo '      <option title="Una columna de texto con una longitud máxima de 4294967295 ó 4Gb (2^32 - 1) caracteres, almacenado con un prefijo de 4 bytes que indica la longitud del valor en bytes">LONGTEXT</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Similar al tipo CHAR, pero almacena cadenas binarias de bytes en lugar de cadenas de caracteres no binarios">BINARY</option>';
    echo '      <option title="Similar al tipo VARCHAR, pero almacena cadenas binarias de bytes en lugar de cadenas de caracteres no binarios">VARBINARY</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 255 (2^8 - 1) bytes. Cada valor TINYBLOB es almacenado con un prefijo de 1 byte que indica la cantidad de bytes en el valor">TINYBLOB</option>';
    echo '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 16777215 (2^24 - 1) bytes, almacenado con un prefijo de 3 bytes que indica la longitud del valor">MEDIUMBLOB</option>';
    echo '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 65535 (2^16 - 1) bytes, almacenado con un prefijo de 2 bytes que indica la longitud del valor">BLOB</option>';
    echo '      <option title="Una columna de bloque de texto («BLOB») con una longitud máxima de 4294967295 (2^32 - 1) bytes (4GB), almacenado con un prefijo de 4 bytes que indica la longitud del valor">LONGBLOB</option>';
    echo '      <option disabled="disabled">-</option>';
    echo '      <option title="Una enumeración, elegida de una lista de hasta 65535 valores o el valor especial de error">ENUM</option>';
    echo '      <option title="Un único valor elegido de un conjunto de hasta 64 elementos">SET</option>';
    echo '  </optgroup>';
    echo '  <optgroup label="Espacial">';
    echo '      <option title="Un tipo que puede almacenar una geometría de cualquier tipo">GEOMETRY</option>';
    echo '      <option title="Un punto en espacio de dos dimensiones">POINT</option>';
    echo '      <option title="Una curva con interpolación lineal entre puntos">LINESTRING</option>';
    echo '      <option title="Un polígono">POLYGON</option>';
    echo '      <option title="Una colección de puntos">MULTIPOINT</option>';
    echo '      <option title="Una colección de curvas con interpolación lineal entre puntos">MULTILINESTRING</option>';
    echo '      <option title="Una colección de polígonos">MULTIPOLYGON</option>';
    echo '      <option title="Una colección de objetos geométricos de cualquier tipo">GEOMETRYCOLLECTION</option>';
    echo '  </optgroup>';
    echo '  <optgroup label="JSON">';
    echo '      <option title="Almacena y permite el acceso eficiente a datos en documentos JSON (JavaScript Object Notation)">JSON</option>';
    echo '  </optgroup>';
    echo '</select>';
}

function ntbllanza(){
    // Recogida de valores de la tabla
    $bd                 = $_SESSION['bdselected'];
    if(isset($_POST['nombretbl']))
        $nomtbl         = $_POST['nombretbl'];
    if(isset($_POST['cotejamiento']))
        $cote           = $_POST['cotejamiento'];
    if(isset($_POST['motor']))
        $motor          = $_POST['motor'];

    $sql                = 'CREATE TABLE `'.$bd.'`.`'.$nomtbl.'` (';
    // Recogida de valores de los registros
    $contreg            = $_POST['contreg'];

    // Contenedores
    $coltbl             = array();
    $coltblok           = 0;
    $tipotbl            = array();
    $tipotblok          = 0;
    $pk                 = array();
    $nn                 = array();
    $uq                 = array();
    $bi                 = array();
    $un                 = array();
    $zf                 = array();
    $ai                 = array();
    $gc                 = array();
    $lontbl             = array();
    $i                  = 0;
    while ($i <= $contreg-1) {
        if(isset($_POST['coltbl'.$i])){
            $coltbl[]   = $_POST['coltbl'.$i];
            $coltblok++;
            $sql       .= '`'.$coltbl[$i].'` ';
        }

        if(isset($_POST['tipotbl'.$i])){
            $tipotbl[]  = $_POST['tipotbl'.$i];
            $tipotblok++;
            $sql       .= $tipotbl[$i];
        }

        if(isset($_POST['lontbl'.$i]) && $_POST['lontbl'.$i] != ''){
            $lontbl[]   = $_POST['lontbl'.$i];
            $sql       .= '('.$lontbl[$i].') ';
        }
        else{
            $lontbl[]   = '10';
            $sql       .= '(10) ';
        }

        if(isset($_POST['bi'.$i])){
            $bi[]       = $_POST['bi'.$i];
            $sql       .= 'BINARY ';
        }
        else
            $bi[]       = '';

        if(isset($_POST['un'.$i])){
            $un[]       = $_POST['un'.$i];
            $sql       .= 'UNSIGNED ';
        }
        else
            $un[]       = '';

        if(isset($_POST['zf'.$i])){
            $zf[]       = $_POST['zf'.$i];
            $sql       .= 'ZEROFILL ';
        }
        else
            $zf[]       = '';

        if(isset($_POST['pk'.$i])){
            $pk[]       = $_POST['pk'.$i];
            $sql       .= 'PRIMARY KEY ';
        }
        else
            $pk[]       = '';

        if(isset($_POST['nn'.$i])){
            $nn[]       = $_POST['nn'.$i];
            $sql       .= 'NOT NULL ';
        }
        else
            $nn[]       = '';

        if(isset($_POST['ai'.$i])){
            $ai[]       = $_POST['ai'.$i];
            $sql       .= 'AUTO_INCREMENT ';
        }
        else
            $ai[]       = '';

        /*if(isset($_POST['uq'.$i])){
            $uq[]       = $_POST['uq'.$i];
        }
        else
            $uq[]       = '';

        if(isset($_POST['gc'.$i])){
            $gc[]       = $_POST['gc'.$i];
        }
        else
            $gc[]       = '';*/

        if($i!=$contreg-1) $sql  .= ', ';
        else $sql              .= ') ENGINE = '.$motor.' COLLATE '.$cote.';';

        $i++;
    }
    //echo $sql;
    mysqli_select_db(conexion(),$bd);

    if($consulta = mysqli_query(conexion(),$sql))
        $_SESSION['query'] = true;
    else{
        $_SESSION['query'] = false;
    }
    mysqli_close();
    header('location:ntbl.php');
}
function ntblquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="ntblquerytrue">Tabla creada con éxito</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="ntblqueryfalse">Tabla imposible de crear</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
        elseif ($_SESSION['query'] === 'rep') {
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="ntblqueryfalse">Ya existe una tabla con ese nombre</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

function dtbllista($bd,$tbl){
    dtbllista1($bd,$tbl);
    dtbllista2($bd,$tbl);
    dtbllista3($bd,$tbl);
}

function dtbllista1($bd,$tbl){
    $sql        = "SHOW TABLE STATUS FROM ".$bd." WHERE name = '".$tbl."'";
    //echo $sql;
    //$sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
    mysqli_select_db(conexion(),$bd);
    $consulta   = mysqli_query(conexion(),$sql);
    /*for($i = 0; $i < $num; $i++)
        $nombre[] = mysql_field_name($consulta, $i);*/
    //while ($property = mysqli_fetch_field($consulta)) {
    //    $nombre[] = $property->name;
    //}
    $fila       = mysqli_fetch_array($consulta);

    if(mysqli_query(conexion(),$sql)){
        $consulta = mysqli_query(conexion(),$sql);
        $posiciones = array(0,1,3,6,10,11,12,14,17);
        $nombre     = array('Nombre','Motor','Formato','Tamaño (bytes)','Valor de autoincremento','Fecha de creación','Fecha de actualización','Cotejamiento','Comentario');
        echo "<div class='col-sm-12 dtbldiv2' id='dtbldiv2'>";
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable'>";
        echo "<thead>";
        echo "<tr>";
        for($i = 0; $i < count($posiciones); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tfoot>";
        echo "<tr>";
        for($i = 0; $i < count($posiciones); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</tfoot>";

        echo "<tbody>";

        $fila = mysqli_fetch_array($consulta);
        echo "<tr>";
        for($i = 0; $i < count($posiciones); $i++)
            echo "<td title='".$fila[$posiciones[$i]]."'>".$fila[$posiciones[$i]]."</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    //show table status where name = "tablaprueba3"
}

function dtbllista2($bd,$tbl){
    $sql        = "show full columns from `".$bd."`.`".$tbl."`";
    //$sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
    mysqli_select_db(conexion(),$bd);
    $consulta   = mysqli_query(conexion(),$sql);
    /*for($i = 0; $i < $num; $i++)
        $nombre[] = mysql_field_name($consulta, $i);*/
    //while ($property = mysqli_fetch_field($consulta)) {
    //    $nombre[] = $property->name;
    //}
    $fila       = mysqli_fetch_array($consulta);

    if(mysqli_query(conexion(),$sql)){
        $consulta   = mysqli_query(conexion(),$sql);
        $nombre     = array('Campo','Tipo','Cotejamiento','Nulo','Clave','Por defecto','Extras','Comentario','Privilegios');
        echo "<div class='col-sm-12'>";
        echo "<h3>Descripción</h3>";
        echo "</div>";
        echo "<div class='col-sm-12 dtbldiv2' id='dtbldiv2'>";
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable'>";
        echo "<thead>";
        echo "<tr>";
        for($i = 0; $i < count($nombre); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tfoot>";
        echo "<tr>";
        for($i = 0; $i < count($nombre); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</tfoot>";

        echo "<tbody>";
        unset($_SESSION['cabecera']);
        while($fila = mysqli_fetch_array($consulta)){
            $_SESSION['cabecera'][] = $fila[0];
            echo "<tr>";
            echo "<td><b>".$fila[0]."</b></td>";
            echo "<td>".strtoupper($fila[1])."</td>";
            echo "<td>";
            if($fila[2] == '') echo "no";
            else echo $fila[2];
            echo "</td>";
            echo "<td>";
            if($fila[3] == 'YES') echo "sí";
            else echo "no";
            echo "</td>";
            echo "<td>";
            if($fila[4] == 'PRI') echo "PRIMARIA";
            elseif($fila[4] == '') echo "no";
            else echo $fila[4];
            echo "</td>";
            echo "<td>";
            if($fila[5] == '') echo "null";
            else echo $fila[5];
            echo "</td>";
            echo "<td>";
            if($fila[6] == '') echo "no";
            else echo $fila[6];
            echo "</td>";
            echo "<td>".$fila[8]."</td>";
            echo "<td>".$fila[7]."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    //show table status where name = "tablaprueba3"
    //show full fields from tablaprueba3
}

function dtbllista3($bd,$tbl,$reg=''){
    $sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
    if($consulta   = mysqli_query(conexion(),$sql)){
        $nombre = dame_cabecera($consulta);
        if(count($nombre) != 0){
            if($reg == ''){
                echo "<div class='col-sm-12'>";
                echo "<h3>Registros</h3>";
                echo "</div>";

                echo "<div class='col-sm-12 dtbldiv3' id='dtbldiv3'>";
            }
            echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable muestraregistros'>";
            echo "<thead>";
            echo "<tr>";
            if($reg == ''){
                echo "<th>";
                echo "Borrar";
                echo "</th>";
            }

            for($i = 0; $i < count($nombre); $i++)
                echo "<th>".$nombre[$i]."</th>";
            echo "</tr>";
            echo "</thead>";

            echo "<tfoot>";
            echo "<tr>";

            if($reg == ''){
                echo "<th>";
                echo "Borrar";
                echo "</th>";
            }

            for($i = 0; $i < count($nombre); $i++)
                echo "<th>".$nombre[$i]."</th>";
            echo "</tr>";
            echo "</tfoot>";

            echo "<tbody>";
            mysqli_data_seek($consulta,0);

            if($reg != ''){
                $nulo   = dame_nulos($bd,$tbl);
                $tipo   = dame_tipo_columna($bd,$tbl);
                $extra  = dame_extra($bd,$tbl);
            }

            $j = 0;
            while ($fila = mysqli_fetch_array($consulta)) {
                echo "<tr>";

                if($reg == ''){
                    echo "<td style='width:70px;'>";
                    echo "<input type='checkbox' class='checkbox' name='".$j."'/>";
                    echo "</td>";
                    $j++;
                }


                for($i = 0; $i < count($nombre); $i++){
                    if($reg == '')
                        echo "<td title='".$fila[$i]."'>".$fila[$i]."</td>";
                    else{
                        if($extra[$i] == 'auto_increment')
                            echo "<td title='".$fila[$i]."'><input type='text' id='".$fila[$i]."' name='".$reg."' value='".$fila[$i]."' class='hide'/>".$fila[$i]."</td>";
                        else{
                            echo "<td title='".$fila[$i]."'><span class='hide'>".$fila[$i]."</span><input type='text' id='".$fila[$i]."' name='".$reg."' value='".$fila[$i]."' style='width:100%;' ";
                            if($nulo[$i] == 'YES') echo "required ";
                            $longitud = substr($tipo[$i], strpos($tipo[$i], "(")+1,-1);
                            echo "maxlength='".$longitud."' ";
                            echo "/></td>";
                        }
                        $reg++;
                    }
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            if($reg == ''){
                echo "</div>";
            }
        }
    }
}

function dame_cabecera($consulta){
    $helper     = mysqli_fetch_array($consulta);
    //mysqli_data_seek($consulta,0);
    $nombre     = array();
    if($helper != ''){
        $i          = 0;
        //print_r($nombre);
        foreach ($helper as $name => $valor) {
            if($i % 2 != 0)
                $nombre[] = $name;
            $i++;
        }
        //print_r($nombre);
    }
    else return $_SESSION['cabecera'];
    return $nombre;
}

function dame_tipo_columna($bd,$tbl){
    $sql            = "show full columns from `".$bd."`.`".$tbl."`";
    $tipo           = array();
    if($consulta    = mysqli_query(conexion(),$sql)){
        while ($fila = mysqli_fetch_array($consulta)) {
            $tipo[] = $fila[1];
        }
        //print_r($tipo);
    }
    return $tipo;
}

function dame_nulos($bd,$tbl){
    $sql            = "show full columns from `".$bd."`.`".$tbl."`";
    $nulo           = array();
    if($consulta    = mysqli_query(conexion(),$sql)){
        while ($fila = mysqli_fetch_array($consulta)) {
            $nulo[] = $fila[3];
        }
        //print_r($tipo);
    }
    return $nulo;
}
function dame_extra($bd,$tbl){
    $sql            = "show full columns from `".$bd."`.`".$tbl."`";
    $extra          = array();
    if($consulta    = mysqli_query(conexion(),$sql)){
        while ($fila = mysqli_fetch_array($consulta)) {
            $extra[] = $fila[6];
        }
        //print_r($tipo);
    }
    return $extra;
}


function nuevo_registro($bd,$tbl,$reg=''){
    $sql = "SELECT * FROM `".$bd."`.`".$tbl."`";
    if($consulta = mysqli_query(conexion(),$sql)){
        $nombre                     = dame_cabecera($consulta);
        $nulo                       = dame_nulos($bd,$tbl);
        $tipo                       = dame_tipo_columna($bd,$tbl);
        $extra                      = dame_extra($bd,$tbl);
        $_SESSION['nuevo_registro'] = array();

        echo "<div class='row'>";
        $j = 0;
        for($i = 0; $i < count($nombre); $i++){
            if($extra[$i] != 'auto_increment'){
                echo "<div class='col-sm-12' style='margin-bottom:10px;'>";
                echo "<div class='input-group'>";
                if($reg == ''){
                    echo "<span class='input-group-addon'><label for='".$nombre[$i]."'>".$nombre[$i]."</label></span>";
                    echo "<input type='text' class='form-control' id='".$nombre[$i]."' name='".$nombre[$i]."' ";
                }
                else{
                    echo "<span class='input-group-addon'><label for='".$nombre[$i].$reg."'>".$nombre[$i].$reg."</label></span>";
                    echo "<input type='text' class='form-control' id='".$nombre[$i].$reg."' name='".$nombre[$i].$reg."' ";
                }
                if($nulo[$i] == 'YES') echo "required ";
                $longitud = substr($tipo[$i], strpos($tipo[$i], "(")+1,-1);
                echo "maxlength='".$longitud."'";
                echo ">";
                echo "<br>";
                echo "</div>";
                echo "</div>";
                $_SESSION['nuevo_registro'][] = $nombre[$i];
                $_SESSION['dtblnum'] = $i;
            }
        }
        // var_dump($_SESSION['dtblnum']);
        // var_dump($_SESSION['nuevo_registro']);
        echo "</div>";

        echo "<div class='row'>";
        echo "<div class='col-sm-12' style='margin-top:10px;'>";
        echo "<p>";
        if($reg == ''){
            echo "<b><span style='color:purple'>INSERT INTO</span> <span style='color:blue'>`".$bd."`</span>.<span style='color:blue'>`".$tbl."`</span> <span style='color:purple'>(</span>";
            echo "<span style='color:green;'>";
            for($i = 0; $i < count($_SESSION['nuevo_registro']); $i++){
                echo $_SESSION['nuevo_registro'][$i];
                if($i != count($_SESSION['nuevo_registro'])-1)
                    echo ", ";
            }
            echo "</span>";
            echo "<span style='color:purple'>) VALUES (</span>";
            echo "<span style='color:green;'>";
            for($i = 0; $i < count($_SESSION['nuevo_registro']); $i++){
                echo "<span id='".$_SESSION['nuevo_registro'][$i]."'>NULL</span>";
                if($i != count($_SESSION['nuevo_registro'])-1)
                    echo ", ";
            }
            echo "</span>";
            echo "<span style='color:purple'>)</span>;</b>";
        }
        echo "</p>";
        echo "</div>";
        echo "</div>";
    }
}

function dtbllanza(){
    $bd         = $_SESSION['bdselected'];
    if(!isset($_POST['checkeados']) && !isset($_POST['modificados'])){
        if(isset($_SESSION['tbl'])){
            $tbl            = $_SESSION['tbl'];
            $sql            = 'INSERT INTO `'.$bd.'`.`'.$tbl.'` (';
            for($i = 0; $i < count($_SESSION['nuevo_registro']); $i++){
                $sql       .= '`'.$_SESSION['nuevo_registro'][$i].'`';
                if($i != count($_SESSION['nuevo_registro'])-1)
                    $sql   .= ", ";
            }
            $sql           .= ') VALUES (';
            for($i = 0; $i < count($_SESSION['nuevo_registro']); $i++){
                $sql       .= '"'.$_POST[$_SESSION['nuevo_registro'][$i]].'"';
                if($i != count($_SESSION['nuevo_registro'])-1)
                    $sql   .= ", ";
            }
            $sql           .= ");";
            //echo $sql;
            if($consulta       = mysqli_query(conexion(),$sql))
                $_SESSION['query'] = true;
            else
                $_SESSION['query'] = false;
        }
        else{
            $_SESSION['query'] = false;
        }
    }
    elseif(isset($_POST['checkeados'])){
        if(isset($_SESSION['tbl'])){
            $tbl        = $_SESSION['tbl'];

            $sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
            $consulta   = mysqli_query(conexion(),$sql);
            $cabecera   = dame_cabecera($consulta);
            $checkeados = explode(',',$_POST['checkeados']);


            $mensaje    = array();
            $i = 0;
            while($i < count($checkeados)){
                $cons   = 'DELETE FROM `'.$bd.'`.`'.$tbl.'` WHERE ';
                mysqli_data_seek($consulta,$checkeados[$i]);
                $fila = mysqli_fetch_array($consulta);
                for($j = 0; $j < count($cabecera); $j++){
                    $cons .= $cabecera[$j].' = "';
                    $cons .= $fila[$j];
                    if($j != count($cabecera)-1)
                        $cons .= '" AND ';
                    else
                        $cons .= '";';
                }
                $mensaje[] = $cons;
                $i++;
            }
            //var_dump($mensaje);
            if(count($mensaje) != 0){
                for($i = 0; $i < count($mensaje); $i++){
                    $sql        = $mensaje[$i];
                    echo $sql;
                    if($consulta   = mysqli_query(conexion(),$sql))
                        $_SESSION['query'] = true;
                    else{
                        $_SESSION['query'] = false;
                        break;
                    }
                }
            }
        }
        else{
            $_SESSION['query'] = false;
        }
    }

    elseif(isset($_POST['modificados'])){
        if(isset($_SESSION['tbl'])){
            $tbl        = $_SESSION['tbl'];
            $contenedor = array();
            $recibidos  = array();

            $sql        = "SELECT * FROM `".$bd."`.`".$tbl."`";
            $consulta   = mysqli_query(conexion(),$sql);
            $cabecera   = dame_cabecera($consulta);
            mysqli_data_seek($consulta,0);

            while($fila = mysqli_fetch_array($consulta))
                for($i = 0; $i < count($cabecera); $i++)
                    $contenedor[] = $fila[$cabecera[$i]];
            //var_dump($contenedor);

            for($i = 1; $i < count($contenedor)+1; $i++)
                $recibidos[] = $_POST["$i"];
            //var_dump($recibidos);

            $i = 0;
            while($i < count($contenedor)){
                $flag = false;
                $aux = $aux2 = $i;
                for($j = 0; $j < count($cabecera); $j++){
                    if($contenedor[$i] != $recibidos[$i])
                        $flag = true;
                    $i++;
                }
                if($flag === true){
                    $sql        = "UPDATE `".$bd."`.`".$tbl."` SET ";
                    for($l = 0; $l < count($cabecera); $l++){
                        $sql   .= $cabecera[$l]." = ";
                        $sql   .= "'".$recibidos[$aux]."'";
                        if($l != count($cabecera)-1)
                            $sql .= ", ";
                        else
                            $sql .= " ";
                        $aux++;
                    }
                    $sql       .= "WHERE ";
                    for ($l = 0; $l < count($cabecera); $l++) { 
                        $sql   .= $cabecera[$l]." = ";
                        $sql   .= "'".$contenedor[$aux2]."'";
                        if($l != count($cabecera)-1)
                            $sql .= " AND ";
                        else
                            $sql .= ";";
                        $aux2++;
                    }
                    //echo $sql;
                    if($consulta   = mysqli_query(conexion(),$sql))
                        $_SESSION['query'] = true;
                    else{
                        $_SESSION['query'] = false;
                        break;
                    }
                }
            }
        }
    }
    header('location:dtbl.php?tbl='.$tbl);
}

function dtblquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="dtblquerytrue">Operación finalizada correctamente</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="dtblqueryfalse">Operación imposible de realizar</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}


/**
 * <strong>Función <i>vtbllanza()</i></strong>
 * 
 * Con esta función recogemos las tablas que tuviese el checkbox activo para borrarse.
 * Si las hay, se selecciona la base de datos de dichas tablas y se las busca en el registro.
 * Una vez se las encuentra, se prueba a lanzar el comando para borrarlas una a una, si alguna falla,
 * se termina el bucle y se devuelve un mensaje de error.
 * 
 * @author Eugenio Perojil
 */
function vtbllanza(){
    if($_POST['checkeados'] || $_POST['checkeados'] == 0){
        $checkeados = explode(',', $_POST['checkeados']);
        //var_dump($checkeados);
        if(count($checkeados) != 0){
            $bd         = $_SESSION['bdselected'];
            $sql        = 'SHOW FULL TABLES FROM '.$bd;
            //echo $sql;
            $consulta   = mysqli_query(conexion(),$sql);
            for($i = 0; $i < count($checkeados); $i++){
                mysqli_data_seek($consulta,$checkeados[$i]);
                $fila   = mysqli_fetch_array($consulta);
                $sql    = 'DROP TABLE `'.$bd.'`.`'.$fila[0].'`';
                if(mysqli_query(conexion(),$sql))
                    $_SESSION['query'] = true;
                else{
                    $_SESSION['query'] = false;
                    break;
                }
            }
        }
        else
            $_SESSION['query'] = false;
    }
    else
        $_SESSION['query'] = false;
    header('location:vtbl.php?bd='.$bd);
}

function vtblquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="vtblquerytrue">Operación finalizada correctamente</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="vtblqueryfalse">Operación imposible de realizar</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

function userslista($reg=''){
    $sql            = 'SELECT * FROM `mysql`.`user`';
    if($consulta    = mysqli_query(conexion(),$sql)){
        $i = 0;
        $nombre     = array('Host','Usuario','Seleccionar','Insertar','Actualizar registros','Borrar (DELETE)','Crear','Eliminar (DROP)','Recargar','Desconectar','Procesos','Archivos','GRANT','Referencias','Índices','Actualizar tablas', 'Listar BBDD','SUPER','Tablas temporales','Bloquear tablas','Ejecutar rutinas','Replicar esclavo','Replicar cliente','Crear vistas','Mostrar vistas','Crear rutinas','Actualizar rutinas','Acciones sobre usuarios','Organizar eventos','Administrar triggers','Crear tablespaces','Tipo SSL','Cifrado SSL','Tipo x509','Objetivo x509','Maximo de consultas','Máximo de actualizaciones','Máximo de conexiones','Conexiones simultáneas','Plugin','Contraseña','Expira','Último cambio de contraseña','Tiempo de vida de la contraseña','Cuenta bloqueada');

        if($reg == ''){
            echo "<div class='col-sm-12'>";
            echo "<h3>Usuarios</h3>";
            echo "</div>";

            echo "<div class='col-sm-12 usersdiv3' id='usersdiv3'>";
        }
        echo "<table class='compact display nowrap' style='width:100%;' id='tabladatatable muestrausers'>";
        echo "<thead>";
        echo "<tr>";
        if($reg == ''){
            echo "<th>";
            echo "Borrar";
            echo "</th>";
        }

        for($i = 0; $i < count($nombre); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tfoot>";
        echo "<tr>";

        if($reg == ''){
            echo "<th>";
            echo "Borrar";
            echo "</th>";
        }

        for($i = 0; $i < count($nombre); $i++)
            echo "<th>".$nombre[$i]."</th>";
        echo "</tr>";
        echo "</tfoot>";

        echo "<tbody>";
        mysqli_data_seek($consulta,0);


        $j = 0;
        $l = 0;
        while($fila = mysqli_fetch_array($consulta)){
            //var_dump($fila);
            echo "<tr>";

            if($reg == ''){
                echo "<td style='width:70px;'>";
                echo "<input type='checkbox' class='checkbox' name='".$l."'/>";
                echo "</td>";
                $l++;
            }

            for($i = 0; $i < count($nombre); $i++){
                if($reg == '')
                    echo "<td title='".$fila[$i]."'>".$fila[$i]."</td>";
                else{
                    if($extra[$i] == 'auto_increment')
                        echo "<td title='".$fila[$i]."'><input type='text' id='".$fila[$i]."' name='".$reg."' value='".$fila[$i]."' class='hide'/>".$fila[$i]."</td>";
                    else{
                        echo "<td title='".$fila[$i]."'><span class='hide'>".$fila[$i]."</span><input type='text' id='".$fila[$i]."' name='".$reg."' value='".$fila[$i]."' style='width:100%;' ";
                        if($nulo[$i] == 'YES') echo "required ";
                        $longitud = substr($tipo[$i], strpos($tipo[$i], "(")+1,-1);
                        echo "maxlength='".$longitud."' ";
                        echo "/></td>";
                    }
                    $reg++;
                }
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        if($reg == ''){
            echo "</div>";
        }
    }
}

/**
 * <strong>Función <i>permisos()</i></strong>
 * 
 * Con esta función comprobamos si el usuario tiene permisos para crear usuarios y/o para asignar permisos
 * a otros usuarios de la base de datos.
 * 
 * @return boolean
 * @author Eugenio Perojil
 */
function permisos(){
    $sql            = 'SELECT Create_user_priv, Grant_priv FROM `mysql`.`user` WHERE user = "'.nombre().'"';
    if($consulta    = mysqli_query(conexion(),$sql)){
        $fila       = mysqli_fetch_array($consulta);
        $crear      = $fila[0];
        $permisos   = $fila[1];
        if($crear == 'Y' && $permisos == 'Y'){
            return true;
        }
        else
            return false;
    }
}

function informacion($reg = ''){
    if($reg == '')
        $sql                = 'SELECT * FROM `mysql`.`user` WHERE User = "'.nombre().'"';
    else
        $sql                = 'SELECT * FROM `mysql`.`user`';
    if($consulta        = mysqli_query(conexion(),$sql)){
        $fila = mysqli_fetch_array($consulta);
        if($reg == ''){
            echo "<div class='row'>";
            echo "<div class='col-sm-12'>";
            echo "<h3>Información del usuario '".nombre()."'@'".$fila['Host']."'</h3>";
            echo "</div>";
            echo "</div>";
        }

        $nombre         = array('DATOS','ESTRUCTURA','ADMINISTRACIÓN','RECURSOS','CONTRASEÑA');
        $encabezado     = array(
            'DATOS'             => array('SELECCIONAR','INSERTAR','ACTUALIZAR','BORRAR','ARCHIVOS'),
            'ESTRUCTURA'        => array('CREAR','ALTERAR','ÍNDICES','ELIMINAR','CREAR TABLAS TEMP','MOSTRAR VISTAS','CREAR VISTAS','CREAR RUTINAS','ALTERAR RUTINAS','EJECUTAR RUTINAS','ORGANIZAR EVENTOS','ADM DISPARADORES'),
            'ADMINISTRACIÓN'    => array('GRANT','SUPER','VER PROCESOS','RECARGAR','APAGAR','MOSTRAR BD','BLOQUEAR TABLAS','REPLICACIÓN CLIENTE','REPLICACIÓN ESCLAVO','CREAR USUARIOS'),
            'RECURSOS'          => array('LÍMITE DE CONSULTAS POR HORA','LÍMITE DE ACTUALIZACIONES POR HORA','LÍMITE DE CONEXIONES POR HORA','LÍMITE DE CONEXIONES SIMULTÁNEAS POR HORA'),
            'CONTRASEÑA'        => array('TIPO DE PLUGIN','CONTRASEÑA CIFRADA','CONTRASEÑA EXPIRADA','ÚLTIMA MODIFICACIÓN DE LA CONTRASEÑA','TIEMPO DE VIDA DE LA CONTRASEÑA'));

        $name           = array(
            'DATOS'             => array('SELECCIONAR','INSERTAR','ACTUALIZAR','BORRAR','ARCHIVOS'),
            'ESTRUCTURA'        => array('CREAR','ALTERAR','ÍNDICES','ELIMINAR','TEMPORALES','MVISTAS','CVISTAS','CRUTINAS','ARUTINAS','ERUTINAS','EVENTOS','DISPARADORES'),
            'ADMINISTRACIÓN'    => array('GRANT','SUPER','VPROCESOS','RECARGAR','APAGAR','MOSTRARBD','BLOQUEAR','RCLIENTE','RESCLAVO','CUSUARIOS'),
            'RECURSOS'          => array('LÍMITECONSULTAS','LÍMITEACTUALIZACIONES','LÍMITECONEXIONES','LÍMITECONEXIONESSIMULTÁNEAS'),
            'CONTRASEÑA'        => array('TIPOPLUGIN','CONTRASEÑA','EXPIRADA','ÚLTIMACONTRASEÑA','TIEMPOVIDA'));

        $desc           = array(
            'DATOS'             => array('Permite leer los datos','Permite insertar y reemplazar datos','Permite cambiar los datos','Permite borrar datos','Permite importar y exportar datos de y hacia archivos'),
            'ESTRUCTURA'        => array('Permite crear nuevas bases de datos y tablas','Permite alterar la estructura de las tablas existentes','Permite crear y eliminar índices','Permite eliminar bases de datos y tablas','Permite la creación de tablas temporales','Permite mostrar las vistas','Permite crear nuevas vistas','Permite crear el almacenamiento de rutinas','Permite alterar y eliminar las rutinas almacenadas','Permite ejecutar las rutinas almacenadas','Permite organizar los eventos para el gestor de eventos','Permite crear y eliminar disparadores'),
            'ADMINISTRACIÓN'    => array('Permite añadir usuarios y privilegios sin conectarse nuevamente a la tabla de privilegios','Permite la conexión, incluso si el número máximo de conexiones ha sido alcanzado; Necesario para la mayor parte de operaciones administrativas tales como montar parámetros de variables globales o matar procesos de otros usuarios','Permite ver los procesos de todos los usuarios','Permite volver a cargar los parámetros del servidor y depurar los cachés del servidor','Permite desconectar el servidor','Concede acceso a la lista completa de bases de datos','Permite poner candados a las tablas para el proceso actual','Da el derecho al usuario para preguntar dónde están los esclavos / maestros','Necesario para los esclavos de replicación','Permite crear, eliminar y cambiar el nombre de las cuentas de usuario'),
            'RECURSOS'          => array('Limita el número de consultas que el usuario puede enviar al servidor por hora','Limita el número de comandos que cambian cualquier tabla o base de datos que el usuario puede ejecutar por hora','Limita el número de conexiones nuevas que el usuario puede abrir por hora','Limita el número de conexiones simultáneas que el usuario pueda tener'),
            'CONTRASEÑA'        => array('','','','',''));

        if($reg == '')
            $datos          = array(
                'DATOS' => array($fila['Select_priv'],$fila['Insert_priv'],$fila['Update_priv'],$fila['Delete_priv'],$fila['File_priv']),
                'ESTRUCTURA' => array($fila['Create_priv'],$fila['Alter_priv'],$fila['Index_priv'],$fila['Drop_priv'],$fila['Create_tmp_table_priv'],$fila['Show_view_priv'],$fila['Create_view_priv'],$fila['Create_routine_priv'],$fila['Alter_routine_priv'],$fila['Execute_priv'],$fila['Event_priv'],$fila['Trigger_priv']),
                'ADMINISTRACIÓN' => array($fila['Grant_priv'],$fila['Super_priv'],$fila['Process_priv'],$fila['Reload_priv'],$fila['Shutdown_priv'],$fila['Show_db_priv'],$fila['Lock_tables_priv'],$fila['Repl_client_priv'],$fila['Repl_slave_priv'],$fila['Create_user_priv']),
                'RECURSOS' => array($fila['max_questions'],$fila['max_updates'],$fila['max_connections'],$fila['max_user_connections']),
                'CONTRASEÑA' => array($fila['plugin'],$fila['authentication_string'],$fila['password_expired'],$fila['password_last_changed'],$fila['password_lifetime']));
        //$datos          = array('SELECCIONAR','INSERTAR','ACTUALIZAR','BORRAR','ARCHIVOS');
        //$estructura     = array('CREAR','ALTERAR','ÍNDICES','ELIMINAR','CREAR TABLAS TEMP','MOSTRAR VISTAS','CREAR VISTAS','CREAR RUTINAS','ALTERAR RUTINAS','EJECUTAR RUTINAS','ORGANIZAR EVENTOS','ADM DISPARADORES');
        //$administracion = array('GRANT','SUPER','VER PROCESOS','RECARGAR','APAGAR','MOSTRAR BD','BLOQUEAR TABLAS','REPLICACIÓN CLIENTE','REPLICACIÓN ESCLAVO','CREAR USUARIOS');
        //$recursos       = array('LÍMITE DE CONSULTAS POR HORA','LÍMITE DE ACTUALIZACIONES POR HORA','LÍMITE DE CONEXIONES POR HORA','LÍMITE DE CONEXIONES SIMULTÁNEAS POR HORA');

        echo "<div class='row'>";
        if($reg != ''){
            echo "<div class='col-sm-12'>";
            echo "<div class='form-group'>";
            echo "<label for='usuario'>USUARIO</label>";
            echo "<input type='text' class='form-control' id='usuario' name='usuario' placeholder='Nombre del nuevo usuario' required />";
            echo "</div>";
            echo "</div>";
            echo "<div class='col-sm-12'>";
            echo "<div class='form-group'>";
            echo "<label for='host'>HOST</label>";
            echo "<input type='text' class='form-control' id='host' name='host' placeholder='Host al que pertenece' required />";
            echo "</div>";
            echo "</div>";
        }
        if($reg == '')
            echo "<div class='jumbotron col-sm-12'>";
        for($i = 0; $i < count($nombre); $i++){
            if($i < 3)
                echo "<div class='col-sm-4'>";
            else
                echo "<div class='col-sm-6'>";

            if($reg != '')
                echo "<b>";
            echo "<p>".$nombre[$i]."</p><br>";
            if($reg != '')
                echo "</b>";

            if($i < 3)
                echo "<div class='checkbox'>";
            else
                echo "<div class='form-group'>";

            for($j = 0; $j < count($encabezado[$nombre[$i]]); $j++){
                if($i < 3){
                    echo "<label title='".$desc[$nombre[$i]][$j]."'><input type='checkbox' class='checkbox' name='".$name[$nombre[$i]][$j]."' id='".$encabezado[$nombre[$i]][$j]."' ";
                    if($reg == ''){
                        echo "disabled ";
                        if($datos[$nombre[$i]][$j] == 'Y')
                            echo "checked ";
                    }
                    echo ">";
                    echo $encabezado[$nombre[$i]][$j]."</label>";
                    echo "<br>";
                }
                else{
                    if($reg == '')
                        echo "<label for='".$encabezado[$nombre[$i]][$j]."'>".$encabezado[$nombre[$i]][$j]."</label>";
                    else
                        if($i == 4 && $j == 1)
                            echo "<label for='".$encabezado[$nombre[$i]][$j]."'>CONTRASEÑA</label>";
                        else
                            echo "<label for='".$encabezado[$nombre[$i]][$j]."'>".$encabezado[$nombre[$i]][$j]."</label>";
                    echo "<input type='text' title='".$desc[$nombre[$i]][$j]."' class='form-control' name='".$name[$nombre[$i]][$j]."' id='".$encabezado[$nombre[$i]][$j]."' ";
                    if($reg == '')
                        echo "disabled value='".$datos[$nombre[$i]][$j]."' />";
                    else
                        if($i == 3)
                            echo "value = 0 />";
                        elseif($i == 4){
                            if($j == 0)
                                echo "readonly value='mysql_native_password' />";
                            elseif($j == 2)
                                echo "disabled value='N' />";
                            elseif($j == 3) 
                                echo "disabled />";
                            elseif($j == 4)
                                echo "disabled />";
                        }
                        else
                            echo " />";
                    echo "<br>";
                }
            }
            if($i == 3)
                echo "<small>Nota: 0 simboliza que no tiene límite</small><br>";
            echo "</div>";
            echo "</div>";
            
        }
        echo "</div>";
        if($reg == '')
            echo "</div>";

    }
}

function userslanza(){
    if(!isset($_POST['checkeados']) && !isset($_POST['modificados'])){
        $sql            = 'CREATE USER "'.$_POST['usuario'].'"@"'.$_POST['host'].'" IDENTIFIED BY "';
        if(isset($_POST['CONTRASEÑA']))
            $sql       .= $_POST['CONTRASEÑA'];
        $sql           .= '";';
        $consulta = mysqli_query(conexion(),$sql);
        echo $sql;

        $sql            = 'GRANT ';

        $nombre         = array('DATOS','ESTRUCTURA','ADMINISTRACIÓN'//,'RECURSOS','CONTRASEÑA'
    );
        $encabezado     = array(
            'DATOS' => array('SELECCIONAR','INSERTAR','ACTUALIZAR','BORRAR','ARCHIVOS'),
            'ESTRUCTURA' => array('CREAR','ALTERAR','ÍNDICES','ELIMINAR','TEMPORALES','MVISTAS','CVISTAS','CRUTINAS','ARUTINAS','ERUTINAS','EVENTOS','DISPARADORES'),
            'ADMINISTRACIÓN' => array('SUPER','VPROCESOS','RECARGAR','APAGAR','MOSTRARBD','BLOQUEAR','RCLIENTE','RESCLAVO','CUSUARIOS'),
            'RECURSOS' => array('LÍMITECONSULTAS','LÍMITEACTUALIZACIONES','LÍMITECONEXIONES','LÍMITECONEXIONESSIMULTÁNEAS')
        );

        $grant          = array(
            'SELECCIONAR' => 'SELECT',
            'INSERTAR' => 'INSERT',
            'ACTUALIZAR' => 'UPDATE',
            'BORRAR' => 'DELETE',
            'ARCHIVOS' => 'FILE',
            'CREAR' => 'CREATE',
            'ALTERAR' => 'ALTER',
            'ÍNDICES' => 'INDEX',
            'ELIMINAR' => 'DROP',
            'TEMPORALES' => 'CREATE TEMPORARY TABLES',
            'MVISTAS' => 'SHOW VIEW',
            'CVISTAS' => 'CREATE VIEW',
            'CRUTINAS' => 'CREATE ROUTINE',
            'ARUTINAS' => 'ALTER ROUTINE',
            'ERUTINAS' => 'EXECUTE',
            'EVENTOS' => 'EVENTOS',
            'DISPARADORES' => 'TRIGGER',
            'SUPER' => 'SUPER',
            'VPROCESOS' => 'PROCESS',
            'RECARGAR' => 'RELOAD',
            'APAGAR' => 'SHUTDOWN',
            'MOSTRARBD' => 'SHOW DATABASES',
            'BLOQUEAR' => 'LOCK TABLES',
            'RCLIENTE' => 'REPLICATION CLIENT',
            'RESCLAVO' => 'REPLICACION SLAVE',
            'CUSUARIOS' => 'CREATE USER',
        );

        $aux = 0;
        for($i = 0; $i < count($nombre); $i++){
            for($j = 0; $j < count($encabezado[$nombre[$i]]); $j++){
                if(isset($_POST[$encabezado[$nombre[$i]][$j]]))
                    $aux++;
            }
        }

        if($aux == 26){
            $sql .= 'ALL PRIVILEGES ';
        }

        elseif($aux != 0){
            $aux2 = 0;
            for($i = 0; $i < count($nombre); $i++){
                for($j = 0; $j < count($encabezado[$nombre[$i]]); $j++){
                    if(isset($_POST[$encabezado[$nombre[$i]][$j]])){
                        $sql .= $grant[$encabezado[$nombre[$i]][$j]];
                        if($aux-1 != $aux2)
                            $sql .= ', ';
                        else
                            $sql .= ' ';
                        $aux2++;
                    }
                }
            }
        }
        else{
            $sql .= 'USAGE';
        }

        $sql .= ' ON *.* TO "'.$_POST['usuario'].'"@"'.$_POST['host'].'" REQUIRE NONE WITH';
            if(isset($_POST['GRANT']))
                $sql .= ' GRANT OPTION';
            $sql .= ' MAX_QUERIES_PER_HOUR '.$_POST['LÍMITECONSULTAS'];
            $sql .= ' MAX_CONNECTIONS_PER_HOUR '.$_POST['LÍMITECONEXIONES'].' MAX_UPDATES_PER_HOUR '.$_POST['LÍMITEACTUALIZACIONES'];
            $sql .= ' MAX_USER_CONNECTIONS '.$_POST['LÍMITECONEXIONESSIMULTÁNEAS'];
        //echo $sql;
        

        if($consulta       = mysqli_query(conexion(),$sql))
            $_SESSION['query'] = true;
        else
            $_SESSION['query'] = false;
    }
    elseif(isset($_POST['checkeados'])){

            $sql        = "SELECT * FROM `mysql`.`user`";
            $consulta   = mysqli_query(conexion(),$sql);
            $checkeados = explode(',',$_POST['checkeados']);


            $mensaje    = array();
            $i = 0;
            while($i < count($checkeados)){
                mysqli_data_seek($consulta,$checkeados[$i]);
                $fila = mysqli_fetch_array($consulta);
                $cons   = 'DROP USER "'.$fila['User'].'"@"'.$fila['Host'].'"';
                $mensaje[] = $cons;
                $i++;
            }
            var_dump($mensaje);
            if(count($mensaje) != 0){
                for($i = 0; $i < count($mensaje); $i++){
                    $sql        = $mensaje[$i];
                    if($consulta   = mysqli_query(conexion(),$sql))
                        $_SESSION['query'] = true;
                    else{
                        $_SESSION['query'] = false;
                        break;
                    }
                }
            }
        }
    else{
        $_SESSION['query'] = false;
    }

    header('location:users.php');
}

function usersquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="usersquerytrue">Operación finalizada correctamente</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="usersqueryfalse">Operación imposible de realizar</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

function guardar_session(){
    if(isset($_POST['comando'])){
        $_SESSION['shell'] = $_POST['comando'];
    }
}

function lanzar_comando($comando){
    $comando    = explode(';', $comando);
    $aux        = array();
    for($i = 0; $i < count($comando)-1; $i++){
        $aux[] = ' '.$comando[$i];
    }
    $comando = $aux;
    //var_dump($comando);
    for($i = 0; $i < count($comando); $i++){
        //var_dump($comando);
        $select = strpos($comando[$i], 'SELECT');
        //echo $select;
        $comando[$i] = substr($comando[$i], 1);
        //var_dump($comando);
        if($select == true && ($select == 1 || $select == 2)){
            $sql        = $comando[$i];
            echo 'Consulta: '.$sql.'<br>';
            if($consulta = mysqli_query(conexion(),$sql)){
                $cabecera = dame_cabecera($consulta);
                //var_dump($cabecera);
                echo '<table style="background-color:black;">';
                echo '<thead>';
                echo '<tr>';
                $fila = mysqli_fetch_array($consulta);
                for($h = 0; $h < count($fila)/2; $h++)
                    echo '<th>'.$cabecera[$h].'</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tfoot>';
                echo '<tr>';
                for($h = 0; $h < count($fila)/2; $h++)
                    echo '<th>'.$cabecera[$h].'</th>';
                echo '</tr>';
                echo '<tfoot>';
                echo '<tbody>';
                mysqli_data_seek($consulta,0);
                while ($fila = mysqli_fetch_array($consulta)) {
                    echo '<tr style="background-color:black;">';
                    for($j = 0; $j < count($fila)/2; $j++){
                        echo '<td style="background-color:black;">'.$fila[$j].'</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            }
            else{
                echo 'Imposible de realizar';
            }
        }
        else{
            $sql        = $comando[$i];
            echo 'Consulta: '.$sql.'<br>';
            $conn=mysqli_connect(servidor(),nombre(),contrasena());
            mysqli_set_charset($conn, "utf8");
            //$consulta   = mysqli_query(conexion(),$sql);
            if(mysqli_query(conexion(),$sql) && mysqli_error($conn) == ''){
                echo 'Consulta realizada satisfactoriamente.<br>';
            }
            else{
                echo 'Imposible de realizar.<br>';
                $error      = mysqli_error(conexion());
                echo $error.'<br>';
            }
        }
    }
}

function ultimas_sesiones(){
    $sql        = 'SELECT * FROM `sys`.`session`;';
    if($consulta = mysqli_query(conexion(),$sql)){
        $cabecera   = array('ID del hilo','ID de conexión','Base de datos','Orden','Estado','Tiempo','Declaración actual','Latencia de la declaración','Progreso','Latencia de bloqueo','Filas examinadas','Filas enviadas','Filas afectadas','Tablas temporales','Última declaración','Latencia de la última declaración');
        $j = 0;
        echo '<div class="panel-group" id="usuarios">';
        while ($fila = mysqli_fetch_array($consulta)) {
            $k = 0;
            echo '<div class="panel panel-default">';
            echo '<a data-toggle="collapse" data-parent="#usuarios" href="#usuarios'.$j.'"><div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<b>'.$fila[2].'</b>';
            echo '</h4>';
            echo '</div></a>';
            echo '<div id="usuarios'.$j.'" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo '<div class="list-group">';
            for($i = 0; $i < 19; $i++){

                if($i != 15 && $i != 16 && $i != 2){

                    echo '<a class="list-group-item"><b>'.$cabecera[$k].':</b> '.$fila[$i].'</a>';
                    $k++;
                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $j++;
        }
        echo '</div>';
    }
}

function informacion_sistema(){
    $sql        = 'SELECT * FROM `sys`.`version`, `sys`.`host_summary`';
    if($consulta = mysqli_query(conexion(),$sql)){
        $cabecera = array('Versión del sistema','Versión de MySQL','Host','Declaraciones totales','Latencia total','Latencia media de las declaraciones','Tablas escaneadas','Archivos IOS','Latencia de archivos IOS','Conexiones actuales','Total de conexiones','Usuarios únicos','Memoria actual','Total de memoria asignada');
        $j = 0;
        echo '<div class="panel-group" id="servidor">';
        while ($fila = mysqli_fetch_array($consulta)) {
            $k = 0;
            echo '<div class="panel panel-default">';
            echo '<a data-toggle="collapse" data-parent="#servidor" href="#servidor'.$j.'"><div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<b>'.$fila[2].'</b>';
            echo '</h4>';
            echo '</div></a>';
            echo '<div id="servidor'.$j.'" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo '<div class="list-group">';
            for($i = 0; $i < count($fila)/2; $i++){
                echo '<a class="list-group-item"><b>'.$cabecera[$i].':</b> '.$fila[$i].'</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $j++;
        }
        echo '</div>';
    }
}

function funciones(){
    $sql        = 'SELECT * FROM `mysql`.`proc` WHERE type = "FUNCTION";';
    if($consulta = mysqli_query(conexion(),$sql)){
        $cabecera = array('BD','Nombre','Nombre específico','Lenguaje','Acceso a datos','Determinista','Tipo de seguridad','Lista de parámetros','Devuelve','Cuerpo','Creador','Creado','Modificado','Modo de SQL','Comentario','Codificación del cliente','Cotejamiento de conexión','Cotejamiento de BD','Cuerpo en utf8');
        $j = 0;
        echo '<div class="panel-group" id="funciones">';
        while ($fila = mysqli_fetch_array($consulta)) {
            $k = 0;
            echo '<div class="panel panel-default">';
            echo '<a data-toggle="collapse" data-parent="#funciones" href="#funcion'.$j.'"><div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<b>'.$fila[1].'</b>';
            echo '</h4>';
            echo '</div></a>';
            echo '<div id="funcion'.$j.'" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#funcyprocborrar" style="margin-bottom:10px;" id="eliminar" value="FUNCTION">Eliminar</button>';
            echo '<div class="list-group">';
            for($i = 0; $i < count($fila)/2; $i++){
                if($i != 2){
                    echo '<a class="list-group-item"><b>'.$cabecera[$k].':</b> ';
                    if($k == 9 || $k == 18)
                        echo '<br>';
                    echo $fila[$i].'</a>';
                    $k++;
                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $j++;
        }
        echo '</div>';
    }
}

function procedimientos(){
    $sql        = 'SELECT * FROM `mysql`.`proc` WHERE type = "PROCEDURE";';
    if($consulta = mysqli_query(conexion(),$sql)){
        $cabecera = array('BD','Nombre','Nombre específico','Lenguaje','Acceso a datos','Determinista','Tipo de seguridad','Lista de parámetros','Devuelve','Cuerpo','Creador','Creado','Modificado','Modo de SQL','Comentario','Codificación del cliente','Cotejamiento de conexión','Cotejamiento de BD','Cuerpo en utf8');
        $j = 0;
        echo '<div class="panel-group" id="procedimientos">';
        while ($fila = mysqli_fetch_array($consulta)) {
            $k = 0;
            echo '<div class="panel panel-default">';
            echo '<a data-toggle="collapse" data-parent="#procedimientos" href="#procedimiento'.$j.'"><div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<b>'.$fila[1].'</b>';
            echo '</h4>';
            echo '</div></a>';
            echo '<div id="procedimiento'.$j.'" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#funcyprocborrar" style="margin-bottom:10px;" id="eliminar" value="PROCEDURE">Eliminar</button>';
            echo '<div class="list-group">';
            for($i = 0; $i < count($fila)/2; $i++){
                if($i != 2){
                    echo '<a class="list-group-item"><b>'.$cabecera[$k].':</b> '.$fila[$i].'</a>';
                    $k++;
                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $j++;
        }
        echo '</div>';
    }
}

function funcyproclanza(){
    if(isset($_POST['funcyproceli'])){
        if(isset($_POST['tipo'])){
            $sql        = 'DROP '.$_POST['tipo'].' '.$_POST['funcyproceli'].';';
            if($consulta = mysqli_query(conexion(),$sql))
                $_SESSION['query'] = true;
            else
                $_SESSION['query'] = false;
        }
    }
    else
        $_SESSION['query'] = false;
    header('location:funcyproc.php');
}

function funcyprocquery(){
    if(isset($_SESSION['query'])){
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="usersquerytrue">Operación finalizada correctamente</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="usersqueryfalse">Operación imposible de realizar</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

function impyexplista(){
    $sql        = 'SHOW DATABASES;';
    if($consulta = mysqli_query(conexion(),$sql)){
        $j = 0;
        echo '<div class="panel-group" id="basesdedatos">';
        while ($fila = mysqli_fetch_array($consulta)) {
            $k = 0;
            echo '<div class="panel panel-default">';
            echo '<a data-toggle="collapse" data-parent="#basesdedatos" href="#base'.$j.'">';
            echo '<div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<b>'.$fila['Database'].'</b>';
            echo '</h4>';
            echo '</div></a>';
            echo '<div id="base'.$j.'" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo '<div class="list-group">';
            echo '<a href="impyexplanza.php?base='.$fila['Database'].'" class="list-group-item active" style="cursor:pointer;">BD completa: '.$fila['Database'].'<span class="glyphicon glyphicon-floppy-save pull-right"></span></a>';
            $sql2       = 'SHOW FULL TABLES FROM '.$fila['Database'].';';
            $consulta2  = mysqli_query(conexion(),$sql2);
            while($fila2 = mysqli_fetch_array($consulta2)){
                echo '<a class="list-group-item" href="impyexplanza.php?base='.$fila['Database'].'&tabla='.$fila2[0].'" style="cursor:pointer;">'.$fila2[0].'<span class="glyphicon glyphicon-floppy-save pull-right"></span></a>';
                $k++;
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $j++;
        }
        echo '</div>';
    }
}

function impyexplanza(){
    // COMPROBAMOS SI SE HA IMPORTADO UN ARCHIVO PARA LEER
    if(isset($_FILES['archivo'])){
        // OBTENEMOS LA RUTA Y EL NOMBRE DEL ARCHIVO TEMPORAL IMPORTADO
        $ruta       = $_FILES['archivo']['tmp_name'];
        $nombre     = $_FILES['archivo']['name'];
        // ABRIMOS EL ARCHIVO EN MODO LECTURA Y SI NO ES POSIBLE, CERRAMOS
        $file       = fopen($ruta, "r") or exit("Imposible abrir el archivo");
        // INCIAMOS LA VARIABLE QUE USAREMOS PARA GUARDAR EL CONTENIDO DEL ARCHIVO
        $temporal   = '';
        // COMENZAMOS A GUARDAR TODAS LAS LÍNEAS
        while(!feof($file))
            $temporal .= ' '.fgets($file);
        // CERRAMOS EL ARCHIVO
        fclose($file);
        // MIENTRAS QUE ENCUENTRE ";" CONTINUARÁ FRACCIONANDO EL CONTENIDO
        while (strpos($temporal, ';') != 0) {
            // OBTENEMOS LA CONSULTA HASTA EL ";" Y LO INTENTAMOS LANZAR
            $sql        = substr($temporal,0,strpos($temporal, ';')+1);
            $temporal   = substr($temporal,strpos($temporal, ';')+1);
            if($consulta = mysqli_query(conexion(),$sql))
                $_SESSION['query'] = true;
            else{
                $_SESSION['query'] = false;
                break;
            }
        }
        // SI EL ARCHIVO TEMPORAL SE HA QUEDADO VACÍO, HEMOS TERMINADO
        if($temporal == '')
            $_SESSION['query'] = true;
        // EN CASO CONTRARIO, LANZAMOS EL CONTENIDO QUE TENGA
        else{
            $sql = $temporal;
            if($consulta = mysqli_query(conexion(),$sql))
                $_SESSION['query'] = true;
            else{
                $_SESSION['query'] = false;
                header('location:impyexp.php');
            }
        }
    }

    // SI SE NOS MANDA UNA BASE DE DATOS TENEMOS QUE EXPORTAR
    elseif(isset($_GET['base'])){
        $bd         = $_GET['base'];
        // INICIALIZAMOS LA VARIABLE QUE GUARDARÁ LA TABLA
        $tabla      = '';
        // COMPROBAMOS SI SE QUIERE EXPORTAR SÓLO UNA TABLA
        if(isset($_GET['tabla'])){
            $tabla  = $_GET['tabla'];
        }
        // RECOGEMOS TODAS LAS TABLAS EXISTENTES EN LA BD
        $sql    = 'SHOW TABLES FROM `'.$bd.'`;';
        $consulta = mysqli_query(conexion(),$sql);
        if(mysqli_num_rows($consulta) != 0){
            // SI SE QUIERE SÓLO UNA TABLA, GENERAMOS SU PARTE
            if($tabla != ''){
                // GENERAMOS LA CABECERA DEL ARCHIVO
                $generador  = dame_inicio($bd,'N');
                $fichero    = $tabla;
                $generador .= dame_estructura($bd,$tabla);
            }
            // SI SE QUIERE TODA LA BASE DE DATOS, GENERAMOS
            // RECURSIVAMENTE LAS PARTES TABLA POR TABLA
            else{
                // GENERAMOS LA CABECERA DEL ARCHIVO
                $generador  = dame_inicio($bd,'S');
                $fichero    = $bd;
                while ($fila = mysqli_fetch_array($consulta)){
                    $generador .= dame_estructura($bd,$fila[0]);
                }
            }
            // AÑADIMOS EL COMMIT
            $generador .= 'COMMIT;';
            $_SESSION['query'] = true;
            // GENERAMOS EL ARCHIVO
            crea_txt($fichero,$generador);
        }
        else
            $_SESSION['query'] = false;
    }

    else{
        $_SESSION['query'] = false;
        
    }
    header('location:impyexp.php');
}

function impyexpquery(){
    // PREPARAMOS EL MENSAJE DE FINALIZACIÓN
    // QUE SE MOSTRARÁ EN LA PÁGINA
    if(isset($_SESSION['query'])){
        // SI NO HA HABIDO ERRORES ENTRA AQUÍ
        if($_SESSION['query'] === true){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="usersquerytrue">
                    Operación finalizada correctamente</div>
                </div>
            </div>';
            $_SESSION['query'] = '';
        }
        // SI HA HABIDO ERRORES ENTRA AQUÍ
        elseif($_SESSION['query'] === false){
            echo '<div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger" id="usersqueryfalse">
                    Operación imposible de realizar</div>
                </div>
            </div>';
            $_SESSION['query']='';
        }
    }
    else $_SESSION['query']='';
}

function dame_inicio($bd,$entera){
    // INSERTAMOS LA CABECERA Y LA DEVOLVEMOS
    $generador  = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
';
    $generador .= 'SET AUTOCOMMIT = 0;
';
    $generador .= 'START TRANSACTION;
';
    $generador .= 'SET time_zone = "+00:00";
';
    $generador .= '
';
    $generador .= '--
';
    $generador .= '-- Base de datos: `'.$bd.'`
';
    $generador .= '--
';
    if($entera == 'S'){
        $generador .= 'DROP DATABASE IF EXISTS `'.$bd.'`;
';
        $generador .= 'CREATE DATABASE IF NOT EXISTS `'.$bd.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
';
        $generador .= 'USE `'.$bd.'`;
';
    }
    return $generador;
}

function dame_estructura($bd,$tabla){
    // AÑADIMOS LAS LÍNEAS SEGÚN LA TABLA QUE SE NOS ENTREGUE
    $generador = '
';
    $generador .= '-- --------------------------------------------------------
';
    $generador .= '
';
    $generador .= '--
';
    $generador .= '-- Estructura de tabla para la tabla `'.$tabla.'`
';
    $generador .= '--
';
    $generador .= '
';
    // SENTENCIA PARA OBTENER LA INFORMACIÓN DE LA TABLA
    $sql        = 'show full columns from `'.$bd.'`.`'.$tabla.'`;';
    $generador .= 'DROP TABLE IF EXISTS `'.$bd.'`.`'.$tabla.'`;
';
    $generador .= 'CREATE TABLE IF NOT EXISTS `'.$bd.'`.`'.$tabla.'` (
';
    // OBTENEMOS TODOS LOS DATOS QUE NECESITAMOS DE LA TABLA Y LOS CAMPOS
    // Y LOS AÑADIMOS
    if($consulta   = mysqli_query(conexion(),$sql)){
        $primarias = array();
        while($fila   = mysqli_fetch_array($consulta)){
            $generador .= '`'.$fila['Field'].'` '.$fila['Type'];

            if($fila['Collation'] != '')
                $generador .= ' COLLATE '.$fila['Collation'];
            if($fila['Null'] == 'NO')
                $generador .= ' NOT NULL';
            if($fila['Extra'] != '')
                $generador .= ' '.strtoupper($fila['Extra']);
            $AUXILIAR   = $generador;
            $generador .= ',
';

            if($fila['Key'] == 'PRI')
                $primarias[] = $fila['Field'];
        }

        if(count($primarias) != 0){
            $generador .= 'PRIMARY KEY (';
            for($i = 0; $i < count($primarias); $i++){
                $generador .= '`'.$primarias[$i].'`';
                if($i != count($primarias)-1)
                    $generador .= ',';
                $generador .= ')
';
            }
        }
        else{
            $generador = $AUXILIAR.'
';
        }

        $generador .= ')';
        $sql        = 'SHOW TABLE STATUS FROM '.$bd.' WHERE name = "'.$tabla.'"';
        if($consulta = mysqli_query(conexion(),$sql)){
        $fila = mysqli_fetch_array($consulta);
        if($fila['Engine'] != '')
        $generador .= ' ENGINE='.$fila['Engine'];
        if($fila['Collation'] != ''){
        $charset = substr($fila['Collation'], 0, strpos($fila['Collation'], '_'));
        $generador .= ' DEFAULT CHARSET='.$charset.' COLLATE='.$fila['Collation'];
        }
        }
        $generador .= ';
';
    }
    // COMPROBAMOS SI EXISTEN REGISTROS Y LOS AÑADIMOS
    $sql        = 'SELECT * FROM `'.$bd.'`.`'.$tabla.'`;';
    $consulta = mysqli_query(conexion(),$sql);
    if($consulta != null)
    if(mysqli_num_rows($consulta) != 0){
        $generador .= '
';
        $generador .= '--
';
        $generador .= '-- Volcado de datos para la tabla `tablaprueba3`
';
        $generador .= '--
';
        $generador .= '
';
        $generador .= 'INSERT INTO `'.$bd.'`.`'.$tabla.'` (';
        $cabecera   = dame_cabecera($consulta);
        for($i = 0; $i < count($cabecera); $i++){
            $generador .= '`'.$cabecera[$i].'`';
            if($i != count($cabecera)-1)
                $generador .= ', ';
        }
        $generador .= ') VALUES
';
        $consulta = mysqli_query(conexion(),$sql);
        while ($fila = mysqli_fetch_array($consulta)) {
            //var_dump($fila);
            $generador .= '(';
            for($i = 0; $i < count($fila)/2; $i++){
                $generador .= '"'.$fila[$cabecera[$i]].'"';
                if($i != (count($fila)/2)-1)
                    $generador .= ', ';
            }
            $generador .= ')';
            $AUXILIAR = $generador;
            $generador .= ',
';

        }
        $generador = $AUXILIAR.';
';
    }
    // DEVOLVEMOS LAS SENTENCIAS DE LA TABLA
    return $generador;
}

function crea_txt($fichero,$generador){
    // SE NOS ENTREGA EL NOMBRE DEL FICHERO Y LAS SENTENCIAS
    $nombre = $fichero.'.txt';
    // ABRIMOS EL FICHERO EN MODO ESCRITURA POR SI EXISTE
    if($archivo = fopen($nombre, 'w')){
        // ESCRIBIMOS LAS SENTENCIAS Y CERRAMOS
        if(fwrite($archivo, $generador)){
            $_SESSION['fichero'] = $nombre;
            $_SESSION['query'] = true;
        }
        else{
            $_SESSION['fichero'] = '';
            $_SESSION['query'] = false;
        }
        fclose($archivo);
    }
}
?>