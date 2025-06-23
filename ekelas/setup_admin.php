<?php
require_once 'config/database.php';

try {
    // Cek apakah admin sudah ada
    $stmt = $conn->query("SELECT COUNT(*) FROM admin");
    if ($stmt->fetchColumn() == 0) {
        $email = "admin@ekelas.com";
        $password = password_hash("Admin123!", PASSWORD_DEFAULT);
        
        $conn->exec("INSERT INTO admin (email, password) VALUES ('$email', '$password')");
        
        echo "Akun admin berhasil dibuat:<br>";
        echo "Email: $email<br>";
        echo "Password: Admin123!<br>";
        echo "<a href='login.php'>Klik untuk login</a>";
    } else {
        echo "Akun admin sudah ada. Silakan <a href='login.php'>login</a>.";
    }
} catch (PDOException $e) {
    die("Error setup admin: " . $e->getMessage());
}