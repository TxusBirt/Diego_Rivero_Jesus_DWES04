<?php
require 'DatabaseSingleton.php';

$db = DatabaseSingleton::getInstance();
$db_PDO = $db->getConnection();
$query = "SELECT * FROM equipo";
$statement = $db_PDO->query($query);
$resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
print_r($resultado);

if(isset($_POST['eliminar_id'])) {
    // Obtener el ID del registro a eliminar
    $id_eliminar = $_POST['eliminar_id'];

    // Realizar la eliminación del registro
    $db = DatabaseSingleton::getInstance();
    $conexion = $db->getConnection();
    $query = "DELETE FROM equipo WHERE idequipo = $id_eliminar";
    $statement = $conexion->prepare($query);
    $statement->execute();
}
$nombre="";
$puntos="";
if (isset($_POST['nombre']) && isset($_POST['puntos'])) {
    $nombre =  $_POST['nombre'];
    $puntos = $_POST['puntos'];
    $valorAutomatico = 0;
    foreach ($resultado as $idequipo) {
        if ($idequipo['idequipo'] > $valorAutomatico){
            $valorAutomatico= $idequipo['idequipo'];
        } else {
            $valorAutomatico=$valorAutomatico;
        }
    };
    $idEquipoDef=$valorAutomatico+1;
    $query1="INSERT INTO equipo (idequipo, nombre, puntos) VALUES ('$idEquipoDef','$nombre','$puntos')";
    $statement1 = $db_PDO->prepare($query1);
    $statement1->execute();
}
if(isset($_POST['modificar_id'])) {
    $id_modificado = $_POST['modificar_id'];
    $registro_id = $_POST['registro_id'];
    $query_update = "UPDATE equipo SET puntos = '$id_modificado' WHERE idequipo = '$registro_id'";
    $statement_update = $db_PDO->prepare($query_update);
    $statement_update->execute();
}
$query = "SELECT * FROM equipo";
$statement = $db_PDO->query($query);
$resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Resultados de la consulta</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puntos</th>
        </tr>
        <?php
        // Itera sobre los resultados y muestra cada fila en la tabla
        foreach ($resultado as $fila) {
            echo "<tr>";
            echo "<td>" . $fila['idequipo'] . "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<td><a href='equipo.php?nombre=" . $fila['nombre'] . "&id=" . $fila['idequipo'] . "'>" .  $fila['nombre'] . "</a></td>";
            echo  "<input type='hidden' name='registro_id' value='" . $fila['idequipo'] . "'>";
            echo  "<input type='hidden' name='nombreteam' value='" . $fila['nombre'] . "'>";
            echo   "<input type='text' name='modificar_id' value='" . $fila['puntos'] . "'>";
            echo   "<input type='submit' value='Modificar'>";
            echo "</form>";
            echo "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='eliminar_id' value='" . $fila['idequipo'] . "'>";
            echo "<input type='submit' value='Eliminar'>";
            echo "</form>";
            echo "<td>";
            echo"<td>";
            
            echo "</form>";

            echo"</td>";
            echo "</tr>";
        }
        ?>

    </table>
    <form method='post' action="">
        <label for="nombre">Nombre</label>
        <input type="text" value="" id="nombre" name="nombre">
        <label for="puntos">Puntos</label>
        <input type="text" value="" id= "puntos" name="puntos">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

