<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$forms = $conn->query("SELECT * FROM forms ORDER BY id DESC");
?>

<h3 class="mb-4">Forms List</h3>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Form Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($form = $forms->fetch_assoc()): ?>
        <tr>
            <td><?= $form['id']; ?></td>
            <td><?= htmlspecialchars($form['form_name']); ?></td>
            <td>
                <a href="add_fields.php?form_id=<?= $form['id']; ?>" class="btn btn-sm btn-primary">Add/Edit Fields</a>
                <a href="view_responses.php?form_id=<?= $form['id']; ?>" class="btn btn-sm btn-success">View Responses</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
