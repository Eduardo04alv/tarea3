<?php
include('libreria/plantilla.php');
plantilla::aplicar();

$personajeId = $_GET['IDs'] ?? null;
$profesionId = $_GET['IDProfesiones'] ?? null;

if (!$personajeId || !$profesionId) {
    echo "<div class='alert alert-warning mt-4'>ID no especificado.</div>";
    echo "<a href='index.php' class='btn btn-primary mt-3'>Volver al inicio</a>";
    exit();
}

$rutaArchivo = "datos/$personajeId.json";
$profesion = null;

if (file_exists($rutaArchivo)) {
    $contenido = file_get_contents($rutaArchivo);
    $data = json_decode($contenido);

    if ($data && isset($data->Profesiones)) {
        foreach ($data->Profesiones as $p) {
            if ($p->id_Profesiones == $profesionId) {
                $profesion = $p;
                break;
            }
        }
    }
}
if (!$profesion) {
    echo "<div class='alert alert-danger mt-4'>La profesión no existe.</div>";
    echo "<a href='index.php' class='btn btn-primary mt-3'>Volver al inicio</a>";
    exit();
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
    <div class="alert alert-warning">
        <h4>¿Estás seguro que deseas eliminar esta profesión?</h4>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($profesion->Nombre_de_la_profesión); ?></p>
        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($profesion->Categoría); ?></p>
        <p><strong>Salario:</strong> <?php echo htmlspecialchars($profesion->Salario); ?></p>
    </div>

    <form method="POST" action="eliminar_Profesiones.php">
        <input type="hidden" name="IDs" value="<?php echo htmlspecialchars($personajeId); ?>">
        <input type="hidden" name="IDProfesiones" value="<?php echo htmlspecialchars($profesionId); ?>">
        <button type="submit" class="btn btn-danger">Confirmar eliminación</button>
        <a href="ver_profesiones.php?ID=<?php echo $personajeId; ?>" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
