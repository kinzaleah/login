<!DOCTYPE html>

<html>
    <head>
    <title>My first PHP Website</title>
    </head>

    <body>

      <h2>Login Page</h2>

      <a href ="index.php">Click here to go back</a>

      <form action="checklogin.php" method="POST">
        <p>Username: <input type="text" name="username" required ="required" /></p>
        <p>Password: <input type="password" name="password" required ="required" /></p>
        <p><input type="submit" value="Log In" /></p>

      </form>


    </body>


</html>
