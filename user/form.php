<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$form_id = $_GET['form_id'] ?? 0;

// Fetch form info
$form = $conn->query("SELECT * FROM forms WHERE id = $form_id")->fetch_assoc();
if (!$form) {
    echo "<p class='text-danger'>Invalid Form</p>";
    exit;
}

// Fetch fields
$fields = $conn->query("
    SELECT * FROM form_fields
    WHERE form_id = $form_id
    ORDER BY sort_order
");
?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title mb-4"><?= htmlspecialchars($form['form_name']); ?></h3>

        <form method="post" action="submit_form.php">
            <input type="hidden" name="form_id" value="<?= $form_id ?>">

            <?php while ($f = $fields->fetch_assoc()): ?>
                <?php
                $name = 'field_' . $f['id'];
                $required = $f['required'] ? 'required' : '';
                $placeholder = $f['placeholder'] ?? '';
                ?>

                <div class="mb-3">
                    <label class="form-label"><?= htmlspecialchars($f['label']); ?><?= $f['required'] ? ' *' : ''; ?></label>

                    <?php if ($f['type'] == 'text' || $f['type'] == 'number'): ?>
                        <input type="<?= $f['type'] ?>" class="form-control" name="<?= $name ?>" placeholder="<?= $placeholder ?>" <?= $required ?>>

                    <?php elseif ($f['type'] == 'textarea'): ?>
                        <textarea class="form-control" name="<?= $name ?>" placeholder="<?= $placeholder ?>" <?= $required ?>></textarea>

                    <?php elseif (in_array($f['type'], ['dropdown', 'radio', 'checkbox'])): 
                        $options = $conn->query("SELECT * FROM field_options WHERE field_id={$f['id']}");
                        if ($f['type'] == 'dropdown'): ?>
                            <select class="form-select" name="<?= $name ?>" <?= $required ?>>
                                <option value="">Select</option>
                                <?php while ($o = $options->fetch_assoc()): ?>
                                    <option><?= htmlspecialchars($o['option_text']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        <?php else: ?>
                            <div>
                                <?php while ($o = $options->fetch_assoc()): ?>
                                    <div class="<?= $f['type'] ?> form-check mb-1">
                                        <input class="form-check-input" type="<?= $f['type'] ?>" name="<?= $name ?><?= $f['type']=='checkbox'?'[]':'' ?>" value="<?= htmlspecialchars($o['option_text']); ?>" id="<?= $name . '_' . $o['id']; ?>">
                                        <label class="form-check-label" for="<?= $name . '_' . $o['id']; ?>">
                                            <?= htmlspecialchars($o['option_text']); ?>
                                        </label>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn btn-primary">Submit Form</button>
            <a href="forms.php" class="btn btn-secondary ms-2">← Back to Forms List</a>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
