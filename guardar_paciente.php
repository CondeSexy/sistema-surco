<?php
header('Content-Type: application/json');

// Obtener los datos JSON enviados por JavaScript
$input = file_get_contents('php://input');
$nuevoPaciente = json_decode($input, true);

if ($nuevoPaciente && !empty($nuevoPaciente['cedula'])) {
    $archivo = 'pacientes.json';
    
    // Leer los registros existentes o iniciar un arreglo vacío
    $pacientes = [];
    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        $pacientes = json_decode($contenido, true) ?: [];
    }
    
    // Agregar el nuevo paciente al arreglo
    $pacientes[] = $nuevoPaciente;
    
    // Guardar de vuelta en el archivo JSON con formato legible
    if (file_put_contents($archivo, json_encode($pacientes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode(['status' => 'success', 'message' => 'Paciente guardado correctamente en el sistema.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo escribir en el archivo del sistema.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o inválidos.']);
}
?>