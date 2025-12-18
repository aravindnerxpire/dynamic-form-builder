<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-4">Admin Dashboard</h3>

<div class="mb-3">
    <a href="create_form.php" class="btn btn-primary me-2">Create New Form</a>
    <a href="forms_list.php" class="btn btn-secondary me-2">Manage Forms</a>
</div>
<?php
require_once __DIR__ . '/../includes/footer.php';
?>
