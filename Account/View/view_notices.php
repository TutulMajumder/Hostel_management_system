<?php
include '../DB/config.php'; 


$sql = "SELECT * FROM notices ORDER BY date_posted DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Notices</title>
    <link rel="stylesheet" href="../CSS/style7.css">
</head>
<body>
<div class="container">
    <h2>All Notices</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='notice'>";
            echo "<h3>".$row['title']."</h3>";
            echo "<p>".$row['note']."</p>";
            echo "<small>Posted on: ".$row['date_posted']."</small>";
            echo "</div>";
        }
    } else {
        echo "<p>No notices found.</p>";
    }
    ?>
     <p><a href="dashboard.php">⬅️ Back to Dashboard</a></p>
</div>
</body>
</html>
