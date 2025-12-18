<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form_id = $_POST['form_id'] ?? 0;
    $user_id = 1; // Example: logged-in user ID

    // Insert into form_responses
    $stmt = $conn->prepare("
        INSERT INTO form_responses (form_id, user_id) 
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $form_id, $user_id);
    $stmt->execute();
    $response_id = $stmt->insert_id;

    // Loop through fields
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'field_') === 0) {
            $field_id = str_replace('field_', '', $key);

            // Handle checkbox (array values)
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            $stmt2 = $conn->prepare("
                INSERT INTO form_response_values (response_id, field_id, value)
                VALUES (?, ?, ?)
            ");
            $stmt2->bind_param("iis", $response_id, $field_id, $value);
            $stmt2->execute();
        }
    }

    echo "<p style='color:green;'>Form submitted successfully!</p>";
    echo "<a href='forms.php'>← Back to Forms List</a>";
} else {
    echo "<p>Invalid request</p>";
}
require_once __DIR__ . '/../includes/footer.php';
?>
