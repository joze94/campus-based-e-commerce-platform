<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message_text = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message_text)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        // In production, save to database or send email
        $message = 'Thank you for contacting us! We will get back to you soon.';
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Contact Us</h1>
    <p>Have questions? We'd love to hear from you.</p>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div class="card">
            <h3>Contact Information</h3>
            <p><strong>Email:</strong> support@campusshop.edu</p>
            <p><strong>Phone:</strong> +1-800-CAMPUS-1</p>
            <p><strong>Campus Office:</strong> Student Center, Room 201</p>
            <p><strong>Hours:</strong> Monday - Friday, 9 AM - 5 PM</p>
            <p style="margin-top: 2rem; color: #7f8c8d;">We typically respond to inquiries within 24 hours.</p>
        </div>

        <div class="card">
            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <h3>Send us a Message</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="button">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
