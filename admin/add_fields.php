<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$form_id = $_GET['form_id'] ?? 0;

// Fetch form info
$form = $conn->query("SELECT * FROM forms WHERE id = $form_id")->fetch_assoc();

if (!$form) {
    echo "<div class='alert alert-danger'>Invalid Form</div>";
    exit;
}

// Handle add field
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $label       = $_POST['label'];
    $type        = $_POST['type'];
    $required    = $_POST['required'];
    $placeholder = $_POST['placeholder'];
    $sort_order  = $_POST['sort_order'];

    $stmt = $conn->prepare("
        INSERT INTO form_fields 
        (form_id, label, type, required, placeholder, sort_order)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issisi",
        $form_id,
        $label,
        $type,
        $required,
        $placeholder,
        $sort_order
    );

    $stmt->execute();
    $field_id = $stmt->insert_id;

    // Redirect to add options if needed
    if (in_array($type, ['dropdown', 'radio', 'checkbox'])) {
        header("Location: add_options.php?field_id=$field_id");
        exit;
    }

    echo "<div class='alert alert-success'>Field added successfully.</div>";
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Add Fields to: <?= htmlspecialchars($form['form_name']); ?></h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="label" class="form-label">Field Label</label>
                    <input type="text" id="label" name="label" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Field Type</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="textarea">Textarea</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="required" class="form-label">Required</label>
                    <select id="required" name="required" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="placeholder" class="form-label">Placeholder</label>
                    <input type="text" id="placeholder" name="placeholder" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" value="1">
                </div>

                <button type="submit" class="btn btn-success">Add Field</button>
                <a href="forms_list.php" class="btn btn-secondary ms-2">← Back to Forms List</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
