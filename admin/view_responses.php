<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$form_id = $_GET['form_id'] ?? null;

// If form_id is set, show responses for that form
if ($form_id) {
    $form = $conn->query("SELECT * FROM forms WHERE id = $form_id")->fetch_assoc();
    if (!$form) {
        echo "<div class='alert alert-danger'>Invalid Form</div>";
        exit;
    }

    $responses = $conn->query("
        SELECT r.*, f.form_name
        FROM form_responses r
        JOIN forms f ON r.form_id = f.id
        WHERE r.form_id = $form_id
        ORDER BY r.submitted_at DESC
    ");
} else {
    // No form_id → show all responses
    $responses = $conn->query("
        SELECT r.*, f.form_name
        FROM form_responses r
        JOIN forms f ON r.form_id = f.id
        ORDER BY r.submitted_at DESC
    ");
}
?>

<div class="container mt-5">
    <h3 class="mb-4">
        <?= $form_id ? "Responses for: " . htmlspecialchars($form['form_name']) : "All Form Responses"; ?>
    </h3>

    <?php if ($responses->num_rows == 0): ?>
        <div class="alert alert-info">No submissions yet.</div>
    <?php else: ?>

        <?php while ($r = $responses->fetch_assoc()): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <p><strong>Form Name:</strong> <?= htmlspecialchars($r['form_name']); ?></p>
                    <p><strong>Submission ID:</strong> <?= $r['id']; ?></p>
                    <p><strong>User ID:</strong> <?= $r['user_id']; ?></p>
                    <p><strong>Submitted At:</strong> <?= $r['submitted_at']; ?></p>

                    <h5 class="mt-3">Responses:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $values = $conn->query("
                                    SELECT f.label, v.value
                                    FROM form_response_values v
                                    JOIN form_fields f ON f.id = v.field_id
                                    WHERE v.response_id = {$r['id']}
                                ");
                                while ($val = $values->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($val['label']); ?></td>
                                        <td><?= htmlspecialchars($val['value']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">← Back to Dashboard</a>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
