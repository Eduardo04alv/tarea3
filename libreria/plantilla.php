<?php
class Plantilla {
    public static function aplicar() {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <title>Bienvenida al Mundo Barbie</title>

           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" />

           <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

           <link rel="stylesheet" href="estilos.css">
        </head>
        <body>
          <nav class="navbar navbar-expand-lg" style="background-color: #e0218a;">
            <div class="container">
              <a class="navbar-brand text-white fw-bold" href="#">🌟 Mundo Barbie 🌟</a>
            </div>
          </nav>

          <div class="container mt-4">
            <h1 class="mb-3">Mundo Barbie</h1>
        <?php
    }
}
?>

