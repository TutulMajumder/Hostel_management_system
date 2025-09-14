<?php
include "../Php/process_notice.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Notice - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/topbar.css">
    <link rel="stylesheet" href="../Css/post_notice.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="post-notice">
            <h2>Post a Notice</h2>

            <form action="" method="POST" enctype="multipart/form-data">

                <!-- Notice Title -->
                <label for="notice_title">Notice Title:</label>
                <input type="text" id="notice_title" name="notice_title" placeholder="Enter Notice Title">

                <!-- Recipients -->
                <label for="notice_title">Send To:</label>
                <div class="recipients">
                    <label><input type="checkbox" name="recipients[]" value="Student"> Students</label>
                    <label><input type="checkbox" name="recipients[]" value="Accountant"> Accountants</label>
                    <label><input type="checkbox" name="recipients[]" value="Health Officer"> Health Officers</label>
                </div>

                <!-- Upload Notice File -->
                <label for="notice_file">Upload Notice:</label>
                <input type="file" id="notice_file" name="notice_file" accept=".jpg,.jpeg,.png,.pdf">

                <!-- Additional Information -->
                <label for="note">Additional Information:</label>
                <textarea id="note" name="note" placeholder="Add any extra details here"></textarea>
                <?php if (isset($_SESSION['errors'])): ?>
                    <p class="error"><?php echo $_SESSION['errors'];
                                        unset($_SESSION['errors']); ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <p class="success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></p>
                <?php endif; ?>
                <!-- Submit Button -->
                <button type="submit" name="submit" class="submit-btn">Post Notice</button>

            </form>
        </section>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>

</body>

</html>