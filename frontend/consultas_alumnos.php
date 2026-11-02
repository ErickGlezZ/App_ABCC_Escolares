<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultas de alumnos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f4f6f9;
        font-family: Arial, sans-serif;
    }

    .contenedor {
        max-width: 1200px;
        margin: 35px auto;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
    }

    .titulo {
        color: #243447;
        font-weight: 700;
    }

    .subtitulo {
        color: #718096;
        font-size: 14px;
    }

    .form-label {
        font-weight: 600;
        color: #465568;
        font-size: 14px;
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border-radius: 7px;
    }

    .btn {
        border-radius: 7px;
    }

    .table thead th {
        background-color: #26384d;
        color: white;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 14px;
    }

    .seccion-titulo {
        font-weight: 700;
        color: #34465a;
        font-size: 16px;
    }

    .contador {
        background-color: #e8eef5;
        color: #34465a;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
    }
    </style>
</head>


<?php require_once('menu_principal.php'); ?>


<body>

    <div class="container contenedor">

        <!-- ENCABEZADO -->
        <div class="mb-4">
            <h3 class="titulo mb-1">Consultas de alumnos</h3>
            <p class="subtitulo mb-0">
                Consulta y localiza registros mediante diferentes criterios de búsqueda.
            </p>
        </div>

        <!-- PANEL DE FILTROS -->
        <div class="card mb-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div>
                        <h5 class="seccion-titulo mb-1">
                            <i class="bi bi-funnel"></i> Filtros de búsqueda
                        </h5>
                        <small class="text-secondary">
                            Introduce uno o varios criterios para consultar alumnos.
                        </small>
                    </div>
                </div>

                <!-- <form id="formConsultas" action="../backend/scripts/procesar_consultas.php" method="POST"> -->
                <form id="formConsultas">

                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <label for="nc" class="form-label">
                                Número de control
                            </label>

                            <input type="text" class="form-control" id="nc" name="nc" placeholder="Ej. 22010001">
                        </div>

                        <div class="col-md-4">
                            <label for="nombre" class="form-label">
                                Nombre(s)
                            </label>

                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Nombre del alumno">
                        </div>

                        <div class="col-md-4">
                            <label for="primer_ap" class="form-label">
                                Primer apellido
                            </label>

                            <input type="text" class="form-control" id="primer_ap" name="primer_ap"
                                placeholder="Primer apellido">
                        </div>

                    </div>

                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <label for="segundo_ap" class="form-label">
                                Segundo apellido
                            </label>

                            <input type="text" class="form-control" id="segundo_ap" name="segundo_ap"
                                placeholder="Segundo apellido">
                        </div>

                        <div class="col-md-4">
                            <label for="fecha_nac" class="form-label">
                                Fecha de nacimiento
                            </label>

                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                        </div>

                        <div class="col-md-4">
                            <label for="semestre" class="form-label">
                                Semestre
                            </label>

                            <select class="form-select" id="semestre" name="semestre">

                                <option value="">Todos los semestres</option>
                                <option value="1">1° semestre</option>
                                <option value="2">2° semestre</option>
                                <option value="3">3° semestre</option>
                                <option value="4">4° semestre</option>
                                <option value="5">5° semestre</option>
                                <option value="6">6° semestre</option>
                                <option value="7">7° semestre</option>
                                <option value="8">8° semestre</option>
                                <option value="9">9° semestre</option>

                            </select>
                        </div>

                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label for="carrera" class="form-label">
                                Carrera
                            </label>

                            <select class="form-select" id="carrera" name="carrera">

                                <option value="">Todas las carreras</option>
                                <option value="ISC">
                                    Ingeniería en Sistemas Computacionales
                                </option>
                                <option value="IM">
                                    Ingeniería Mecatronica
                                </option>
                                <option value="IIA">
                                    Ingeniería en Industrias Alimentarias
                                </option>
                                <option value="IA">
                                    Licenciatura en Administración
                                </option>
                                <option value="CP">
                                    Contador Público
                                </option>


                            </select>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <button type="reset" class="btn btn-outline-secondary px-4">
                            Limpiar Campos
                        </button>

                        <button type="submit" class="btn btn-primary px-4">
                            Buscar alumnos
                        </button>

                    </div>

                </form>

            </div>
        </div>

        <div class="card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                    <div>
                        <h5 class="seccion-titulo mb-1">
                            Resultados de búsqueda
                        </h5>

                        <small class="text-secondary">
                            Registros que coinciden con los filtros seleccionados.
                        </small>
                    </div>

                    <span class="contador" id="contadorResultados">
                        Resultados: 0
                    </span>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle mb-0">

                        <thead>
                            <tr>
                                <th>N° Control</th>
                                <th>Nombre</th>
                                <th>Primer apellido</th>
                                <th>Segundo apellido</th>
                                <th>Fecha de nacimiento</th>
                                <th>Semestre</th>
                                <th>Carrera</th>
                            </tr>
                        </thead>

                        <tbody id="tablaResultados">

                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">
                                    Realiza una búsqueda para consultar alumnos.
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const formulario = document.getElementById('formConsultas');
    const tablaResultados = document.getElementById('tablaResultados');
    const contador = document.getElementById('contadorResultados');

    formulario.addEventListener('submit', function(e) {
        e.preventDefault();
        const datos = new FormData(formulario);

        fetch('../backend/scripts/procesar_consultas.php', {
            method: 'POST',
            body: datos
        })
            .then(async respuesta => {
                const resultado = await respuesta.json();
                if (!respuesta.ok) {
                    throw new Error(resultado.error || 'Ocurrió un error al realizar la consulta.');
                }
                if (!Array.isArray(resultado)) {
                    throw new Error(resultado.error || 'La respuesta del servidor no es válida.');
                }
                return resultado;
            })
            .then(alumnos => {
                tablaResultados.replaceChildren();
                contador.textContent = 'Resultados: ' + alumnos.length;

                if (alumnos.length === 0) {
                    mostrarMensaje('No se encontraron alumnos.', 'text-secondary');
                    return;
                }

                alumnos.forEach(alumno => {
                    const fila = document.createElement('tr');
                    [
                        alumno.Num_Control,
                        alumno.Nombre,
                        alumno.Primer_Ap,
                        alumno.Segundo_Ap,
                        alumno.Fecha_Nac,
                        alumno.Semestre,
                        alumno.Carrera
                    ].forEach(valor => {
                        const celda = document.createElement('td');
                        celda.textContent = valor ?? '';
                        fila.appendChild(celda);
                    });

                    tablaResultados.appendChild(fila);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                contador.textContent = 'Resultados: 0';
                mostrarMensaje(error.message, 'text-danger');
            });
    });

    formulario.addEventListener('reset', function() {
        mostrarMensaje('Realiza una búsqueda para consultar alumnos.', 'text-secondary');
        contador.textContent = 'Resultados: 0';
    });

    function mostrarMensaje(mensaje, clase) {
        const fila = document.createElement('tr');
        const celda = document.createElement('td');
        celda.colSpan = 7;
        celda.className = 'text-center py-4 ' + clase;
        celda.textContent = mensaje;
        fila.appendChild(celda);
        tablaResultados.replaceChildren(fila);
    }

   
    </script>




</body>

</html>