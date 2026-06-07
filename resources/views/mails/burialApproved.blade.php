<!DOCTYPE html>
<html>
<head>
    <title>Burial Approval Notification</title>
</head>
<body>
    <h2>Burial Approval Confirmation</h2>
    <p>Dear {{ $details['burial_registeredname']  }},</p>

    <p>Your burial request has been approved. Here are the details:</p>

    <ul>
        <li><strong>Buried Name:</strong> {{ $details['name'] }}</li>
        <li><strong>Registration ID:</strong> {{ $details['registrationId'] }}</li>
        <li><strong>Father Name:</strong> {{ $details['fatherName'] }}</li>
        <li><strong>Age:</strong> {{ $details['age'] }}</li>
        <li><strong>Date of Death:</strong> {{ $details['dateOfDeath'] }}</li>
        <li><strong>Grave ID:</strong> {{ $details['graveId'] }}</li>
        <li><strong>CNIC:</strong> {{ $details['cnic'] }}</li>
    </ul>

    <p>May Allah grant peace to the departed soul.</p>

    <p>Regards,<br>
    Cemetery Administration</p>
</body>
</html>
