<?php include "cabecera.php" ?>
<?php include "conexion.php" ?>
<?php
// Insertar datos a la base de datos
if ($_POST) {
    // Recuperar datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];

    $fecha = new DateTime();

    $imagen = $fecha->getTimestamp() . "_" . $_FILES["archivo"]["name"];

    // Adjuntar imagen
    $imagen_temporal = $_FILES["archivo"]["tmp_name"];
    move_uploaded_file($imagen_temporal, "imagenes/" . $imagen);

    $objConexion = new conexion();
    $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion')";
    $objConexion->ejecutar($sql);
    // Cuando inserte se redirecciona a la pagina de portafolio
    header("Location: portafolio.php");
}
if ($_GET) {
    // DELETE FROM `proyectos` WHERE `proyectos`.`id` = 11
    $id = $_GET["borrar"];
    $objConexion = new conexion();

    $imagen = $objConexion->consultar("SELECT imagen FROM `proyectos` WHERE `id` = $id");
    // unlink elimina el archivo
    unlink("imagenes/" . $imagen[0]["imagen"]);
    $sql = "DELETE FROM `proyectos` WHERE `proyectos`.`id` = " . $id;
    $objConexion->ejecutar($sql);
    // Cuando elimine se redirecciona a la pagina de portafolio
    header("Location: portafolio.php");
}

$objConexion = new conexion();
$proyectos = $objConexion->consultar("SELECT * FROM `proyectos`");
// print_r($resultado);
?>
<br>

<div class="container">
    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Datos del proyecto
                </div>
                <div class="card-body">
                    <form action="portafolio.php" method="post" enctype="multipart/form-data">
                        Nombre del proyecto: <input required class="form-control" type="text" name="nombre">
                        <br>
                        Imagen del proyecto: <input required class="form-control" type="file" name="archivo">
                        <br>
                        <div class="mb-3">
                            Descripción:
                            <label for="" class="form-label"></label>
                            <textarea required class="form-control" name="descripcion" rows="3"></textarea>
                        </div>
                        <input class="btn btn-success" type="submit" value="Enviar proyecto">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del proyecto</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto) { ?>
                        <tr>
                            <td><?php echo $proyecto['id']; ?></td>
                            <td><?php echo $proyecto['nombre']; ?></td>
                            <td>

                                <img width="100" src="imagenes/<?php echo $proyecto['imagen']; ?>" alt="Imagen del proyecto">

                            </td>
                            <td><?php echo $proyecto['descripcion']; ?></td>
                            <td><a class="btn btn-danger" href="?borrar=<?php echo $proyecto['id']; ?>">Eliminar</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>








<?php include "pie.php" ?>