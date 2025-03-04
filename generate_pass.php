<?php
session_start();
include('dbconn.php'); // Include your database connection file
require('fpdf/fpdf.php'); // Include the FPDF library

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $reason = $_POST['reason'];
    $person_to_visit = $_POST['person_to_visit'];
    $date_visit = date('Y-m-d H:i:s');

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    // Insert visitor data into the database
    $sql = "INSERT INTO `tbl_visitor` (`name`, `email`, `phone`, `photo`, `reason`, `person_to_visit`, `date_visit`) 
            VALUES ('$name', '$email', '$phone', '$target_file', '$reason', '$person_to_visit', '$date_visit')";
    mysqli_query($db, $sql);

    // Get the last inserted ID
    $visitor_id = mysqli_insert_id($db);

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Guest Pass', 0, 1, 'C');
    $pdf->Ln(10);

    // Add visitor photo
    $pdf->Image($target_file, 10, 100, 40, 40); // Adjust the position and size as needed

    // Add visitor details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Name: $name", 0, 1);
    $pdf->Cell(0, 10, "Email: $email", 0, 1);
    $pdf->Cell(0, 10, "Phone: $phone", 0, 1);
    $pdf->Cell(0, 10, "Reason: $reason", 0, 1);
    $pdf->Cell(0, 10, "Person to Visit: $person_to_visit", 0, 1);
    $pdf->Cell(0, 10, "Date of Visit: $date_visit", 0, 1);
    $pdf->Cell(0, 10, "Visitor ID: $visitor_id", 0, 1);
    $pdf->Ln(10);

    // Output PDF to a file
    $pdf_file = "uploads/visitor_pass_$visitor_id.pdf";
    $pdf->Output($pdf_file, 'F'); // Save the PDF file

    // Generate the visitor pass as HTML
    $pass_content = "
    <html>
    <head>
        <link href='assets/Top-logo.jpg' rel='icon' type='image/x-icon'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <title>Visitor Pass</title>
        <style>
            body {
                background: url(assets/college.gif);
                background-repeat: no-repeat;
                background-position: bottom;
                background-size: 200px;
            }
            .pass { 
                background-color: white;
                margin-top: 50px;
                border-radius: 10px;
                box-shadow: 0px 4px 4px 4px rgba(0, 0, 0, 0.1);
                border: none; 
                padding: 20px; 
                width: 300px; 
                text-align: center; 
                margin: 0 auto;
            }
            .card-header {
                font-family: fantasy;
                font-size: 2em;
                color: rgb(26, 12, 12);
                border: none;
            }
            h2 { 
                color: #333; 
            }
            p { 
                margin: 10px 0; 
            }
            .separator-hr1 {
                left: 50%;
                height: 2px;
                width: 70%;
                margin-left: 400px;
                background-color: #6c757d;
                opacity: 0.5;
            }
                .separator-hr2 {
                left: 50%;
                height: 2px;
                width: 70%;
                margin-right:400px;
                background-color: #6c757d;
                opacity: 0.5;
            }
        </style>
    </head>
    <body>
        <a href='index.html'><img src='assets/VSIT.png' height='50px'></a>
        <div class='pass'>
            <div class='card-header text-center'>
                <h3>GUEST DETAILS:</h3><hr>
                <img src='$target_file' alt='Visitor Photo' style='width:100px; height:auto;'>
            </div>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Reason:</strong> $reason</p>
            <p><strong>Person to Visit:</strong> $person_to_visit</p>
            <p><strong>Date of Visit:</strong> $date_visit</p>
            <p><strong>Visitor ID:</strong> $visitor_id</p>
            <div class='text-center mt-4'>
                <a href='$pdf_file' class='btn btn-primary'>Download Visitor Pass</a>
            </div>
            </div>
            <div class='d-flex align-items-center text-center gap-3 my-4'>
             <hr class='separator-hr1'>
             <small class='text-muted'>OR</small>
            <hr class='separator-hr2'>
            </div>
            <div class='text-center mt-4'>
                        <a href='index.html' class='btn btn-primary w-30'>Back to another Guest Login</a>
            </div>
    </body>
    </html>";

    // Output the pass as an HTML page
    echo $pass_content;
}
?>