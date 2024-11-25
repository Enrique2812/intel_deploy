<?php

namespace Controllers;

use MVC\Router;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Service\Sheets\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use Model\Alumno;
use Model\Aula;
use Model\Aula_personal_curso;
use Model\Grado;
use Model\Nivel;
use Model\Profesor;
use Model\Seccion;
use Model\Turno;
use Model\Usuario;
use Model\Curso;
use Model\Matricula;
use Model\Año;
use Model\Asistencia;
use Model\SheetAsistencia;
use Model\Horario;
use DateTime;

class AsistenciaController
{
    public static function alumno(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/asistencia/alumno', [
            'CurrentPage' => $CurrentPage
        ]);
    }
    public static function buscarPorCorreoYRangoFechas()
    {
        if (!isset($_SESSION['email'])) {
            echo "Error: No se encontró un email en la sesión.";
            exit;
        }

        $email = $_SESSION['email'];
        $fechaInicio = $_POST['fechaInicio'] ?? null;
        $fechaFin = $_POST['fechaFin'] ?? null;

        if (!$fechaInicio || !$fechaFin) {
            echo "Error: Las fechas de inicio y fin son requeridas.";
            exit;
        }

        $resultados = Asistencia::buscarPorCorreoYRangoFechas($email, $fechaInicio, $fechaFin);

        if ($resultados) {
            foreach ($resultados as $index => $fila) {
                echo "<tr>
                    <td><img class='rounded-circle' width='35' src='assets/images/profile/small/pic1.jpg' alt=''></td>
                    
                    <td>{$fila->fecha}</td>
                    <td>{$fila->hora_ingreso}</td>
                    <td>{$fila->tardanza}</td>
                    <td>{$fila->hora_salida}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
        }
    }


    public static function calendario(Router $router)
    {
        $CurrentPage = 'app-calender';

        $router->render('home/asistencia/calendario', [
            'CurrentPage' => $CurrentPage
        ]);
    }

    public static function diariototal(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $CurrentPage2 = 'form-pickers';

        $router->render('home/asistencia/diariototal', [
            'CurrentPage' => $CurrentPage,
            'CurrentPage2' => $CurrentPage2
        ]);
    }

    public static function cargarNivel()
    {
        error_log("Solicitud recibida en cargarNivel()");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                error_log("Intentando obtener niveles desde el modelo Nivel");

                $niveles = Nivel::obtenerNiveles();

                error_log("Niveles obtenidos correctamente: " . json_encode($niveles));

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $niveles]);
                return;
            } catch (Exception $e) {
                error_log("Error al obtener niveles: " . $e->getMessage());

                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al obtener niveles']);
                return;
            }
        }

        error_log("Método no permitido en cargarNivel()");
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    public static function buscarPorDia($router)
    {
        error_log("Método buscarPorDia() iniciado");

        $nivel = $_POST['nivel'] ?? null;
        $fecha = $_POST['fecha'] ?? null;

        // Registrar los datos recibidos
        error_log("Datos recibidos - Nivel: " . ($nivel ?? 'null') . ", Fecha: " . ($fecha ?? 'null'));

        if (!$nivel || !$fecha) {
            error_log("Faltan datos requeridos: nivel o fecha.");
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos requeridos: nivel o fecha.'
            ]);
            return;
        }

        try {
            error_log("Consultando asistencias para Nivel: $nivel, Fecha: $fecha");
            $resultados = Asistencia::buscarAsistenciaPorDia($nivel, $fecha);

            if (empty($resultados)) {
                error_log("No se encontraron asistencias para los criterios seleccionados.");
                echo json_encode([
                    'success' => true,
                    'data' => [],
                    'message' => 'No se encontraron asistencias para los criterios seleccionados.'
                ]);
                return;
            }

            error_log("Resultados encontrados: " . count($resultados));
            echo json_encode([
                'success' => true,
                'data' => $resultados
            ]);
        } catch (Exception $e) {
            error_log("Error al consultar asistencias: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error al consultar asistencias.'
            ]);
        }
    }
    public static function cargarAulasConSheets()
    {
        $aulasConSheets = SheetAsistencia::obtenerAulasConSheet();

        echo json_encode($aulasConSheets);
    }


    public static function general(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $gradoSeleccionado = $_GET['grado'] ?? null;
        $año = null;


        $grados = Grado::all();



        $aulas = $año ? Aula::allByIdAño($año->id) : Aula::all();

        $aulasGoogleSheet = [];
        foreach ($aulas as $aula) {
            $sheet = SheetAsistencia::buscarPorAula($aula->id);
            $aulasGoogleSheet[$aula->id] = $sheet ? $sheet->googleSheetID : null;
        }

        $alumnosPorAula = [];
        foreach ($aulas as $aula) {
            $alumnosAsignados = Alumno::obtenerAlumnoAula($aula->id);
            $alumnosPorAula[$aula->id] = $alumnosAsignados;
        }

        // Cargar la vista sin realizar búsqueda inicialmente
        $router->render('home/asistencia/general', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'aulasGoogleSheet' => $aulasGoogleSheet,
            'alumnosPorAula' => $alumnosPorAula,
            'grados' => $grados,
        ]);
    }
    public static function obtenerAulasPorGrado()
    {
        $idGrado = $_GET['idGrado'] ?? null;

        if ($idGrado) {
            $aulas = Aula::allByGrado($idGrado);

            if ($aulas) {
                echo json_encode($aulas);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode(['error' => 'ID de grado no válido']);
        }
    }

    public static function buscarGeneral()
    {
        $fechaInicio = $_GET['fechaInicio'] ?? null;
        $fechaFin = $_GET['fechaFin'] ?? null;
        $idGrado = $_GET['grado'] ?? null;
        $idAula = $_GET['aula'] ?? null;
        $alumnoDNI = $_GET['alumnoDNI'] ?? null; // Obteniendo el DNI del alumno

        error_log("Parámetros recibidos: fechaInicio: $fechaInicio, fechaFin: $fechaFin, idGrado: $idGrado, idAula: $idAula, alumnoDNI: $alumnoDNI");

        if ($fechaInicio) {
            $fechaInicio = DateTime::createFromFormat('Y-m-d', $fechaInicio);
            $fechaInicio = $fechaInicio ? $fechaInicio->format('Y-m-d') : null;
        }

        if ($fechaFin) {
            $fechaFin = DateTime::createFromFormat('Y-m-d', $fechaFin);
            $fechaFin = $fechaFin ? $fechaFin->format('Y-m-d') : null;
        }

        $resultados = Asistencia::buscarGeneral($idGrado, $idAula, $fechaInicio, $fechaFin);

        $html = '';
        if (!empty($resultados)) {
            foreach ($resultados as $index => $resultado) {
                // Filtrar por DNI solo si se ha proporcionado un valor
                if ($alumnoDNI && $resultado->dni !== $alumnoDNI) {
                    continue; // Omitir el resultado si no coincide el DNI
                }

                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($resultado->dni ?? '') . '</td>'; // DNI
                $html .= '<td>' . htmlspecialchars(($resultado->nombre ?? '') . ' ' . ($resultado->apellidos ?? '')) . '</td>'; // Nombre completo
                $html .= '<td>' . htmlspecialchars($resultado->hora_ingreso ?? '') . '</td>'; // Tardanza
                $html .= '<td>' . htmlspecialchars($resultado->tardanza ?? '') . '</td>'; // Tardanza
                $html .= '<td>' . htmlspecialchars($resultado->hora_salida ?? '') . '</td>'; // Tardanza
               
                
                $html .= '</tr>';
            }
        } else {
            $html = '<tr><td colspan="6" class="text-center">No se encontraron resultados.</td></tr>';
        }

        echo $html;
    }



    public static function escribirAsistenciaEnCelda($service, $spreadsheetId)
    {
        $range = 'Hoja 1!B2:AX2';

        $values = [
            ['ASISTENCIA'],
            ['Apellidos y nombres'] // Texto a poner en las celdas unidas
        ];
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $requests = [
            new Request([
                'mergeCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 1,
                        'endRowIndex' => 2,
                        'startColumnIndex' => 1,
                        'endColumnIndex' => 48
                    ],
                    'mergeType' => 'MERGE_ALL'
                ]
            ]),
            new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 1,
                        'endRowIndex' => 2,
                        'startColumnIndex' => 1,
                        'endColumnIndex' => 48
                    ],
                    'rows' => [
                        [
                            'values' => [
                                [
                                    'userEnteredValue' => ['stringValue' => 'ASISTENCIA'],
                                    'userEnteredFormat' => [
                                        'horizontalAlignment' => 'CENTER',
                                        'verticalAlignment' => 'MIDDLE',
                                        'textFormat' => [
                                            'bold' => true,
                                            'foregroundColor' => [
                                                'red' => 1.0,
                                                'green' => 1.0,
                                                'blue' => 1.0
                                            ]
                                        ],
                                        'backgroundColor' => [
                                            'red' => 0.0,
                                            'green' => 0.5,
                                            'blue' => 1.0
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'fields' => 'userEnteredValue,userEnteredFormat(horizontalAlignment,verticalAlignment,textFormat,backgroundColor)'
                ]
            ]),
            new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 3,    // Fila 4 (índice 3)
                        'endRowIndex' => 4,      // Hasta Fila 4
                        'startColumnIndex' => 0, // Columna A (índice 0)
                        'endColumnIndex' => 1    // Columna A
                    ],
                    'rows' => [
                        [
                            'values' => [
                                [
                                    'userEnteredValue' => ['stringValue' => 'Apellidos y nombres'],
                                    'userEnteredFormat' => [
                                        'horizontalAlignment' => 'CENTER',
                                        'verticalAlignment' => 'MIDDLE'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'fields' => 'userEnteredValue,userEnteredFormat(horizontalAlignment,verticalAlignment)'
                ]
            ]),


            // Cambiar el color de fondo a azul
            new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 1, // Fila 2
                        'endRowIndex' => 2, // Fila 2
                        'startColumnIndex' => 1, // Columna B
                        'endColumnIndex' => 48 // Columna AX
                    ],
                    'rows' => [
                        [
                            'values' => [
                                [
                                    'userEnteredFormat' => [
                                        'backgroundColor' => [
                                            'red' => 0.0,
                                            'green' => 0.0,
                                            'blue' => 1.0 // Azul
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'fields' => 'userEnteredFormat(backgroundColor)'
                ]

            ]),
            new Request([
                'updateDimensionProperties' => [
                    'range' => [
                        'sheetId' => 0,
                        'dimension' => 'COLUMNS',
                        'startIndex' => 1, // Columna B (índice 1)
                        'endIndex' => 48 // Columna AX (índice 48)
                    ],
                    'properties' => [
                        'pixelSize' => 30
                    ],
                    'fields' => 'pixelSize'
                ]
            ]),


        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }
    public static function escribirSemanasYDias($service, $spreadsheetId)
    {
        $startingRow = 2;
        $startingColumn = 2;

        $values = [];
        $weeks = 9;

        for ($week = 1; $week <= $weeks; $week++) {
            for ($day = 1; $day <= 5; $day++) {
                $dayName = ['lun', 'mar', 'mié', 'jue', 'vie'][$day - 1];
                $values[] = "S{$week} - {$dayName}";
            }
        }

        $body = new ValueRange([
            'values' => [$values]
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $range = 'Hoja 1!B3:AX3';
        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        $requests = [];
        $endColumn = $startingColumn + count($values) - 1; // Columna final con base en la cantidad de días

        for ($col = $startingColumn; $col <= $endColumn; $col++) {
            $requests[] = new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => $startingRow, // Fila 3
                        'endRowIndex' => $startingRow + 1, // Fila 3 (una sola fila)
                        'startColumnIndex' => $col - 1,
                        'endColumnIndex' => $col // Solo una columna
                    ],
                    'rows' => [
                        [
                            'values' => [
                                [
                                    'userEnteredFormat' => [
                                        'textRotation' => [
                                            'angle' => 90 // Rotación de 270 grados
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'fields' => 'userEnteredFormat(textRotation)'
                ]
            ]);
        }

        if (!empty($requests)) {
            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);
            $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
        }
    }


    public static function rotarTextoCeldas($service, $spreadsheetId)
    {
        $requests = [
            new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 1, // Fila 2
                        'endRowIndex' => 2, // Fila 2
                        'startColumnIndex' => 2, // Columna B
                        'endColumnIndex' => 48 // Columna AX
                    ],
                    'rows' => [
                        [
                            'values' => [
                                [
                                    'userEnteredValue' => ['stringValue' => 'ASISTENCIA'],
                                    'userEnteredFormat' => [
                                        'textRotation' => [
                                            'angle' => 90 // Rotación de 90 grados
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'fields' => 'userEnteredValue,userEnteredFormat(textRotation)'
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }
    public static function escribirAlumnosEnGoogleSheet($service, $spreadsheetId, $aulaId)
    {
        $alumnosAsignados = Alumno::obtenerAlumnoAula($aulaId);
        $usuarios = Usuario::all();
        $usuariosAsociados = array_column($usuarios, null, 'id');

        $alumnosValores = [];
        foreach ($alumnosAsignados as $alumno) {
            $usuario = $usuariosAsociados[$alumno->id_usuario] ?? null;

            if ($usuario) {
                $nombreCompleto = $usuario->apellidos . ' ' . $usuario->nombre;
                $alumnosValores[] = ['nombre_completo' => $nombreCompleto, 'usuario' => $usuario];
            } else {
                $alumnosValores[] = ['nombre_completo' => 'Sin Usuario', 'usuario' => null];
            }
        }

        usort($alumnosValores, function ($a, $b) {
            $apellidoA = isset($a['usuario']->apellidos) ? trim(strtolower($a['usuario']->apellidos)) : '';
            $apellidoB = isset($b['usuario']->apellidos) ? trim(strtolower($b['usuario']->apellidos)) : '';

            $apellidoA = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/', '', $apellidoA);
            $apellidoB = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/', '', $apellidoB);

            return strcmp($apellidoA, $apellidoB);
        });

        $values = [];
        foreach ($alumnosValores as $alumno) {
            $values[] = [$alumno['nombre_completo']];
        }

        $range = 'Hoja 1!A5:A' . (count($values) + 4); // +3 para ajustar a la fila 4

        $body = new ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
    }
    public static function escribirMesesyDias($service, $spreadsheetId, $fechaInicio)
    {
        $startingRow = 3; // Fila 4 en Google Sheets
        $startingColumn = 2; // Columna B

        $values = [];
        $weeks = 9;
        $fechaActual = new DateTime($fechaInicio);

        for ($week = 1; $week <= $weeks; $week++) {
            for ($day = 1; $day <= 5; $day++) {
                $values[] = $fechaActual->format('d / m');
                $fechaActual->modify('+1 day');

                if ($fechaActual->format('N') >= 6) {
                    $fechaActual->modify('next Monday');
                }
            }
        }

        $body = new ValueRange([
            'values' => [$values]
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $range = 'Hoja 1!B4:AX4';

        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        $requests = [
            new Request([
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'startRowIndex' => 3, // Comienza desde la fila 4
                        'startColumnIndex' => 1, // Comienza desde la columna B
                        'endColumnIndex' => 48,
                    ],
                    'rows' => [
                        [
                            'values' => array_map(function ($cell) {
                                return [
                                    'userEnteredFormat' => [
                                        'textRotation' => [
                                            'angle' => 90
                                        ]
                                    ]
                                ];
                            }, $values)
                        ]
                    ],
                    'fields' => 'userEnteredFormat.textRotation'
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }



    public static function vincularGoogleSheet(Router $router)
    {
        header('Content-Type: application/json');
        $aulaId = $_POST['aula_id'] ?? null;
        $googleSheetID = $_POST['googleSheetID'] ?? null;
        $fechaInicio = $_POST['fechaInicio'] ?? null;

        if ($aulaId && $googleSheetID && $fechaInicio) {
            $sheet = SheetAsistencia::buscarPorAula($aulaId);
            if ($sheet) {
                $sheet->googleSheetID = $googleSheetID;
                $sheet->guardar();
                $mensaje = "Vinculación actualizada correctamente.";
            } else {
                $newSheet = new SheetAsistencia();
                $newSheet->id_aula = $aulaId;
                $newSheet->googleSheetID = $googleSheetID;
                $newSheet->guardar();
                $mensaje = "Vinculación creada correctamente.";
            }

            $jsonPath = __DIR__ . '/intelweb2-440214-7d0b295c2de0.json';
            $client = new Client();
            $client->setApplicationName('Prueba de Conexión a Google Sheets');
            $client->setScopes([Sheets::SPREADSHEETS]);
            $client->setAuthConfig($jsonPath);

            $service = new Sheets($client);

            self::escribirAsistenciaEnCelda($service, $googleSheetID);
            self::escribirSemanasYDias($service, $googleSheetID);


            self::escribirAlumnosEnGoogleSheet($service, $googleSheetID, $aulaId);

            self::escribirMesesyDias($service, $googleSheetID, $fechaInicio);


            $aulas = Aula::all();
            $aulasGoogleSheet = [];
            foreach ($aulas as $aula) {
                $sheet = SheetAsistencia::buscarPorAula($aula->id);
                $aulasGoogleSheet[$aula->id] = $sheet ? $sheet->googleSheetID : null;
            }

            echo json_encode([
                'success' => true,
                'message' => $mensaje,
                'aulasGoogleSheet' => $aulasGoogleSheet
            ]);
        } else {
            $mensaje = "Por favor, completa todos los campos correctamente.";
            echo json_encode(['success' => false, 'message' => $mensaje]);
        }

        exit;
    }



    public static function horario(Router $router) 
    {
        $CurrentPage = 'table-datatable-basic';
        $error = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_nivel = $_POST['id_nivel'] ?? null;
            $descripcion = $_POST['Descripcion'] ?? '';
            $hora_inicio = $_POST['HoraIni'] ?? null;
            $hora_fin = $_POST['HoraFin'] ?? null;
            $horario_id = $_POST['horario_id'] ?? null; // Obtener el ID del horario
    
            error_log("POST data recibida: id_nivel=$id_nivel, descripcion=$descripcion, hora_inicio=$hora_inicio, hora_fin=$hora_fin, horario_id=$horario_id");
    
            if ($horario_id) {
                $horario = Horario::find($horario_id); // Buscar el horario por ID
                
    
                if ($horario) {
                    error_log("Horario encontrado: " . print_r($horario, true));
    
                    // Actualizar los campos
                    $horario->id_nivel = $id_nivel;
                    $horario->descripcion = $descripcion;
                    $horario->hora_inicio = $hora_inicio;
                    $horario->hora_fin = $hora_fin;
    
                    $resultado = $horario->actualizarH(); 
    
                    if ($resultado) {
                        error_log("Horario actualizado con éxito.");
                        header('Location: /asistencia/horario');
                        exit;
                    } else {
                        $error = "No se pudo actualizar el horario.";
                        error_log("Error al actualizar el horario: $error");
                    }
                } else {
                    $error = "No se encontró el horario con el ID $horario_id";
                    error_log("No se encontró el horario con el ID $horario_id");
                }
            } else {
                $nuevoHorario = new Horario([
                    'id_nivel' => $id_nivel,
                    'descripcion' => $descripcion,
                    'hora_inicio' => $hora_inicio,
                    'hora_fin' => $hora_fin
                ]);
    
                $resultado = $nuevoHorario->guardar();
    
                if ($resultado) {
                    error_log("Nuevo horario guardado con éxito.");
                    header('Location: /asistencia/horario');
                    exit;
                } else {
                    $error = "No se pudo guardar el horario.";
                    error_log("Error al guardar el nuevo horario: $error");
                }
            }
        }
    
        $horarios = Horario::todos();
    
        $router->render('home/asistencia/horario', [
            'CurrentPage' => $CurrentPage,
            'horarios' => $horarios,
            'error' => $error ?? null
        ]);
    }
    

    public static function registrar(Router $router)
    {
        date_default_timezone_set('America/Lima');
        $CurrentPage = 'table-datatable-basic';
        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;

        $fechaActual = date('Y-m-d');
        $asistenciasHoy = [];
        $mensaje = null;

        if (isset($_GET['aula_id']) && $_GET['aula_id'] !== "") {
            $aulaId = $_GET['aula_id'];

            $alumnosAsignados = Alumno::obtenerAlumnoAula($aulaId);

            foreach ($alumnosAsignados as $alumno) {
                $asistenciaHoy = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);
                if (!empty($asistenciaHoy)) {
                    $asistenciasHoy[$alumno->id] = $asistenciaHoy;
                }
            }
        }

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        $aulas = $año ? Aula::allByIdAño($año->id) : Aula::all();
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $turnos = Turno::all();
        $alumnos = Alumno::all();
        $usuarios = Usuario::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'] ?? null;
            $ingreso = isset($_POST['ingreso']);
            $salida = isset($_POST['salida']);
            $horaActual = date('H:i:s');

            $alumno = null;
            foreach ($usuarios as $usuario) {
                if ($usuario->dni === $dni) {
                    $alumno = Alumno::find($usuario->id);
                    break;
                }
            }

            error_log("Alumno encontrado: " . ($alumno ? "Sí" : "No"));

            if ($alumno) {
                if ($ingreso) {
                    $asistenciaExistente = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);
                    error_log("Ingreso detectado. Asistencia existente: " . (empty($asistenciaExistente) ? "No" : "Sí"));

                    if (empty($asistenciaExistente)) {
                        $horaEntradaPermitida = '07:30:00';
                        $tardanzaSegundos = max(0, strtotime($horaActual) - strtotime($horaEntradaPermitida));

                        $tardanzaFormato = gmdate('H:i:s', $tardanzaSegundos);

                        $asistencia = new Asistencia();
                        $asistencia->id_alumno = $alumno->id;
                        $asistencia->fecha = $fechaActual;
                        $asistencia->hora_ingreso = $horaActual;
                        $asistencia->tardanza = $tardanzaFormato;
                        $asistencia->guardar();
                        error_log("Asistencia registrada para el ingreso.");
                    }
                }

                if ($salida) {
                    $asistenciaExistenteArray = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);
                    error_log("Salida detectada. Asistencia existente: " . (is_array($asistenciaExistenteArray) && !empty($asistenciaExistenteArray) ? "Sí" : "No"));

                    if (is_array($asistenciaExistenteArray) && !empty($asistenciaExistenteArray)) {
                        $asistenciaExistente = new Asistencia($asistenciaExistenteArray[0]);
                        $asistenciaExistente->hora_salida = $horaActual;
                        $asistenciaExistente->actualizarHoraSalida();
                        error_log("Hora de salida registrada: " . $horaActual);
                    } else {
                        $mensaje = "No se encontró registro de asistencia para el alumno en la fecha indicada.";
                        error_log("Error: No se encontró asistencia para el alumno.");
                    }
                }
            } else {
                $mensaje = "El DNI ingresado no corresponde a un alumno de esta aula.";
                error_log("Error: Alumno no encontrado con el DNI proporcionado.");
            }
        }

        $router->render('home/asistencia/registrar', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'turnos' => $turnos,
            'alumnos' => $alumnos,
            'usuarios' => $usuarios,
            'selectedYear' => $selectedYear,
            'año' => $año,
            'mensaje' => $mensaje,
            'asistenciasHoy' => $asistenciasHoy
        ]);
    }

    public static function cambiarEstado(Router $router)
    {
        $spreadsheetId = '13hmXD6ek-5yzji2tintpRU6vPxjgIRTlOVCr_0iil7U';
        $range = 'Hoja 1!B1';
        $jsonPath = __DIR__ . '/intelweb2-440214-7d0b295c2de0.json';

        $client = new Client();
        $client->setApplicationName('Prueba de Conexión a Google Sheets');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($jsonPath);

        $service = new Sheets($client);

        $currentValue = self::obtenerValorCelda($service, $spreadsheetId, $range);
        $newValue = $currentValue === 'Sí' ? 'No' : 'Sí';

        $values = [
            [$newValue]
        ];
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];
        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        header('Content-Type: application/json');
        echo json_encode(['estadoCelda' => $newValue]);
        exit;
    }

    private static function obtenerValorCelda($service, $spreadsheetId, $range)
    {
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        return $values[0][0] ?? 'No';
    }

    public static function cargarAlumnos(Router $router)
    {
        date_default_timezone_set('America/Lima');
        $aulaId = $_GET['aula_id'] ?? null;
        $fechaActual = date('Y-m-d');

        // Verificar si la opción seleccionada es "todos"
        if ($aulaId === 'todos') {
            // Obtener todos los alumnos sin filtrar por aula
            $alumnosAsignados = Alumno::all();
        } elseif ($aulaId) {
            // Obtener solo los alumnos asignados al aula seleccionada
            $alumnosAsignados = Alumno::obtenerAlumnoAula($aulaId);
        } else {
            // Si no se seleccionó ningún aula, devolver un arreglo vacío
            echo json_encode([]);
            exit();
        }

        $usuarios = Usuario::all();
        $usuariosAsociados = array_column($usuarios, null, 'id');
        $response = [];
        $asistenciasHoy = [];

        foreach ($alumnosAsignados as $alumno) {
            $asistenciaHoy = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);
            if (!empty($asistenciaHoy)) {
                $asistenciasHoy[$alumno->id] = $asistenciaHoy;
            }
        }

        foreach ($alumnosAsignados as $alumno) {
            $usuario = $usuariosAsociados[$alumno->id_usuario] ?? null;
            $asistencia = $asistenciasHoy[$alumno->id] ?? null;

            // Inicializar variables con valores por defecto
            $fecha = isset($asistencia[0]['fecha']) ? $asistencia[0]['fecha'] : '-';
            $horaIngreso = isset($asistencia[0]['hora_ingreso']) ? $asistencia[0]['hora_ingreso'] : '-';
            $tardanza = isset($asistencia[0]['tardanza']) ? $asistencia[0]['tardanza'] : '0';
            $horaSalida = isset($asistencia[0]['hora_salida']) ? $asistencia[0]['hora_salida'] : '-';

            if ($usuario) {
                $nombreCompleto = $usuario->apellidos . ' ' . $usuario->nombre;
                $response[] = [
                    'dni' => $usuario->dni ?? 'Sin DNI',
                    'nombre' => htmlspecialchars($nombreCompleto),
                    'fecha' => htmlspecialchars($fecha),
                    'hora_ingreso' => htmlspecialchars($horaIngreso),
                    'tardanza' => htmlspecialchars($tardanza),
                    'hora_salida' => htmlspecialchars($horaSalida),
                ];
            }
        }

        usort($response, function ($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });

        echo json_encode($response);
        exit();
    }

    public static function registrarIngreso()
    {
        date_default_timezone_set('America/Lima');
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        $dni = $_POST['dni'] ?? null;

        $usuario = Usuario::findByDNI($dni);
        if ($usuario) {
            $alumno = Alumno::find($usuario->id);
            $matricula = Matricula::buscarPorAlumno($alumno->id);

            if ($matricula) {
                $idAula = $matricula->id_aula;
                $sheetAsistencia = SheetAsistencia::buscarPorAula($idAula);

                if ($sheetAsistencia) {
                    $spreadsheetId = $sheetAsistencia->googleSheetID;

                    $asistencia = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);
                    if (empty($asistencia)) {
                        $horaEntradaPermitida = '07:30:00';
                        $tardanzaSegundos = max(0, strtotime($horaActual) - strtotime($horaEntradaPermitida));
                        $tardanzaFormato = gmdate('H:i:s', $tardanzaSegundos);

                        $asistencia = new Asistencia();
                        $asistencia->id_alumno = $alumno->id;
                        $asistencia->fecha = $fechaActual;
                        $asistencia->hora_ingreso = $horaActual;
                        $asistencia->tardanza = $tardanzaFormato;
                        $asistencia->guardar();

                        // Enviar correo de confirmación
                        self::enviarCorreoAsistencia($usuario, $horaActual);

                        $jsonPath = __DIR__ . '/intelweb2-440214-7d0b295c2de0.json';
                        $client = new Client();
                        $client->setApplicationName('Registro de Asistencia');
                        $client->setScopes([Sheets::SPREADSHEETS]);
                        $client->setAuthConfig($jsonPath);
                        $service = new Sheets($client);

                        $columnaFechaHoy = self::buscarColumnaPorFecha($service, $spreadsheetId, $fechaActual);

                        $nombreCompleto = $usuario->apellidos . ' ' . $usuario->nombre;
                        $filaAlumno = self::buscarFilaPorNombre($service, $spreadsheetId, $nombreCompleto);

                        if ($filaAlumno && $columnaFechaHoy) {
                            $asistenciaTipo = (strtotime($horaActual) > strtotime($horaEntradaPermitida)) ? 'T' : 'A';

                            $range = "Hoja 1!{$columnaFechaHoy}{$filaAlumno}";

                            $values = [[$asistenciaTipo]];
                            $body = new ValueRange(['values' => $values]);
                            $params = ['valueInputOption' => 'USER_ENTERED'];
                            $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

                            echo json_encode(['status' => 'success', 'message' => 'Hora de ingreso registrada y Google Sheets actualizado.']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'No se encontró la fila del alumno o la columna de fecha en la hoja.']);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'El alumno ya tiene registro de ingreso para hoy.']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se encontró la hoja de asistencia para este aula.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontró la matrícula del alumno.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Alumno no encontrado.']);
        }
        exit;
    }
    public static function enviarCorreoAsistencia($usuario, $horaActual)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'david.toribio2610@gmail.com';
            $mail->Password = 'ckmlwyobvbckndyv'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('david.toribio2610@gmail.com', 'Sistema de Asistencia');

            if (isset($usuario->email) && filter_var($usuario->email, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($usuario->email, "{$usuario->nombre} {$usuario->apellidos}");
            } else {
                error_log("El usuario no tiene un correo electrónico válido.");
                return;
            }

            $mail->isHTML(true);
            $mail->Subject = 'Asistencia Registrada';
            $mail->Body = "Hola, la asistencia del alumno <strong>{$usuario->nombre} {$usuario->apellidos}</strong> fue registrada con éxito a las <strong>{$horaActual}</strong>.";

            if ($mail->send()) {
                error_log("Correo enviado con éxito.");
            } else {
                error_log("No se pudo enviar el correo: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            error_log("Excepción: " . $e->getMessage());
        }
    }




    private static function buscarColumnaPorFecha($service, $spreadsheetId, $fechaActual)
    {
        $range = "Hoja 1!B4:AX4";
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        $fechaFormateada = date('j / n', strtotime($fechaActual));

        if (!empty($values) && isset($values[0])) {
            foreach ($values[0] as $index => $fecha) {
                if ($fecha === $fechaFormateada) {
                    return chr(66 + $index);
                }
            }
        }
        return null;
    }

    private static function buscarFilaPorNombre($service, $spreadsheetId, $nombreCompleto)
    {
        $range = "Hoja 1!A4:A";

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (!empty($values)) {
            foreach ($values as $index => $row) {
                if (isset($row[0]) && $row[0] === $nombreCompleto) {
                    return $index + 4;
                }
            }
        }

        return null;
    }
    public static function registrarSalida()
    {
        date_default_timezone_set('America/Lima');
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');

        $dni = $_POST['dni'] ?? null;
        $usuarios = Usuario::all();
        $alumno = null;

        foreach ($usuarios as $usuario) {
            if ($usuario->dni === $dni) {
                $alumno = Alumno::find($usuario->id);
                break;
            }
        }

        if ($alumno) {
            $asistencia = Asistencia::buscarPorFechaYAlumno($fechaActual, $alumno->id);

            if (is_array($asistencia)) {
                $asistencia = new Asistencia($asistencia[0]);  // Convertir el primer elemento en un objeto
            }

            if (!empty($asistencia)) {
                $asistencia->hora_salida = $horaActual;

                if ($asistencia->actualizarHoraSalida()) {
                    echo json_encode(['status' => 'success', 'message' => 'Hora de salida registrada.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar la hora de salida.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontró el registro de ingreso para este alumno.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Alumno no encontrado.']);
        }

        exit;
    }
}
