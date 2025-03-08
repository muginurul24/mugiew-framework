<?php if ($data['user'] == null) : ?>
<?php include __DIR__ . '/Pages/Guest/login.php'; ?>
<?php else : ?>
<?php include __DIR__ . '/Pages/Auth/dashboard.php'; ?>
<?php endif; ?>