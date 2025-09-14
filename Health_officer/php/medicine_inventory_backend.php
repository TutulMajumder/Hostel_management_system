<?php
// SIMPLE MEDICINE INVENTORY BACKEND (supplier + expiry required)
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: ../view/login.php");
    exit();
}

include "../db/config.php"; // $conn

$success = "";
$error   = "";

/* ---------- ADD / UPDATE (simple) ---------- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id        = isset($_POST["id"]) ? trim($_POST["id"]) : "";
    $name      = isset($_POST["medicine_name"]) ? trim($_POST["medicine_name"]) : "";
    $quantity  = isset($_POST["quantity"]) ? trim($_POST["quantity"]) : "";
    $threshold = isset($_POST["threshold"]) ? trim($_POST["threshold"]) : "";
    $expiry    = isset($_POST["expiry"]) ? trim($_POST["expiry"]) : "";     // REQUIRED now
    $supplier  = isset($_POST["supplier"]) ? trim($_POST["supplier"]) : ""; // REQUIRED now

    // Basic validation
    if ($name === "" || $quantity === "" || $threshold === "") {
        $error = "Please fill medicine name, quantity and threshold!";
    } elseif (!ctype_digit($quantity) || (int)$quantity <= 0) {
        $error = "Quantity must be a positive whole number!";
    } elseif (!ctype_digit($threshold) || (int)$threshold <= 0) {
        $error = "Threshold must be a positive whole number!";
    }
    // Supplier required + simple character whitelist
    elseif ($supplier === "") {
        $error = "Supplier is required!";
    } elseif (!preg_match('/^[A-Za-z0-9 .\-&()]{2,100}$/', $supplier)) {
        $error = "Supplier must be 2–100 chars (letters, numbers, space, . - & ()).";
    }
    // Expiry required + format + not in past
    elseif ($expiry === "") {
        $error = "Expiry date is required!";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiry)) {
        $error = "Expiry must be YYYY-MM-DD.";
    } else {
        $today = date('Y-m-d');
        if ($expiry < $today) {
            $error = "Expiry date cannot be in the past.";
        }
    }

    if ($error === "") {
        // Escape strings for safety
        $name_esc     = mysqli_real_escape_string($conn, $name);
        $supplier_esc = "'" . mysqli_real_escape_string($conn, $supplier) . "'";
        $expiry_sql   = "'" . mysqli_real_escape_string($conn, $expiry) . "'";
        $q  = (int)$quantity;
        $th = (int)$threshold;

        if ($id !== "") {
            // UPDATE
            $id_i = (int)$id;
            $sql = "UPDATE medicines
                    SET name='$name_esc',
                        quantity=$q,
                        threshold=$th,
                        expiry_date=$expiry_sql,
                        supplier=$supplier_esc
                    WHERE id=$id_i";
            if (mysqli_query($conn, $sql)) {
                $success = "Medicine updated successfully!";
            } else {
                $error = "Error updating medicine: " . mysqli_error($conn);
            }
        } else {
            // INSERT
            $sql = "INSERT INTO medicines (name, quantity, threshold, expiry_date, supplier)
                    VALUES ('$name_esc', $q, $th, $expiry_sql, $supplier_esc)";
            if (mysqli_query($conn, $sql)) {
                $success = "Medicine added successfully!";
            } else {
                $error = "Error adding medicine: " . mysqli_error($conn);
            }
        }
    }
}

/* ---------- DELETE (simple) ---------- */
if (isset($_GET["delete_id"])) {
    $id = (int)$_GET["delete_id"];
    if ($id > 0) {
        $sql = "DELETE FROM medicines WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $success = "Medicine deleted successfully!";
        } else {
            $error = "Error deleting medicine: " . mysqli_error($conn);
        }
    } else {
        $error = "Invalid delete id.";
    }
}

/* ---------- EDIT PREFILL (simple) ---------- */
$edit_id = "";
$edit_name = $edit_quantity = $edit_threshold = $edit_expiry = $edit_supplier = "";

if (isset($_GET["edit_id"])) {
    $id = (int)$_GET["edit_id"];
    if ($id > 0) {
        $res = mysqli_query($conn, "SELECT * FROM medicines WHERE id=$id LIMIT 1");
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $edit_id        = $row["id"];
            $edit_name      = $row["name"];
            $edit_quantity  = $row["quantity"];
            $edit_threshold = $row["threshold"];
            $edit_expiry    = $row["expiry_date"];
            $edit_supplier  = $row["supplier"];
        } else {
            $error = "Medicine not found.";
        }
    } else {
        $error = "Invalid edit id.";
    }
}

/* ---------- FETCH ALL (simple) ---------- */
$result = mysqli_query($conn, "SELECT * FROM medicines ORDER BY name ASC");
