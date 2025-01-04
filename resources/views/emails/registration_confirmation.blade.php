<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
            font-size: 24px;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .details {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .details ul {
            list-style-type: none;
            padding: 0;
        }
        .details li {
            padding: 8px 0;
            font-size: 16px;
            color: #555555;
        }
        .details li strong {
            color: #333333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Successful!</h1>
        <p>Dear {{ $user->name }},</p>
        <p>Thank you for registering with us. Your registration was successful! Here are your details:</p>

        <div class="details">
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>NIM:</strong> {{ $user->nim }}</li>
                <li><strong>Fakultas:</strong> {{ $user->fakultas }}</li>
                <li><strong>Prodi:</strong> {{ $user->prodi }}</li>
                <li><strong>Kelompok:</strong> {{ $user->kelompok }}</li>
            </ul>
        </div>

        <p>If you did not register, please contact the admin.</p>

        <div class="footer">
            <p>Best regards,<br>Our Team</p>
            <p><a href="mailto:support@example.com">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
