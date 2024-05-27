<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h1>Welcome to the Dashboard, <?php echo isset($user) ? htmlspecialchars($user->username) : 'Guest'; ?></h1>
        <?php if (isset($user) && $user->isAdmin()) : ?>
            <p>You have admin privileges.</p>
            <h2>All Users</h2>
            <?php if (!empty($users)) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Powers</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $u) : ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($u['username']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo htmlspecialchars($u['powers']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No users found.</p>
            <?php endif; ?>

        <?php else : ?>
            <p>You are a guest user.</p>
        <?php endif; ?>
        <a href="/logout" class="btn btn-danger">Logout</a> <!-- إضافة زر تسجيل الخروج -->
    </div>
</body>

</html>