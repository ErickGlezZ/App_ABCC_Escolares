<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Registros</title>
</head>
<body>

    <?php require_once('menu_principal.php'); ?>

    <h3>Listado de Alumnos</h3>

    <?php  
        //include_once('../backend/controllers/alumno_dao.php');
        require_once __DIR__ . '/../backend/controllers/alumno_dao.php';
        $alumnoDAO = new AlumnoDAO();

        $datos = $alumnoDAO->mostrarAlumnos('x');

        if (isset($_GET['nc'])) {
            $nc = $_GET['nc'];

            $resultado = $alumnoDAO->consultarAlumno($nc);
            $alumno = mysqli_fetch_assoc($resultado);
        }



        $i = 0;
        if(mysqli_num_rows($datos) == 0){
            echo "No se encontraron registros";
        }else{

            echo '<div class= "container">';
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
                echo '<th scope="col">No. </th>';
                echo '<th scope="col">Num. Control. </th>';
                echo '<th scope="col">Nombre. </th>';
                echo '<th scope="col">Primer_Ap. </th>';
                echo '<th scope="col">Segundo_Ap. </th>';
                echo '<th scope="col">ACCIONES </th>';
            echo '</tr>';
            echo '</thead>';

            echo '<tbody>';

            while($fila = mysqli_fetch_assoc($datos)){
                $i++;
                printf( "<tr> <td>" . $i . "</td>
                              <td>".$fila['Num_Control']."</td>
                              <td>".$fila['Nombre']."</td>
                              <td>".$fila['Primer_Ap']."</td>
                              <td>".$fila['Segundo_Ap']."</td>

                              <td>
                                <button type='button'
                                        class='btn btn-primary btn-sm btn-detalles'
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalDetalles'
                                        data-nc='%s'>
                                    DETALLES
                                </button> |

                                <a href='../frontend/formulario_cambios.php?nc=%s'
                                class='btn btn-warning btn-sm'>EDITAR</a> |

                                <a href='../backend/scripts/procesar_baja.php?nc=%s'
                                class='btn btn-danger btn-sm'>ELIMINAR</a>
                              </td>"
                 , rawurlencode($fila['Num_Control']), rawurlencode($fila['Num_Control']), rawurlencode($fila['Num_Control']));

                }
                $i=0;
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
        

    ?>



    
    <div class="modal fade" id="modalDetalles" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detalles del alumno</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Número de control:</strong> <span id="nc"></span></p>
                    <p><strong>Nombre:</strong> <span id="nombre"></span></p>
                    <p><strong>Primer apellido:</strong> <span id="primerAp"></span></p>
                    <p><strong>Segundo apellido:</strong> <span id="segundoAp"></span></p>
                    <p><strong>Fecha de nacimiento:</strong> <span id="fechaNac"></span></p>
                    <p><strong>Semestre:</strong> <span id="semestre"></span></p>
                    <p><strong>Carrera:</strong> <span id="carrera"></span></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.btn-detalles').forEach(boton => {

        boton.addEventListener('click', async function () {

            const nc = this.dataset.nc;

            try {
                const respuesta = await fetch(
                    '../backend/scripts/procesar_consultas.php?nc='
                    + encodeURIComponent(nc)
                );

                const alumno = await respuesta.json();

                if (alumno.error) {
                    alert(alumno.error);
                    return;
                }

                document.getElementById('nc').textContent =
                    alumno.Num_Control ?? '';

                document.getElementById('nombre').textContent =
                    alumno.Nombre ?? '';

                document.getElementById('primerAp').textContent =
                    alumno.Primer_Ap ?? '';

                document.getElementById('segundoAp').textContent =
                    alumno.Segundo_Ap ?? '';

                document.getElementById('fechaNac').textContent =
                    alumno.Fecha_Nac ?? '';

                document.getElementById('semestre').textContent =
                    alumno.Semestre ?? '';

                document.getElementById('carrera').textContent =
                    alumno.Carrera ?? '';

                const elementoModal =
                    document.getElementById('modalDetalles');

                const modal =
                    bootstrap.Modal.getOrCreateInstance(elementoModal);

                modal.show();

            } catch (error) {
                console.error(error);
                alert('Ocurrió un error al consultar al alumno.');
            }

        });

    });
    </script>



</body>
</html>