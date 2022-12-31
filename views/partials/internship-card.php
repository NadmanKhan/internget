<article class="card">
    <section class="card-header container">
        <div class="row my-2">
            <div class="col-10">
                <div class="mb-2">
                    <?php if ($internship['is_open']) { ?>
                        <span class="badge bg-success">
                            Open
                        </span>
                    <?php } else { ?>
                        <span class="badge bg-danger">
                            Closed
                        </span>
                    <?php } ?>

                    <?php if ($internship['hourly_pay'] > 0) { ?>
                        <span class="badge bg-primary">
                            $
                            <?= $internship['hourly_pay'] ?>
                            /hour
                        </span>
                    <?php } else { ?>
                        <span class="badge bg-warning">
                            Unpaid
                        </span>
                    <?php } ?>

                    <span class="badge bg-info">
                        <i class="fa fa-briefcase"></i>
                        <?= $internship['workplace_mode'] ?>
                    </span>

                    <span class="badge bg-info">
                        <i class="fa fa-map-marker-alt"></i>
                        <?= $internship['location'] ?>
                    </span>

                    <span class="badge bg-info">
                        <i class="fa fa-calendar"></i>
                        <?= $internship['start_date'] ?>
                    </span>

                    <span class="badge bg-info">
                        <i class="fa fa-clock"></i>
                        <?= $internship['duration'] ?> months
                    </span>
                </div>

                <h3 class="col-12 card-title">
                    <span>
                        <?= $internship['position'] ?>
                    </span>
                    <span class="text-muted ms-1">
                        <i class="fa fa-at"></i>
                        <?= $internship['org_name'] ?>
                    </span>
                </h3>
            </div>

            <div class="col-2 text-end p-2">
                <i class="btn fa-xl fa-regular fa-star text-warning star-button" data-id="<?= $internship['internshp_id'] ?>"></i>
            </div>
        </div>
    </section>

    <section class="card-body container" style="max-height: 15rem; overflow: scroll;">
        <div>
            <span class="badge bg-secondary">
                <i class="fa fa-calendar"></i>
                <?= $internship['schedule'] ?>
            </span>
            <span class="badge bg-secondary">
                <i class="fa fa-clock"></i>
                <?= $internship['days_per_week'] ?> days/week
            </span>
            <span class="badge bg-secondary">
                <i class="fa fa-clock"></i>
                <?= $internship['hours_per_week'] ?> hours/week
            </span>
        </div>

        <div class="my-1">
            <small class="text-muted">
                Description
            </small>
            <p class="card-text">
                <?= $internship['description'] ?>
            </p>
        </div>
    </section>

    <section class="card-footer container">
        <div class="row">
            <div class="col-12 text text-end">
                <a href="#" class="btn btn-outline-primary">
                    <i class="fa fa-eye me-1"></i>
                    View in full detail
                </a>

                <a href="mailto:<?= $internship['org_email'] ?>" class="btn btn-primary">
                    <i class="fa fa-envelope me-1"></i>
                    Contact/Apply
                </a>
            </div>
        </div>
    </section>
</article>