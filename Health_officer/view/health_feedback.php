<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include "../php/dashboard_backend.php";

// Fetch student feedback
$sql = "SELECT s.name, s.student_id, f.rating, f.comments, f.created_at
        FROM students s
        JOIN student_health_feedback f ON s.student_id = f.student_id
        ORDER BY f.created_at DESC";

$result = $conn->query($sql);
?>
<?php include 'topbar.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Student Health Feedback</title>
  <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/health_feedback.css">
  <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/topbar.css">
  <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/footer.css">
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
            <?php if($result->num_rows > 0): ?>
              <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['student_id']) ?>)</td>
                  <td>
                    <div class="rating"><?= str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']) ?></div>
                    <div class="rating-text">(<?= $row['rating'] ?>/5)</div>
                  </td>
                  <td><?= htmlspecialchars($row['comments']) ?></td>
                  <td><?= $row['created_at'] ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No feedback available</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>


</body>
</html>
