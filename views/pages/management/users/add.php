<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <form method="POST" action="/users/store">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
