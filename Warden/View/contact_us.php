<!DOCTYPE html>
<html>
<head>    <title>Contact Us - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/static_pages.css">
</head>
<body>

    <main>
        <section class="static-page">
            <h2>Contact Us</h2>
            <p>If you have any questions or need support, please reach out to us:</p>

            <div class="contact-info">
                <p><strong>Email:</strong> support@hostelms.com</p>
                <p><strong>Phone:</strong> +8801234567890</p>
                <p><strong>Address:</strong> American International University-Bangladesh, Dhaka, Bangladesh</p>
            </div>

            <form action="" method="POST" class="contact-form">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Write your message..." required></textarea>

                <button type="submit" class="btn">Send Message</button>
            </form>
        </section>
    </main>

</body>
</html>
