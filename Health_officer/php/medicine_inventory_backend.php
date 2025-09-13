<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include "../db/config.php"; // DB connection

$success = $error = "";
$edit_id = "";
$edit_name = $edit_quantity = $edit_threshold = $edit_expiry = $edit_supplier = "";

// ---------- ADD OR UPDATE ----------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id        = $_POST['id'] ?? "";
    $name      = trim($_POST["medicine_name"]);
    $quantity  = trim($_POST["quantity"]);
    $threshold = trim($_POST["threshold"]);
    $expiry    = trim($_POST["expiry"]);
    $supplier  = trim($_POST["supplier"]);

    if ($name == "" || $quantity == "" || $threshold == "") {
        $error = "Please fill medicine name, quantity and threshold!";
    } elseif (!is_numeric($quantity) || $quantity <= 0) {
        $error = "Quantity must be a positive number!";
    } elseif (!is_numeric($threshold) || $threshold <= 0) {
        $error = "Threshold must be a positive number!";
    } else {
        $name     = mysqli_real_escape_string($conn, $name);
        $supplier = mysqli_real_escape_string($conn, $supplier);

        if ($id) { // update
            $sql = "UPDATE medicines SET name='$name', quantity=$quantity, threshold=$threshold, expiry_date='$expiry', supplier='$supplier' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $success = "Medicine updated successfully!";
            } else {
                $error = "Error updating medicine: " . $conn->error;
            }
        } else { // add
            $sql = "INSERT INTO medicines (name, quantity, threshold, expiry_date, supplier) VALUES ('$name', $quantity, $threshold, '$expiry', '$supplier')";
            if ($conn->query($sql) === TRUE) {
                $success = "Medicine added successfully!";
            } else {
                $error = "Error adding medicine: " . $conn->error;
            }
        }
    }
}

// ---------- DELETE ----------
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($id > 0) {
        $sql = "DELETE FROM medicines WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success = "Medicine deleted successfully!";
        } else {
            $error = "Error deleting medicine: " . $conn->error;
        }
    }
}

// ---------- EDIT ----------
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $res = $conn->query("SELECT * FROM medicines WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $edit_id       = $row['id'];
        $edit_name     = $row['name'];
        $edit_quantity = $row['quantity'];
        $edit_threshold= $row['threshold'];
        $edit_expiry   = $row['expiry_date'];
        $edit_supplier = $row['supplier'];
    }
}

// ---------- FETCH ALL ----------
$result = $conn->query("SELECT * FROM medicines");
?>
