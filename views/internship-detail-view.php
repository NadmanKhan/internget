<main>
    <div class="container mt-5">
        <h1>
            <span><?= $internship['position_name'] ?></span>
            <span class="text-muted">
                <i class="fa-solid fa-at"></i>
                <?= $internship['organization']['name'] ?>
            </span>
        </h1>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Workplace Information</h2>
                <dl>
                    <dt>Organization name</dt>
                    <dd><?= $internship['organization']['name'] ?></dd>

                    <dt>Country</dt>
                    <dd><?= $internship['city_name'] ?? '-' ?></dd>

                    <dt>City</dt>
                    <dd><?= $internship['country_name'] ?? '-' ?></dd>
                </dl>
            </div>

            <div class="col-md-6">
                <h2>Internship Information</h2>
                <dl>
                    <dt>Position</dt>
                    <dd><?= $internship['position_name'] ?></dd>

                    <dt>Duration</dt>
                    <dd><?= $internship['duration'] ?> months</dd>

                    <dt>Hourly pay</dt>
                    <dd>$<?= $internship['hourly_pay'] ?>/week</dd>
                </dl>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Internship Description</h2>
                <p>
                    <?= $internship['description'] ?>
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Qualifications</h2>
                <p>
                    <?= $internship['qualifications'] ?>
                </p>
            </div>
            <div class="col-md-6">
                <h2>Responsibilities</h2>
                <p>
                    <?= $internship['responsibilities'] ?>
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Application Process</h2>
                <p>
                    <?= $internship['application_process'] ?>
                </p>
            </div>
        </div>

        <?php if ($user['type'] === 'student') { ?>

            <div class="row mt-5">
                <div class="col-md-12 d-flex gap-2">
                    <!-- apply button -->
                    <a href="mailto:<?= $internship['organization_email'] ?>" class="btn btn-primary">Apply/Contact</a>

                    <!-- bookmark internship button -->
                    
                </div>
            </div>

        <?php } ?>
    </div>
</main>