<?php 

function renderMessages(?string $successMessage, array $errors): void {
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . htmlspecialchars($successMessage) . '</div>';
    }
    if (!empty($errors)) {
        echo '<div class="alert alert-danger"><ul class="mb-0">';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
    }
}