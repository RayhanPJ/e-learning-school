<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/users/update/<?= $user['id'] ?>">
        <label>Username:</label>
        <input type="text" name="username" value="<?= $user['username'] ?>" required><br>
        <label>password:</label>
        <input type="text" name="password" value="<?= $user['password'] ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required><br>
        <label>Role:</label>
        <input type="text" name="role" value="<?= $user['role'] ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
