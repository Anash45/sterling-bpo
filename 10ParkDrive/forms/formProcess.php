<?php
// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tContent = '';
    // echo json_encode($_REQUEST);
    $formType = $_REQUEST['form_type'];
    if ($formType == 'ContactForm') {
        // Sanitize input data if necessary
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $headers = "From: Contact Us - 10 Park Drive <webmaster@arzulmusheer.com>" . "\r\n";

        $tContent = '<thead>
                <tr>
                    <th colspa="2">10 Park Drive - Contact Us</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Name</td>
                <td>' . $name . '</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>' . $email . '</td>
            </tr>
            <tr>
                <td>Subject</td>
                <td>' . $subject . '</td>
            </tr>
            <tr>
                <td>Message</td>
                <td>' . $message . '</td>
            </tr>
        </tbody>';

    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'RegisterForm') {
        // Sanitize input data to prevent XSS and other attacks
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $working_with_realtor = htmlspecialchars($_POST['working_with_realtor']);
        $brokerage = htmlspecialchars($_POST['brokerage']);
        
        // Sanitize and implode contact methods
        $contact_methods = array_map('htmlspecialchars', $_POST['contact_method']);
        $contact_method_str = implode(', ', $contact_methods);
        
        $interested_in = htmlspecialchars($_POST['interested_in']);
        $heard_about_us = htmlspecialchars($_POST['heard_about_us']);

        $subject = "Register - Arzul Musheer";

        // Prepare the email headers (optional, for further processing)
        $headers = "From: Register Form <webmaster@arzulmusheer.com>" . "\r\n";

        // Create the HTML table content
        $tContent = '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan="2">Register Form Submission</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>First Name</td>
                    <td>' . $first_name . '</td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>' . $last_name . '</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>' . $email . '</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>' . $phone . '</td>
                </tr>
                <tr>
                    <td>Working with Realtor</td>
                    <td>' . $working_with_realtor . '</td>
                </tr>
                <tr>
                    <td>Brokerage</td>
                    <td>' . $brokerage . '</td>
                </tr>
                <tr>
                    <td>Contact Method</td>
                    <td>' . $contact_method_str . '</td>
                </tr>
                <tr>
                    <td>Interested In</td>
                    <td>' . $interested_in . '</td>
                </tr>
                <tr>
                    <td>Heard About Us</td>
                    <td>' . $heard_about_us . '</td>
                </tr>
            </tbody>
        </table>';
    }




    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Table</title>
        <style>
            /* CSS styles can be embedded directly within the HTML for email compatibility */
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            tbody{
                font-size: 1.5rem;
            }
        </style>
    </head>
    <body>
        <table>
            ' . $tContent . '
        </table>
    </body>
    </html>
    ';

    // Send email using mail() function
    $to = "info@arzulmusheer.com";
    $message = $html;
    $headers .= "CC: futuretest45@gmail.com";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        $emailStatus = true;
        $emailMessage = "Email sent successfully!";
    } else {
        $emailStatus = false;
        $emailMessage = "Error sending email.";
    }

    // print_r($responseFromGoogleScript);
    // Return JSON response

    // Prepare JSON response
    $response = [
        'emailStatus' => $emailStatus,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>