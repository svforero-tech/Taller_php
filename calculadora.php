<?php
session_start();

require_once __DIR__ . '/clases/Calculadora.php';
require_once __DIR__ . '/clases/Historial.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Calculadora';

$error = '';
$a = '';
$b = '';
$operacion = 'suma';

// Comprueba si el formulario fue enviado mediante POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Borrar el historial
    if (($_POST['accion'] ?? '') === 'borrar') {
        Historial::borrar();
        header('Location: calculadora.php');
        exit;
    }

    // Obtener los datos del formulario
    $a = str_replace(',', '.', trim($_POST['a'] ?? ''));
    $b = str_replace(',', '.', trim($_POST['b'] ?? ''));
    $operacion = $_POST['operacion'] ?? '';

    // Comprobar que sean números
    if (!is_numeric($a) || !is_numeric($b)) {
        $error = 'Ingresa dos números válidos.';
    } else {
        try {
            $calculadora = new Calculadora();

            $resultado = $calculadora->calcular(
                (float) $a,
                (float) $b,
                $operacion
            );

            // Guardar la operación en el historial
            $simbolo = [
                'suma' => '+',
                'resta' => '−',
                'multiplicacion' => '×',
                'division' => '÷',
                'porcentaje' => '% de'
            ];

            if (!isset($simbolo[$operacion])) {
                throw new Exception('Selecciona una operación válida.');
            }

            $linea = "$a {$simbolo[$operacion]} $b = $resultado";
            Historial::agregar($linea);

            header('Location: calculadora.php');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

require __DIR__ . '/includes/header.php';

$historial = Historial::obtener();
?>

<form method="post" class="panel">
    <div class="campos">

        <label>Número A
            <input
                type="text"
                name="a"
                inputmode="decimal"
                value="<?= e($a) ?>"
                required>
        </label>

        <label>Operación
            <select name="operacion" required>
                <option value="suma" <?= $operacion === 'suma' ? 'selected' : '' ?>>+ Suma</option>
                <option value="resta" <?= $operacion === 'resta' ? 'selected' : '' ?>>− Resta</option>
                <option value="multiplicacion" <?= $operacion === 'multiplicacion' ? 'selected' : '' ?>>× Multiplicación</option>
                <option value="division" <?= $operacion === 'division' ? 'selected' : '' ?>>÷ División</option>
                <option value="porcentaje" <?= $operacion === 'porcentaje' ? 'selected' : '' ?>>% de Porcentaje</option>
            </select>
        </label>

        <label>Número B
            <input
                type="text"
                name="b"
                inputmode="decimal"
                value="<?= e($b) ?>"
                required>
        </label>

    </div>

    <button type="submit" name="accion" value="calcular">
        Calcular
    </button>
</form>

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<section class="resultado">
    <div class="encabezado-historial">
        <h2>Historial</h2>

        <?php if (!empty($historial)): ?>
            <form method="post">
                <button type="submit" name="accion" value="borrar" class="peligro">
                    Borrar historial
                </button>
            </form>
        <?php endif; ?>
    </div>

    <?php if (!empty($historial)): ?>
        <ul class="historial">
            <?php foreach ($historial as $linea): ?>
                <li><?= e($linea) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="nota">Aún no hay operaciones.</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>