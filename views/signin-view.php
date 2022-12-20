<main>
    <h1>Sign In</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="validate_signin">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Sign In">
    </form>
    
</main>