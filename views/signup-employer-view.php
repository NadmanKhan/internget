<main>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Employer Sign-up</h1>

        <form method="POST" action="<?= $page_url ?>" class="row g-2" style="max-width: 600px;">
            <div class="form-group col-12">
                <label for="name">Employer oganization name</label>

                <input type="text" class="form-control <?= ($name_error ? 'is-invalid' : null) ?>" id="name" name="name" placeholder="Enter the organization's name" autocomplete="organization" required value="<?= $name ?>">

                <div class="invalid-feedback"><?= $name_error ?></div>
            </div>

            <div class="form-group col-12">
                <label for="email">Email address</label>

                <input type="email" class="form-control <?= ($email_error ? 'is-invalid' : null) ?>" id="email" name="email" placeholder="Enter your email" autocomplete="email" required value="<?= $email ?>">

                <div class="invalid-feedback"><?= $email_error ?></div>
            </div>

            <div class="form-group col-12">
                <label for="password">Password</label>

                <input type="password" class="form-control <?= ($password_error ? 'is-invalid' : null) ?>" id="password" name="password" placeholder="Enter a password" autocomplete="new-password" required value="<?= $password ?>">

                <div class="invalid-feedback"><?= $password_error ?></div>
            </div>

            <div class="form-group col-12">
                <label for="confirm_password">Confirm Password</label>

                <input type="password" class="form-control <?= ($confirm_password_error ? 'is-invalid' : null) ?>" id="confirm_password" name="confirm_password" placeholder="Confirm your password" autocomplete="off" required value="<?= $confirm_password ?>">

                <div class="invalid-feedback">
                    <?= $confirm_password_error ?>
                </div>
            </div>

            <div class="p-0">
                <div class="d-none <?= ($main_error ? 'is-invalid' : null) ?>"></div>
                <div class="invalid-feedback p-2">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <?= $main_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <input type="submit" name="submit" class="btn btn-primary mt-2" value="Sign up">
            </div>
        </form>
    </div>

</main>