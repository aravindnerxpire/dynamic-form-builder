<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$forms = $conn->query("SELECT * FROM forms ORDER BY id DESC");
?>

<h3 class="mb-4">Available Forms</h3>

<?php if ($forms->num_rows == 0): ?>
    <p class="text-danger">No forms available.</p>
<?php else: ?>
    <ul class="list-group">
        <?php while ($f = $forms->fetch_assoc()): ?>
            <li class="list-group-item">
                <a href="form.php?form_id=<?= $f['id']; ?>"><?= htmlspecialchars($f['form_name']); ?></a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
