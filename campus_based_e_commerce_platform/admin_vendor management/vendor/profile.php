<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$user = fetchRow('SELECT u.*, up.first_name, up.last_name, up.phone FROM users u 
                  LEFT JOIN user_profiles up ON u.id = up.user_id 
                  WHERE u.id = ?', [$userId]);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    try {
        $stmt = getPDOConnection()->prepare('UPDATE user_profiles SET first_name = ?, last_name = ?, phone = ? WHERE user_id = ?');
        $stmt->execute([$firstName, $lastName, $phone, $userId]);
        $message = 'Profile updated successfully.';
        $user = fetchRow('SELECT u.*, up.first_name, up.last_name, up.phone FROM users u 
                          LEFT JOIN user_profiles up ON u.id = up.user_id 
                          WHERE u.id = ?', [$userId]);
    } catch (PDOException $e) {
        $message = 'Error updating profile.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Vendor Profile</h1>
</div>

<div class="card" style="max-width: 600px;">
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="profile-info" style="margin-bottom: 2rem;">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Role:</strong> Vendor</p>
    </div>

    <h3>Update Business Info</h3>
    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="first_name">Business Contact First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Business Contact Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Contact Phone</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>
        <button type="submit" class="button">Save Changes</button>
    </form>

    <div style="margin-top: 2rem;">
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
