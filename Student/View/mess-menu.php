<?php

include "../DB/apply_room_DB.php";    

include "../php/mess_validate.php"; 

?>
<!DOCTYPE html>
<html>
<head>

    <title>Mess Menu</title>

    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/MessMenu.css">

</head>

<body>

<?php include 'header.php'; ?> 


<main class="dashboard">

    <h1>Weekly Mess Menu</h1>

    <table class="menu-table">

        <tr>
            <th>Day</th>

            <th>Breakfast</th>

            <th>Lunch</th>

            <th>Dinner</th>
        </tr>

        <?php
        
        $result = mysqli_query($conn, "SELECT * FROM mess_menu");

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                echo "<tr>

                        <td>{$row['day_of_week']}</td>

                        <td>{$row['breakfast']}</td>

                        <td>{$row['lunch']}</td>

                        <td>{$row['dinner']}</td>

                      </tr>";
            }
        } else {

            echo "<tr><td colspan='4'>No menu available</td></tr>";
        }

        ?>
    </table>

    <h2>Feedback</h2>

    <form method="post" class="feedback-form">

        <textarea name="feedback" placeholder="Your feedback...">
            
        <?php echo htmlspecialchars($feedback); ?></textarea>

        <span class="error"><?php echo $feedbackErr; ?></span><br>

        <input type="submit" value="Submit Feedback">
    </form>


    <p class="success"><?php echo $success; ?></p>
    

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
</main>

</body>
</html>
