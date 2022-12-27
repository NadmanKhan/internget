<!DOCTYPE html>
<html>

<head>

    <!-- Page title -->
    <title>
       <?= $page['title'] ?? 'Internships' ?> | Internget
    </title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= ($page_description ?? 'Find your desired internship'); ?>">

    <!-- Bootstrap v5.2.3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- FontAwesome v6.2.1 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php foreach ($page['css_sources'] ?? [] as $css_file) { ?>
        <!-- Page CSS source -->
        <link rel="stylesheet" href="<?= $css_file ?>">
    <?php } ?>

    <?php if (isset($page['style_tag'])) { ?>
        <!-- Page style tag -->
        <style>
            <?= $page['style_tag'] ?>
        </style>
    <?php } ?>
    
    <!-- Bootstrap v5.2.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" async defer></script>
</head>

<body>

    <div class="container-fluid">
        <header>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/partials/header.php'); ?>
        </header>
    </div>

    <div class="container-fluid mt-5">
        <?= $page['content'] ?? '' ?>
    </div>

    <div class="container-fluid">
        <footer>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/partials/footer.php'); ?>
        </footer>
    </div>

    <?php if (isset($page['script_tag'])) { ?>
        <!-- Page script tag -->
        <script>
            <?= $page['script_tag'] ?>
        </script>
    <?php } ?>
    
    <?php foreach ($page['js_sources'] ?? [] as $js_file) { ?>
        <!-- Page JS source -->
        <script src="<?= $js_file ?>" defer></script>
    <?php } ?>
</body>

</html>