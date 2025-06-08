<?php
include('libreria/plantilla.php');
plantilla::aplicar();

$personaje_id = $_GET['IDs'] ?? null;
$profesion_id = $_GET['IDProfesiones'] ?? null;
$ruta = "datos/$personaje_id.json";

if (!$personaje_id || !$profesion_id || !file_exists($ruta)) {
    die("Datos inválidos o archivo no encontrado.");
}

$contenido = file_get_contents($ruta);
$datos = json_decode($contenido, true);

$profesion = null;
foreach ($datos['Profesiones'] as $key => $p) {
    if ($p['id_Profesiones'] == $profesion_id) {
        $profesion = $p;
        $profesion_key = $key;
        break;
    }
}

if (!$profesion) {
    die("Profesión no encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $salario = $_POST['salario'] ?? '';

    if ($nombre !== '') $datos['Profesiones'][$profesion_key]['Nombre_de_la_profesión'] = $nombre;
    if ($categoria !== '') $datos['Profesiones'][$profesion_key]['Categoría'] = $categoria;
    if ($salario !== '') $datos['Profesiones'][$profesion_key]['Salario'] = $salario;

    file_put_contents($ruta, json_encode($datos, JSON_PRETTY_PRINT));
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
    <h2>Editar Profesión</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la profesión</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($profesion['Nombre_de_la_profesión']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo htmlspecialchars($profesion['Categoría']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="salario" class="form-label">Salario</label>
            <input type="number" id="salario" name="salario" class="form-control" value="<?php echo htmlspecialchars($profesion['Salario']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="Profesiones.php?ID=<?php echo htmlspecialchars($personaje_id); ?>" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
