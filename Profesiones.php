<?php
include('libreria/plantilla.php');
plantilla::aplicar();

$profecion_id = $_GET['ID'] ?? null;
$ruta_pr = "datos/$profecion_id.json";
$mensaje = "";

if (empty($profecion_id)) {
    echo "<div class='container mt-4'>
            <div class='alert alert-warning' role='alert'>
                Por favor, selecciona un Personaje para ver sus Profesiones.
                <a href='index.php' class='alert-link'>Volver a la lista de obras</a>.
            </div>
          </div>";
    exit();
}

$obra_data = null;
$Profesiones = [];

if (file_exists($ruta_pr)) {
    $contenido_obra = file_get_contents($ruta_pr);
    $obra_data = json_decode($contenido_obra);

    if ($obra_data && isset($obra_data->Profesiones) && is_array($obra_data->Profesiones)) {
        $Profesiones = $obra_data->Profesiones;
    }
}
?>

<style>
    body {
        background: linear-gradient(135deg, #ffe6f0, #fcd6ff);
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #880e4f;
    }

    h1 {
        color: #d81b60;
        font-weight: bold;
        text-shadow: 1px 1px 2px #fff;
    }

    .btn-barbie {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        border-radius: 25px;
        transition: 0.3s ease;
    }

    .btn-barbie:hover {
        background-color: #ff1493;
        border-color: #ff1493;
    }

    table {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
    }

    thead {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .table td img {
        border-radius: 10px;
        box-shadow: 0 0 5px #ffb6c1;
    }

    .acciones a {
        margin: 2px;
    }

    .text-and {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Profesiones del personaje <?php echo htmlspecialchars($profecion_id); ?></h2>

    <div class="text-end mb-3">
        <a href="add_Profesiones.php?ID=<?php echo htmlspecialchars($profecion_id); ?>" class="btn btn-primary">Agregar Profesión</a>
    </div>

    <div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la profesión</th>
                    <th>Categoría</th>
                    <th>Salario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($Profesiones)) {
                    foreach ($Profesiones as $profesion) {
                        echo "<tr>";
                        echo "<td> {$profesion->id_Profesiones}</td>";
                        echo "<td> {$profesion->Nombre_de_la_profesión}</td>";
                        echo "<td> {$profesion->Categoría}</td>";
                        echo "<td> {$profesion->Salario}</td>";
                        echo "<td>
                        <a href='editar_Profesiones.php?IDs={$profecion_id}&IDProfesiones={$profesion->id_Profesiones}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='eliminar_Profesiones.php?IDs={$profecion_id}&IDProfesiones={$profesion->id_Profesiones}' class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay Profesiones registradas para este personaje.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
