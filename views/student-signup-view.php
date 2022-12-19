<main>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Student Signup</h1>

        <form method="POST" action="/student-signup/index.php" class="row g-2" style="max-width: 600px;">
            <div class="form-group col-12">
                <label for="name" class="col-lg-6">Name</label>

                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name"
                    autocomplete="name" value="<?= $name ?>" required>

                <div class="invalid-feedback">
                    <?= $name_feedback ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="email">Email address</label>

                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                    autocomplete="email" value="<?= $email ?>" required>

                <div class="invalid-feedback">
                    <?= $email_feedback ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="password">Password</label>

                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password"
                    autocomplete="new-password" required value="<?= $password ?>">

                <div class="invalid-feedback">
                    <?= $password_feedback ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="confirm_password">Confirm Password</label>

                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Confirm your password" autocomplete="off" required
                    value="<?= $confirm_password ?>">

                <div class="invalid-feedback">
                    <?= $password_confirm_feedback ?>
                </div>
            </div>

            <div class="form-group col-12">
                <input type="submit" name="submit" class="btn btn-primary mt-2" value="Sign up">
            </div>
        </form>
    </div>
</main>