<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>
<body>
    
  <?php
    require_once __DIR__ . '/../backend/controllers/alumno_dao.php';

    if (!isset($_GET['nc'])) {
    exit('No se recibió el número de control.');
    }

    $nc = $_GET['nc'];

    $alumnoDAO = new AlumnoDAO();

   

    $datos = $alumnoDAO->consultarAlumno($nc);

    $alumno = mysqli_fetch_assoc($datos);

    if (!$alumno) {
    exit('No se encontró el alumno.');
    }
  ?>

    <div class="container">
        <form action="../backend/scripts/procesar_cambios.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="caja_num_control">Numero de control:</label>
      <input type="text" class="form-control" name = "caja_num_control" id="caja_num_control" placeholder="Numero de Control"
      value="<?= htmlspecialchars($alumno['Num_Control']) ?>" readonly>
    </div>
    
  </div>
  <div class="form-group">
    <label for="caja_nombre">Nombre:</label>
    <input type="text" class="form-control" name="caja_nombre" id="caja_nombre" placeholder="Nombre"
    value="<?= htmlspecialchars($alumno['Nombre']) ?>">
  </div>
  <div class="form-group">
    <label for="caja_primer_ap">Primer Apellido</label>
    <input type="text" class="form-control" name="caja_primer_ap" id="caja_primer_ap" placeholder="Primer Apellido"
    value="<?= htmlspecialchars($alumno['Primer_Ap']) ?>">
  </div>
  <div class="form-group">
    <label for="caja_segundo_ap">Segundo Apellido</label>
    <input type="text" class="form-control" name="caja_segundo_ap" id="caja_segundo_ap" placeholder="Segundo Apellido"
    value="<?= htmlspecialchars($alumno['Segundo_Ap']) ?>">
  </div>
  
  <div class="form-group">
    <label for="caja_fecha_nac">Fecha nacimiento</label>
    <input type="text" class="form-control" name="caja_fecha_nac" id="caja_fecha_nac" placeholder="0000/00/00"
    value="<?= htmlspecialchars($alumno['Fecha_Nac']) ?>">
  </div>
  
  <div class="form-group">
    <label for="caja_semestre">Semestre</label>
    <input type="text" class="form-control" name="caja_semestre" id="caja_semestre" placeholder="7"
    value="<?= htmlspecialchars($alumno['Semestre']) ?>">
  </div>

  <div class="form-group">
    <label for="caja_carrera">Carrera</label>
    <input type="text" class="form-control" name="caja_carrera" id="caja_carrera" placeholder="ISC"
    value="<?= htmlspecialchars($alumno['Carrera']) ?>">
  </div>

  <button type="submit" class="btn btn-primary">EDITAR</button>
</form>
    </div>


</body>
</html>