<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$users = fetchAll('SELECT u.*, up.first_name, up.last_name FROM users u LEFT JOIN user_profiles up ON u.id = up.user_id ORDER BY u.created_at DESC');
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Manage Users</h1>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Role</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo $user['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
