<?php
// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tContent = '';
    $formType = $_REQUEST['form_type'];
    if ($formType == 'ContactForm') {
        // Sanitize input data if necessary
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Prepare form data
        $formData = http_build_query([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'form_type' => $formType
        ]);
        $headers = "From: Contact Us - Sterling BPO <webmaster@sterlingbpo.co.uk>" . "\r\n";

        $tContent = '<thead>
                <tr>
                    <th colspa="2">BPO Contact Us</th>
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

    } elseif ($formType == 'SubscriberForm') {
        $email = $_POST['email'];
        $subject = "Subscriber Entry";
        $headers = "From: Subscribe - Sterling BPO <webmaster@sterlingbpo.co.uk>" . "\r\n";

        // Prepare form data
        $formData = http_build_query([
            'email' => $email,
            'form_type' => $formType
        ]);

        $tContent = '<thead>
                <tr>
                    <th colspa="2">BPO Subscriber</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Email</td>
                <td>' . $email . '</td>
            </tr>
        </tbody>';
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