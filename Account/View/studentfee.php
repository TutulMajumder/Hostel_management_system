<?php 
include '../DB/config.php';

$error="";
$success="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
$studentid=$_POST["student_id"];
$studentname=$_POST["student_name"];
$amount=$_POST["amount"];
$date=$_POST["date"];
$status=$_POST["status"];

if(empty($studentid)|| empty($studentname)||empty($amount)||empty($date))
{
$error="All fileds are required!";
}
elseif(!is_numeric($amount))
{
$error="Amount must be a number!";
}
else
{
 $sql="INSERT INTO student_fees(student_id,student_name,amount,payment_date,status)
 VALUES('$studentid','$studentname','$amount','$date','$status')" ;
 if($conn->query($sql)=== TRUE)
{
    $success="✅ New fee record saved!";
}  
 else
{
    $error="❌ Error: " .$conn->error;
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Fee</title>
    <link rel="stylesheet" href="../CSS/style2.css">
</head>
<body>
<div class="container">
    <h2>Add Student Fee Record</h2>
    <form method="POST" action="">
    <label>Student ID:</label>
    <input type="text" name="student_id" placeholder="Enter Student ID">
    <label>Student Name:</label>
    <input type="text" name="student_name" placeholder="Enter Student Name">
    <label>Amount:</label>
    <input type="text" name="amount" placeholder="Enter Amount">
    <label>Date:</label>
    <input type="date" name="date">
    <label>Status:</label>
    <select name="status">
        <option value="Paid">Paid</option>
        <option value="Pending">Pending</option>
    </select>

    <input type="submit" value="Save Record">
    </form>

    <?php if(!empty($error)) echo "<p class='error'>$error </p>"; ?>
    <?php if(!empty($success)) echo "<p class='success'>$success </p>"; ?>

    <p><a href="view_studentfee.php">➡️ View All Records</a></p>
    <p><a href="dashboard.php">🔙 Back to Dashboard</a></p>
</div>    
</body>
</html>
