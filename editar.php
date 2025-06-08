<?php 
include('libreria/plantilla.php');
include('objeto.php');
plantilla::aplicar();

$Id = $_GET['ID'] ?? null;
$ruta = "datos/$Id.json";

$Personajes = new Personajes();

if ($Id && file_exists($ruta)) {
    $json = file_get_contents($ruta);
    $Personajes = json_decode($json);
}
if ($_POST) {
    $Personajes->Id = $_POST['Id'];
    $Personajes->Nombre = $_POST['Nombre'];
    $Personajes->Apellido = $_POST['Apellido'];
    $Personajes->Fecha_de_nacimiento = $_POST['Fecha_de_nacimiento'];
    $Personajes->Foto = $_POST['Foto'];
    $Personajes->Nivel_de_experiencia = $_POST['Nivel_de_experiencia'];

    if (!is_dir('datos')) {
        mkdir('datos');
    }

    $ruta = 'datos/' . $Personajes->Id . '.json';
    $json = json_encode($Personajes, JSON_PRETTY_PRINT);

    file_put_contents($ruta, $json);

    echo "<div class='alert alert-success'>Personaje guardado correctamente</div>";
    echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
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

<form method="post" action="">
    <body>
    <input type="hidden" name="Id" value="<?= htmlspecialchars($Personajes->Id) ?>">

    <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?= htmlspecialchars($Personajes->Nombre) ?>" required>
    </div>

    <div class="mb-3">
        <label for="Apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="Apellido" name="Apellido" value="<?= htmlspecialchars($Personajes->Apellido) ?>" required>
    </div>

    <div class="mb-3">
        <label for="Fecha_de_nacimiento" class="form-label">Fecha de nacimiento</label>
        <input type="date" class="form-control" id="Fecha_de_nacimiento" name="Fecha_de_nacimiento" value="<?= htmlspecialchars($Personajes->Fecha_de_nacimiento) ?>">
    </div>

    <div class="mb-3">
        <label for="Foto" class="form-label">Foto URL</label>
        <input type="text" class="form-control" id="Foto" name="Foto" value="<?= htmlspecialchars($Personajes->Foto) ?>">
    </div>

    <div class="mb-3">
        <label for="Nivel_de_experiencia" class="form-label">Nivel de experiencia</label>
        <select class="form-select" id="Nivel_de_experiencia" name="Nivel_de_experiencia">
            <option value="">Selecciona</option>
            <?php
            foreach (Datos::Nivel_de_experiencia() as $key => $value) {
                $selected = ($Personajes->Nivel_de_experiencia == $key) ? 'selected' : '';
                echo "<option value='$key' $selected>$value</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</body>
</form>
