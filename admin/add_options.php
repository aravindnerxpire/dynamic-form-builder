<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$field_id = $_GET['field_id'] ?? 0;

// Fetch field info
$field = $conn->query("SELECT * FROM form_fields WHERE id = $field_id")->fetch_assoc();

if (!$field) {
    echo "<div class='alert alert-danger'>Invalid Field</div>";
    exit;
}

// Handle option add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $option_text = trim($_POST['option_text']);

    if ($option_text !== '') {
        $stmt = $conn->prepare("
            INSERT INTO field_options (field_id, option_text)
            VALUES (?, ?)
        ");
        $stmt->bind_param("is", $field_id, $option_text);
        $stmt->execute();

        echo "<div class='alert alert-success'>Option added.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Add Options for Field: <?= htmlspecialchars($field['label']); ?></h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="option_text" class="form-label">Option Text</label>
                    <input type="text" id="option_text" name="option_text" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Add Option</button>
                <a href="add_fields.php?form_id=<?= $field['form_id']; ?>" class="btn btn-secondary ms-2">← Back to Add Fields</a>
            </form>

            <hr>

            <h4>Existing Options</h4>
            <ul class="list-group">
                <?php
                $options = $conn->query("SELECT * FROM field_options WHERE field_id = $field_id");
                while ($opt = $options->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . htmlspecialchars($opt['option_text']) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php

