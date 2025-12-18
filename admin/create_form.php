<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form_name = trim($_POST['form_name']);

    if ($form_name != '') {
        $stmt = $conn->prepare("INSERT INTO forms (form_name) VALUES (?)");
        $stmt->bind_param("s", $form_name);
        $stmt->execute();

        $form_id = $stmt->insert_id;

        echo "<div class='alert alert-success'>Form created successfully.</div>";
        echo "<a href='add_fields.php?form_id=$form_id' class='btn btn-primary mt-2'>Add Fields to this Form</a>";
    } else {
        echo "<div class='alert alert-danger'>Form name is required.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Create New Form</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="form_name" class="form-label">Form Name</label>
                    <input type="text" id="form_name" name="form_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Create Form</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
