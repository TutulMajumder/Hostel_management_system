<?php
include "../php/medicine_inventory_backend.php"; // include backend
?>
<?php
include "topbar.php"; // include topbar
?>
<!DOCTYPE html>
<html>
<head>
    <title>Medicine Inventory</title>
    <link rel="stylesheet" href="../css/medicine_inventory.css">\
    <link rel="stylesheet" href="../css/topbar.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
<div class="container">
    <div class="header-container">
        <h2>Medicine Inventory</h2>
        <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>

    <?php
    if ($success != "") echo "<p class='success'>$success</p>";
    if ($error != "") echo "<p class='error'>$error</p>";
    ?>

    <!-- Add/Edit Form -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

        <label>Medicine Name:</label>
        <input type="text" name="medicine_name" value="<?php echo $edit_name; ?>">

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $edit_quantity; ?>">

        <label>Threshold:</label>
        <input type="number" name="threshold" value="<?php echo $edit_threshold ?: 5; ?>">

        <label>Expiry Date:</label>
        <input type="date" name="expiry" value="<?php echo $edit_expiry; ?>">

        <label>Supplier:</label>
        <input type="text" name="supplier" value="<?php echo $edit_supplier; ?>">

        <input type="submit" value="<?php echo $edit_id ? 'Update Medicine' : 'Add Medicine'; ?>" class="btn">
        <?php if($edit_id) echo '<a href="medicine_inventory.php" class="btn cancel-btn">Cancel</a>'; ?>
    </form>

    <!-- Medicine Table -->
    <h3>All Medicines</h3>
    <table class="medicine-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Threshold</th>
                <th>Expiry Date</th>
                <th>Supplier</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr <?php if($row['quantity']<$row['threshold']) echo 'class="low-stock"'; ?>>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['threshold']; ?></td>
                <td><?php echo $row['expiry_date']; ?></td>
                <td><?php echo $row['supplier']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['id']; ?>" class="btn update-btn">Update</a>
                    <a href="?delete_id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this medicine?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    
</div>

<?php $conn->close(); ?>
<?php include 'footer.php'; ?>
</body>
</html>
