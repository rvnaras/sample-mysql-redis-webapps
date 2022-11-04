<?php
$conn = new mysqli('assessment-db.cah4zeoduvi2.us-east-1.rds.amazonaws.com', 'sample_user', 'my-awesome-password105.', 'sample_company');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
   }

echo "Database connection was successful";
