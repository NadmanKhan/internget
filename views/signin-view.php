<main>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Sign in </h1>

        <form method="POST" action="/student-signup/index.php" class="row g-2" style="max-width: 600px;">
            <div class="form-group col-12">
                <label for="email">Email address</label>

                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                    autocomplete="email" value="<?= $email ?>" required>

                <div class="invalid-feedback">
                    <?= $email_err ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="password">Password</label>

                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password"
                    autocomplete="new-password" required value="<?= $password ?>">

                <div class="invalid-feedback">
                    <?= $password_err ?>
                </div>
            </div>

            <div class="form-group col-12">
                <input type="submit" name="submit" class="btn btn-primary mt-2" value="Sign in">
            </div>
        </form>
    </div>
</main>