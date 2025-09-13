<?php
include '../DB/config.php'; 

$error = "";
$success = "";
$title = "";
$note = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $note  = $_POST['note'];

    if (empty($title)) {
        $error = "⚠️ Title is required!";
    } else {
        
        $sql = "INSERT INTO notices (title, note) VALUES ('$title', '$note')";
        if ($conn->query($sql) === TRUE) {
            $success = "✅ Notice added!";
            $title = $note = ""; 
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Notice</title>
    <link rel="stylesheet" href="../CSS/style7.css">
</head>
<body>
<div class="container">
    <h2>Add Notice</h2>

    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>">

        <label>Note:</label>
        <textarea name="note"><?php echo $note; ?></textarea>

        <input type="submit" value="Add Notice">
    </form>

    <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>
    <?php if ($success) { echo "<p class='success'>$success</p>"; } ?>

    <p><a href="view_notices.php">View Notices</a></p>
</div>
</body>
</html>
