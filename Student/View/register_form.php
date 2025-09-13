<?php include("../PHP/register_validate.php");

?>


<!DOCTYPE html>

<html>

<head>


  <title>Student Registration</title>

  <link rel="stylesheet" href="../CSS/register.css">

</head>

<body>

<div class="container">

  <h2>Student Registration</h2>

  <form method="post">


    <input type="text" name="fullname" placeholder="Full Name" value="<?php echo $fullname; ?>">

    <span class="error"><?php echo $fullnameErr; ?></span><br>


    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

    <span class="error"><?php echo $emailErr; ?></span><br>

    <input type="text" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>">

    <span class="error"><?php echo $phoneErr; ?></span><br>

    <label>Gender:</label>

    <div class="gender-options">

      <label>Male <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>></label>

      <label>Female <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>></label>
      
      <label>Other <input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked"; ?>></label>
    
    </div>

    <span class="error"><?php echo $genderErr; ?></span><br>

    <label>Date of Birth:</label><br>

    <input type="date" name="dob" value="<?php echo $dob; ?>">

    <span class="error"><?php echo $dobErr; ?></span><br>

    <label>Semester / Year:</label><br>

    <select name="semester">

      <option value="">-- Select Semester --</option>

      <option <?php if($semester=="1st") echo "selected"; ?>>1st</option>

      <option <?php if($semester=="2nd") echo "selected"; ?>>2nd</option>

      <option <?php if($semester=="3rd") echo "selected"; ?>>3rd</option>

      <option <?php if($semester=="4th") echo "selected"; ?>>4th</option>

    </select>

    <span class="error"><?php echo $semesterErr; ?></span><br>

    <label>Department / Course:</label><br>

    <select name="department">

      <option value="">-- Select Department --</option>

      <option <?php if($department=="CSE") echo "selected"; ?>>CSE</option>

      <option <?php if($department=="EEE") echo "selected"; ?>>EEE</option>

      <option <?php if($department=="BBA") echo "selected"; ?>>BBA</option>

      <option <?php if($department=="Others") echo "selected"; ?>>Others</option>

    </select>
    <span class="error"><?php echo $deptErr; ?></span><br>

    <textarea name="address" placeholder="Address"><?php echo $address; ?></textarea>

    <span class="error"><?php echo $addressErr; ?></span><br>

    <input type="password" name="password" placeholder="Password">

    <span class="error"><?php echo $passwordErr; ?></span><br>

    <input type="password" name="confirm_password" placeholder="Confirm Password">

    <span class="error"><?php echo $confirmErr; ?></span><br>

    <input type="submit" value="Register">

  </form>

  <p class="success"><?php echo $success; ?></p>

  <p>Already registered? <a href="../View/login.php">Login here</a></p>

</div>

</body>
</html>
