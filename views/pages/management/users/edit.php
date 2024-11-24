<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="/users/update/<?= $user['id'] ?>">
        <label>Username:</label>
        <input type="text" name="username" value="<?= $user['username'] ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
