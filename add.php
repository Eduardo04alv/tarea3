<?php
include('libreria/plantilla.php');
include('objeto.php');
plantilla::aplicar();

$Personajes = new Personajes();

if (!file_exists("datos")) {
    mkdir("datos", 0777, true);
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
    $json = json_encode($Personajes);

    file_put_contents($ruta, $json);

    plantilla::aplicar();
    echo "<div class='alert alert-success'>🎀 Personaje guardado correctamente 🎀</div>";
    echo "<a href='index.php' class='btn btn-barbie'>Volver</a>";
    exit();
}
?>

<style>
    body {
        background: linear-gradient(135deg, #ffe6f0, #fcd6ff);
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #880e4f;
        padding: 20px;
    }

    label {
        font-weight: bold;
        color: #d81b60;
    }

    input.form-control, select.form-select {
        border: 2px solid #ff69b4;
        border-radius: 10px;
        padding: 8px;
        font-size: 1rem;
        color: #880e4f;
    }

    input.form-control:focus, select.form-select:focus {
        border-color: #ff1493;
        box-shadow: 0 0 8px #ff1493;
        outline: none;
    }

    .btn-barbie {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
        transition: 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-barbie:hover {
        background-color: #ff1493;
        border-color: #ff1493;
        color: white;
        text-decoration: none;
    }

    .btn-success {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
        transition: 0.3s ease;
        margin-right: 10px;
    }

    .btn-success:hover {
        background-color: #ff1493;
        border-color: #ff1493;
        color: white;
    }

    .btn-secondary {
        background-color: #f8bbd0;
        border-color: #f8bbd0;
        color: #880e4f;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #d81b60;
        border-color: #d81b60;
        color: white;
    }

    .alert-success {
        background-color: #fce4ec;
        border: 1px solid #f48fb1;
        color: #880e4f;
        padding: 10px 15px;
        border-radius: 15px;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: center;
        box-shadow: 0 0 8px rgba(255, 105, 180, 0.3);
    }

    form {
        background-color: white;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
        max-width: 600px;
        margin: auto;
    }
</style>

<form method="post" action="add.php">
    <input type="hidden" name="Id" value="<?= $Personajes->Id ?>">

    <div class="mb-3">
        <label for="Id" class="form-label">Id</label>
        <input type="text" class="form-control" id="Id" name="Id" value="<?= $Personajes->Id ?>" required>
    </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?=  $Personajes->Nombre ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="Apellido" name="Apellido" value="<?= $Personajes->Apellido ?>" required>
    </div>

    <div class="mb-3">
        <label for="pais" class="form-label">Fecha de nacimiento</label>
        <input type="date" class="form-control" id="Fecha_de_nacimiento" name="Fecha_de_nacimiento" value="<?= $Personajes->Fecha_de_nacimiento ?>">
    </div>
    <div class="mb-3">
        <label for="Foto" class="form-label">Foto URL</label>
        <input type="text" class="form-control" id="Foto" name="Foto" value="<?= $Personajes->Foto ?>">
    </div>

    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="Nivel_de_experiencia" name="Nivel_de_experiencia">
            <option value="">Selecciona</option>
            <?php
            foreach (Datos::Nivel_de_experiencia() as $key => $value) {
                $selected = ($obra->tipo == $key) ? 'selected' : '';
                echo "<option value='$key' $selected>$value</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>