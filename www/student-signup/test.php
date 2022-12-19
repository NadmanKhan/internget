<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php foreach ($page_css as $file) { ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/<?= $file ?>.css">
    <?php } ?>

    <!-- Bootstrap JavaScript libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"
        async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"
        async defer></script>

    <?php foreach ($page_js as $file) { ?>
    <!-- Custom JS -->
    <script src="/assets/js/<?= $file ?>.js" defer></script>
    <?php } ?>

    <title>Student Signup</title>
</head>

<body>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Student Signup</h1>

        <form class="row g-2" style="max-width: 600px;">
            <div class="form-group col-12">
                <label for="name" class="col-lg-6">Name</label>

                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name"
                    autocomplete="name">
            </div>

            <div class="form-group col-12">
                <label for="email">Email address</label>

                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autocomplete="email">
            </div>

            <div class="form-group col-12">
                <label for="password">Password</label>

                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password"
                    autocomplete="new-password">
            </div>

            <div class="form-group col-12">
                <label for="confirm_password">Confirm Password</label>

                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
                    autocomplete="off">
            </div>

            <div class="form-group col-12">
                <input type="submit" class="btn btn-primary mt-2" value="Sign up">
            </div>
        </form>
    </div>
</body>

</html>