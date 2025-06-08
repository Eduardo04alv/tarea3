<?php
include('libreria/plantilla.php');
plantilla::aplicar();

$directorio = 'datos/';
$archivos = array_diff(scandir($directorio), ['.', '..']);

$total_personajes = 0;
$total_profesiones = 0;
$edad_total = 0;
$niveles_experiencia = [];
$categorias = [];
$salarios = [];
$salario_total = 0;
$personaje_salario_max = null;
$profesion_salario_max = null;
$profesion_salario_min = null;

foreach ($archivos as $archivo) {
    $ruta = $directorio . $archivo;
    $datos = json_decode(file_get_contents($ruta), true);
    $total_personajes++;

    if (!empty($datos['Fecha_de_nacimiento'])) {
        $nacimiento = new DateTime($datos['Fecha_de_nacimiento']);
        $hoy = new DateTime();
        $edad = $hoy->diff($nacimiento)->y;
        $edad_total += $edad;
    }

    $nivel = $datos['Nivel_de_experiencia'] ?? 'No especificado';
    $niveles_experiencia[$nivel] = ($niveles_experiencia[$nivel] ?? 0) + 1;

    if (!empty($datos['Profesiones'])) {
        foreach ($datos['Profesiones'] as $profesion) {
            $total_profesiones++;

            $categoria = $profesion['Categoría'] ?? 'Sin categoría';
            $salario = floatval($profesion['Salario'] ?? 0);

            $categorias[$categoria] = ($categorias[$categoria] ?? 0) + 1;
            $salarios[$categoria][] = $salario;
            $salario_total += $salario;

            if (!$profesion_salario_max || $salario > $profesion_salario_max['Salario']) {
                $profesion_salario_max = [
                    'Nombre' => $profesion['Nombre_de_la_profesión'],
                    'Salario' => $salario
                ];
            }

            if (!$profesion_salario_min || $salario < $profesion_salario_min['Salario']) {
                $profesion_salario_min = [
                    'Nombre' => $profesion['Nombre_de_la_profesión'],
                    'Salario' => $salario
                ];
            }

            if (!$personaje_salario_max || $salario > $personaje_salario_max['Salario']) {
                $personaje_salario_max = [
                    'Nombre' => $datos['Nombre'] . ' ' . $datos['Apellido'],
                    'Salario' => $salario
                ];
            }
        }
    }
}

$edad_promedio = $total_personajes > 0 ? round($edad_total / $total_personajes, 1) : 0;


$nivel_comun = array_search(max($niveles_experiencia), $niveles_experiencia);

$salario_promedio = $total_profesiones > 0 ? round($salario_total / $total_profesiones, 2) : 0;

$categorias_labels = json_encode(array_keys($salarios));
$categorias_promedios = json_encode(array_map(fn($s) => round(array_sum($s) / count($s), 2), $salarios));
?>

<style>
    body {
        background: linear-gradient(135deg, #ffe6f0, #fcd6ff);
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #880e4f;
        margin: 0;
        padding: 20px;
    }

    h1, h3 {
        color: #d81b60;
        font-weight: bold;
        text-shadow: 1px 1px 2px #fff;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
        background-color: #fff0f7;
        color: #880e4f;
    }

    .btn-barbie {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        border-radius: 25px;
        padding: 0.5rem 1.25rem;
        font-weight: bold;
        transition: 0.3s ease;
        cursor: pointer;
        border: none;
        display: inline-block;
        text-decoration: none;
    }

    .btn-barbie:hover {
        background-color: #ff1493;
        border-color: #ff1493;
        text-decoration: none;
        color: white;
    }

    .container {
        max-width: 900px;
        margin: auto;
    }

    /* Ajustes para el canvas gráfico */
    #graficoSalarios {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
        padding: 15px;
    }
</style>

<div class="container mt-4">
    <h1 class="mb-4">Panel de Control</h1>
    <div class="row g-3">
        <div class="col-md-4"><div class="card p-3 bg-light">Total de personajes: <strong><?= $total_personajes ?></strong></div></div>
        <div class="col-md-4"><div class="card p-3 bg-light">Total de profesiones: <strong><?= $total_profesiones ?></strong></div></div>
        <div class="col-md-4"><div class="card p-3 bg-light">Edad promedio: <strong><?= $edad_promedio ?></strong> años</div></div>

        <div class="col-md-6"><div class="card p-3 bg-light">Nivel de experiencia más común: <strong><?= $nivel_comun ?></strong></div></div>
        <div class="col-md-6"><div class="card p-3 bg-light">Salario promedio: <strong>$<?= $salario_promedio ?></strong></div></div>

        <div class="col-md-6"><div class="card p-3 bg-light">Profesión mejor pagada: <strong><?= $profesion_salario_max['Nombre'] ?> ($<?= $profesion_salario_max['Salario'] ?>)</strong></div></div>
        <div class="col-md-6"><div class="card p-3 bg-light">Profesión peor pagada: <strong><?= $profesion_salario_min['Nombre'] ?> ($<?= $profesion_salario_min['Salario'] ?>)</strong></div></div>

        <div class="col-md-12"><div class="card p-3 bg-light">Personaje con mejor salario: <strong><?= $personaje_salario_max['Nombre'] ?> ($<?= $personaje_salario_max['Salario'] ?>)</strong></div></div>
    </div>

    <div class="mt-5">
        <h3>Gráfico de salarios promedio por categoría</h3>
        <canvas id="graficoSalarios" height="100"></canvas>
    </div>

    <a href="index.php" class="btn-barbie mt-4">Volver al listado</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoSalarios').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $categorias_labels ?>,
        datasets: [{
            label: 'Salario promedio por categoría',
            data: <?= $categorias_promedios ?>,
            backgroundColor: 'rgba(255, 105, 180, 0.7)',
            borderColor: 'rgba(255, 20, 147, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
