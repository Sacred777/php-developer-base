<?php

require_once __DIR__ . '/autoload.php';

use \Entities\User;

$user = new User();

if (!empty($_POST)) {
    switch ($_POST['btn']) {
        case 'Add user':
            $user->create([
                'email' => trim($_POST['email']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'age' => trim($_POST['age']),
            ]);
            break;
        case 'Edit':
            $user->update([
                'id' => $_POST['id'],
                'email' => trim($_POST['email']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'age' => trim($_POST['age']),
            ]);
            break;
        case 'Delete':
            $user->delete($_POST['id']);
            break;
    }
}

$users = $user->list();

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>User Data management</title>
</head>

<body>
<div class="container pt-4 pb-4">
    <h1 class="mb-3">User management</h1>
    <h2>Users list</h2>

    <table class="table table-striped mb-5">
        <thead class="table__head">
        <tr class="table__head-row">
            <th class="table__head-col" scope="col">ID</th>
            <th class="table__head-col" scope="col">Email</th>
            <th class="table__head-col" scope="col">First name</th>
            <th class="table__head-col" scope="col">Second name</th>
            <th class="table__head-col" scope="col">Age</th>
            <th class="table__head-col" scope="col">Created date</th>
            <th class="table__head-col" scope="col">Actions</th>
        </tr>
        </thead>
        <tbody class="table__body">

        <?php
        foreach ($users as $user) {
            echo "
                    <form class='edit-form' action='index.php' method='post'>
                        <tr class='table__body-row'>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' value={$user['id']} disabled>
                                <input type='hidden' name='id' value={$user['id']}>
                            </td>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' name='email' value={$user['email']}>
                            </td>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' name='first_name' value={$user['first_name']}>
                            </td>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' name='last_name' value={$user['last_name']}>
                            </td>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' name='age' value={$user['age']}>
                            </td>
                            <td class='table__body-col'>
                                <input type='text' class='form-control' name='date_created' value={$user['date_created']} disabled>
                            </td>
                            <td class='table__body-col action'>
                                <input class='btn btn-link btn-primary' type='submit' name='btn' value='Edit'>
                                <input class='btn btn-link btn-danger' type='submit' name='btn' value='Delete'>
                            </td>
                        </tr>
                    </form>
                ";
        }
        ?>

        </tbody>
    </table>

    <h2>Add a user</h2>
    <form class="add-form" action="index.php" method="post">
        <div class="form-group">
            <label>
                Email
                <input class="form-control" type="email" name="email" aria-describedby="emailHelp">
            </label>
            <small id="emailHelp" class="form-text text-muted">We'll never give your email to anyone.</small>
        </div>
        <div class="form-group">
            <label>
                First name
                <input class="form-control" type="text" name="first_name">
            </label>
        </div>
        <div class="form-group">
            <label>
                Last name
                <input class="form-control" type="text" name="last_name">
            </label>
        </div>
        <div class="form-group">
            <label>
                Age
                <input class="form-control" type="number" min=14 max=130 name="age">
            </label>
        </div>
        <input type="submit" class="btn btn-primary" name="btn" value="Add user">
    </form>
</div>
</body>
</html>
