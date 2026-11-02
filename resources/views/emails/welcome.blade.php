<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>

<body style="margin:0; padding:30px; background:#f4f4f4;
             font-family:Arial,sans-serif;">

    <div style="max-width:600px; margin:auto; background:white;
                padding:30px; border-radius:8px;">

        <h2 style="color:#2563eb;">
            Welcome to User Portal!
        </h2>

        <p>Hello {{ $user->name }},</p>

        <p>
            Thank you for registering with us.
            Your account has been successfully created.
        </p>

        <p>
            You can now log in and update your profile
            and manage your education qualifications.
        </p>

        <div style="margin:30px 0;">

            <a href="{{ route('login') }}"
               style="background:#2563eb; color:white;
                      padding:12px 25px; text-decoration:none;
                      border-radius:5px;">

                Login to Your Account

            </a>

        </div>

        <p>
            Regards,<br>
            <strong>User Portal Team</strong>
        </p>

    </div>

</body>
</html>