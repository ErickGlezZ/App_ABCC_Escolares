<?php
  session_start();
  if(!$_SESSION['usuario_autenticado']){
    header('location: login.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="menu_principal.php">ITSJ</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="formulario_altas.php">AGREGAR <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="bajas_cambios.php">ELIMINAR/MODIFICAR</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../frontend/consultas_alumnos.php">BUSQUEDAS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled text-primary text-opacity-100" href="#">BIENVENIDO <?php echo $_SESSION['nombre_usuario']  ?> </a>
      </li>
    </ul>
    <form action="../backend/scripts/cerrar_sesion.php" class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">CERRAR SESION</button>
    </form>
  </div>
</nav>
    </div>
</body>
</html>