<?php
session_start();

// check session
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: login.php");
    exit();
}

// db connect
include "../db/config.php";

// message vars
$error = "";
$result = "";

// fetch feedback with student info
$sql = "SELECT 
            IFNULL(s.fullname, f.student_name) AS student_name,
            IFNULL(s.id, f.student_id) AS student_id,
            f.rating, f.comments, f.created_at
        FROM student_health_feedback f
        LEFT JOIN students s ON s.id = f.student_id
        ORDER BY f.created_at DESC";

$result = mysqli_query($conn, $sql);

?>
<?php include 'topbar.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Student Health Feedback</title>
  <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/health_feedback.css">
  <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/topbar.css">
  <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/footer.css">
</head>
<body>
<div class="container">
  <div class="dashboard-header">
    <h2>Student Health Feedback</h2>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
  </div>

  <div class="content-section">
    <div class="feedback-list">
      <h3>Student Feedback</h3>
      <table>
        <thead>
          <tr>
            <th>Student</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Submitted At</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stars = (int)$row["rating"];
                if ($stars < 0) $stars = 0;
                if ($stars > 5) $stars = 5;

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["student_name"]) . " (" . htmlspecialchars($row["student_id"]) . ")</td>";
                echo "<td>";
                echo "<div class='rating'>" . str_repeat("★", $stars) . str_repeat("☆", 5 - $stars) . "</div>";
                echo "<div class='rating-text'>(" . $stars . "/5)</div>";
                echo "</td>";
                echo "<td>" . htmlspecialchars($row["comments"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>No feedback available</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
<?php mysqli_close($conn); ?>
