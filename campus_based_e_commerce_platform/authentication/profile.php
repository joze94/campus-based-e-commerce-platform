<?php
require_once __DIR__ . '/config.php';
session_start();

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $campusLocation = trim($_POST['campus_location'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    if ($username === '' || $email === '') {
        $error = 'Username and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $pdo = getPDOConnection();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
            $stmt->execute([$username, $email, $userId]);

            $stmt = $pdo->prepare('UPDATE user_profiles SET first_name = ?, last_name = ?, phone = ?, campus_location = ?, bio = ? WHERE user_id = ?');
            $stmt->execute([$firstName, $lastName, $phone, $campusLocation, $bio, $userId]);

            $pdo->commit();

            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            $message = 'Profile updated successfully.';
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = 'Profile update failed. Username or email may already be in use.';
        }
    }
}

$profile = fetchRow('SELECT u.username, u.email, u.created_at, up.first_name, up.last_name, up.phone, up.campus_location, up.bio
                     FROM users u
                     LEFT JOIN user_profiles up ON up.user_id = u.id
                     WHERE u.id = ?', [$userId]);

if (!$profile) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>My Profile</h1>
</div>

<div class="card" style="max-width: 700px; margin: 40px auto;">
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <p><strong>Member since:</strong> <?php echo htmlspecialchars($profile['created_at']); ?></p>

    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" value="<?php echo htmlspecialchars($profile['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>">
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="campus_location">Campus Location</label>
                <input id="campus_location" name="campus_location" value="<?php echo htmlspecialchars($profile['campus_location'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
        </div>

        <button type="submit" class="button">Save Profile</button>
    </form>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
