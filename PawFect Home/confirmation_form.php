<!-- confirmation_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Form</title>
</head>
<body>
    <h2>Confirmation Form</h2>
    <form action="user_registration_script.php" method="post">
        <!-- Include necessary hidden fields here to pass data to the user_registration_script.php -->
        <input type="hidden" name="confirmation" value="true">
        <button type="submit">Confirm and Post Ad</button>
        <button type="button" onclick="window.history.back();">Go Back</button>
    </form>
</body>
</html>
