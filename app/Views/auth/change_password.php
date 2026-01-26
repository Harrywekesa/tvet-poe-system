<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            width: 100%;
            max-width: 400px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }

        .error {
            color: #dc2626;
            font-size: 0.9rem;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="box">
        <h2 style="text-align: center; margin-top: 0; color: #1e293b;">Change Password</h2>
        <p style="text-align: center; color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            You are required to change your password before proceeding.
        </p>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="<?= APP_URL ?>/change-password" method="POST">
            <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">New Password</label>
            <input type="password" name="new_password" required minlength="6">

            <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Confirm Password</label>
            <input type="password" name="confirm_password" required minlength="6">

            <button type="submit">Update Password</button>
        </form>
    </div>
</body>

</html>