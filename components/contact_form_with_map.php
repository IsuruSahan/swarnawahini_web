<?php
// Handle form submission
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    if ($name && $email && $message) {
        try {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (:name, :email, :message)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':message' => $message
            ]);
            $success = true; // Submission successful
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            $success = false; // Handle error
        }
    }
}
?>

<div class="contact-container">
    <div class="row">
        <div class="col-md-6 contact-info">
            <h3>Get in Touch</h3>
            <div class="row">
                <!-- Contact Details -->
                <div class="col-md-6 contact-details">
                    <p><strong>Address:</strong> Bellatrix Building, 752 Dr Danister De Silva Mawatha, Colombo 00900
</p>
                    <p><strong>Phone:</strong> +94 11 269 6666</p>
                    <p><strong>Email:</strong> info@swarnawahini.lk</p>
                    <p><strong>Operating Hours:</strong> Mon - Fri, 8:00 AM - 5:00 PM (SLT)</p>
                    <p><strong>Response Time:</strong> Within 24 hours</p>
                </div>
                <!-- Map -->
                <div class="col-md-6 map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.614165930143!2d79.86073531534012!3d6.910540495149888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2590f8b5c0f5f%3A0x1a2b3c4d5e6f7g8h!2sSwarnawahini!5e0!3m2!1sen!2slk!4v1623456789!5m2!1sen!2slk" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        <div class="col-md-6 contact-form">
            <h3>Send Us a Message</h3>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    Thank you! Your message has been sent successfully.
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !$success): ?>
                <div class="alert alert-danger" role="alert">
                    Error submitting your message. Please try again later.
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<style>
.contact-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.contact-info, .contact-form {
    padding: 20px;
}
.contact-info h3, .contact-form h3 {
    color: #ffd700;
    font-size: 1.5rem;
    margin-bottom: 20px;
}
.contact-details p {
    font-size: 1rem;
    margin-bottom: 10px;
}
.contact-form label {
    font-weight: bold;
    color: #333;
}
.contact-form .form-control {
    border-radius: 5px;
    border: 1px solid #ccc;
}
.contact-form .btn-primary {
    background-color: #ffd700;
    border-color: #ffd700;
    color: #333;
    font-weight: bold;
    padding: 10px 20px;
}
.contact-form .btn-primary:hover {
    background-color: #e6c200;
    border-color: #e6c200;
}
.map-container {
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
    margin-top: 20px;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
    margin-top: 20px;
}
@media (max-width: 768px) {
    .contact-container {
        margin: 20px;
        padding: 15px;
    }
    .map-container {
        height: 200px;
        margin-top: 20px;
    }
    .contact-details, .map-container {
        width: 100%;
    }
}
</style>