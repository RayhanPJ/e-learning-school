<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/users/store">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>role:</label>
        <input type="text" name="role" required><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
