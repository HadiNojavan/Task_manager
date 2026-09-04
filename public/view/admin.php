<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>

</head>

<body>


    <h1>This page is for admins</h1>

    <h2>Hello <?= htmlspecialchars($_SESSION['username']) ?></h2>

    <a href="api/admin/users.php">To see all user info</a>

    <br>

    <a href="api/admin/all_tasks.php">To see all the tasks in database to update and delete and assign one task to many user</a>

    <br>
    <a href="api/admin/create.php">to add new admin</a>

    <br>
    <a href="api/admin/deleted_task.php">to resotre deleted tasks (because we use soft delete)</a>

    

    <form action="api/logout.php" method="post" style="position: absolute; top: 20px; right: 20px;">
    <button type="submit">Logout</button>
</form>

</body>

</html>