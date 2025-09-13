<?php
include "../php/health_reports_backend.php";
include 'topbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Health Reports</title>
    <head>
  <title>Student Reports</title>
  <link rel="stylesheet" href="../css/health_reports.css">
  <link rel="stylesheet" href="../css/topbar.css">
  <link rel="stylesheet" href="../css/footer.css">
</head>

</head>
<body>
<div class="container">
    <div class="dashboard-header">
        <h2>Student Previous Health Reports</h2>
        <div>
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        </div>
    </div>

    <div class="content-section">
        <div class="student-selector">
            <h3>Select Student</h3>
            <div class="selector-form">
                <select id="studentSelect">
                    <option value="">-- Select a Student --</option>
                    <?php while ($row = $students_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['student_id']; ?>"><?php echo $row['name'] . " (" . $row['student_id'] . ")"; ?></option>
                    <?php endwhile; ?>
                </select>
                <button id="viewReportBtn">View Health History</button>
            </div>
        </div>

        <div class="student-report">
            <h3>Health History for <span id="selectedStudent">Select a student</span></h3>
            <div class="tab-content">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                            <th>Doctor</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($report = $reports_result->fetch_assoc()): ?>
                        <tr data-student="<?php echo $report['student_id']; ?>">
                            <td><?php echo $report['report_date']; ?></td>
                            <td><?php echo $report['name']; ?></td>
                            <td><?php echo $report['diagnosis']; ?></td>
                            <td><?php echo $report['treatment']; ?></td>
                            <td><?php echo $report['doctor_name']; ?></td>
                            <td><?php echo $report['notes']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

       
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('studentSelect');
    const viewReportBtn = document.getElementById('viewReportBtn');
    const selectedStudent = document.getElementById('selectedStudent');
    const rows = document.querySelectorAll('tbody tr');

    viewReportBtn.addEventListener('click', function() {
        const studentId = studentSelect.value;
        if(!studentId){
            alert('Please select a student');
            return;
        }
        selectedStudent.textContent = studentSelect.options[studentSelect.selectedIndex].text;
        rows.forEach(row => {
            if(row.getAttribute('data-student') === studentId){
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
