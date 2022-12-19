<?php


function chips_autocomplete($name, $id = 'SAME_AS_NAME')
{
    if ($id === 'SAME_AS_NAME') {
        $id = $name;
    }

    $value = $GLOBALS[$name] ?? '';
    if (is_array($value)) {
        $value = implode(',', $value);
    }

    return <<<HTML
            <div class="chips-autocomplete dropdown" id="$id">
                <div class="chip-container">
                </div>

                <input type="text" class="selected-options" name="$name" value="$value">

                <input type="text" autocomplete="off" class="chip-input dropdown-toggle" data-bs-toggle="dropdown">

                <ul class="autocomplete-menu dropdown-menu">
                </ul>
            </div>
HTML;
}

?>

<main>
    <section class="container-fluid justify-content-center border rounded-top">
        <form role="form" action="/index.php" method="get">
            <section id="search_form_misc" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Miscellaneous</small>

                <!-- <div class="form-group col-sm-12 col-md-12">
                    <label for="keywords" class="form-label mb-0">Keywords (search in all fields)</label>

                    <?= chips_autocomplete('keywords') ?>
                </div> -->

                <div class="form-group col-sm-12 col-md-12">
                    <label for="tags" class="form-label mb-0">Tags</label>

                    <?= chips_autocomplete('tags') ?>
                </div>
            </section>

            <section id="search_form_role" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Role</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="positions" class="form-label mb-0">Positions</label>

                    <?= chips_autocomplete('positions') ?>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="domains" class="form-label mb-0">Domains/industries/fields of study</label>

                    <?= chips_autocomplete('domains') ?>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="skills_required" class="form-label mb-0">Skills required</label>

                    <?= chips_autocomplete('skills_required') ?>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="skills_learnable" class="form-label mb-0">Skills learnable</label>

                    <?= chips_autocomplete('skills_learnable') ?>
                </div>
            </section>

            <section id="search_form_workplace" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Workplace</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="workplace_mode" class="form-label">Mode</label>

                    <div id="workplace_mode">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_mode[]" id="remote"
                                value="remote" <?php if (in_array('remote', $workplace_mode))
                                    echo 'checked'; ?>>

                            <label for="remote" class="form-check-label">Remote/virtual</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_mode[]" id="in_office"
                                value="in_office" <?php if (in_array('in_office', $workplace_mode))
                                    echo 'checked'; ?>>

                            <label for="in_office" class="form-check-label">In-office</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_mode[]" id="hybrid"
                                value="hybrid" <?php if (in_array('hybrid', $workplace_mode))
                                    echo 'checked'; ?>>

                            <label for="hybrid" class="form-check-label">Hybrid (both remote & in-office)</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="orgs" class="form-label mb-0">Organization names</label>

                    <?= chips_autocomplete('orgs') ?>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="cities" class="form-label mb-0">Cities</label>

                    <?= chips_autocomplete('cities') ?>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="countries" class="form-label mb-0">Countries</label>

                    <?= chips_autocomplete('countries') ?>
                </div>
            </section>

            <section id="search_form_compensation" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Compensation</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="bonus" class="form-label">Bonus</label>

                    <div id="bonus">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="bonus" id="has_bonus"
                                value="has_bonus" <?php if ($bonus)
                                    echo 'checked'; ?>>

                            <label for="has_bonus" class="form-check-label">Has bonus?</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="min_pay" class="form-label mb-0">Minimum hourly pay</label>

                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>

                        <input type="number" class="form-control form-control-sm" name="min_pay" id="min_pay"
                            value="<?= $min_pay ?>" min="0" max="100000" step="0.01">

                        <span class="input-group-text">/ hr</span>
                    </div>
                </div>
            </section>

            <section id="search_form_time" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Time commitment</small>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="time_type" class="form-label">Type</label>

                    <div id="time_type">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="time_type[]" id="part_time"
                                value="part_time">

                            <label for="part_time" class="form-check-label">Part-time</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="time_type[]" id="full_time"
                                value="full_time">

                            <label for="full_time" class="form-check-label">Full-time</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="time_type[]" id="project_based"
                                value="project_based">

                            <label for="project_based" class="form-check-label">Project-based</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="start_date" class="form-label mb-0">Start date</label>

                    <div class="d-flex flex-column flex-sm-row" id="start_date">
                        <div class="form-group form-group-sm m-1">
                            <label for="start_date_min" class="form-label mb-0">Minimum</label>

                            <input type="date" class="form-control form-control-sm" name="start_date_min"
                                id="start_date_min">
                        </div>

                        <div class="form-group form-group-sm m-1">
                            <label for="start_date_max" class="form-label mb-0">Maximum</label>

                            <input type="date" class="form-control form-control-sm" name="start_date_max"
                                id="start_date_max">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="duration" class="form-label mb-0">Duration (in months)</label>

                    <div class="d-flex flex-column flex-sm-row" id="duration">
                        <div class="form-group form-group-sm p-1">
                            <label for="duration_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="duration_min"
                                id="duration_min">
                        </div>
                        <div class="form-group form-group-sm p-1">

                            <label for="duration_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="duration_max"
                                id="duration_max">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="days_per_week" class="form-label mb-0">Days per week</label>

                    <div class="d-flex flex-column flex-sm-row" id="days_per_week">
                        <div class="form-group form-group-sm m-1">

                            <label for="days_per_week_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="days_per_week_min"
                                id="days_per_week_min" min="1" max="7">
                        </div>
                        <div class="form-group form-group-sm m-1">

                            <label for="days_per_week_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="days_per_week_max"
                                id="days_per_week_max" min="1" max="7">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="hours_per_week" class="form-label mb-0">Hours per week</label>

                    <div class="d-flex flex-column flex-sm-row" id="hours_per_week">
                        <div class="form-group form-group-sm m-1">
                            <label for="hours_per_week_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="hours_per_week_min"
                                id="hours_per_week_min" min="1" max="6">
                        </div>
                        <div class="form-group form-group-sm m-1">

                            <label for="hours_per_week_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="hours_per_week_max"
                                id="hours_per_week_max" min="1" max="6">
                        </div>
                    </div>
                </div>
            </section>

            <section id="search_form_submit" class="row justify-content-center align-items-center">
                <input type="submit" id="search" name="search" value="Search" class="btn btn-primary btn-sm m-2"
                    style="max-width: 200px;">
            </section>
        </form>
    </section>

    <section class="container-fluid justify-content-center border rounded-bottom p-1">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Search results</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php for ($i = 0; $i < 20; ++$i) { ?>
                <article class="card m-3">
                    <div class="card-header">
                        <div class="card-header-pills">
                            <span class="badge rounded-pill text-bg-secondary">$20 / hr</span>
                            <span class="badge rounded-pill text-bg-secondary">front-end web development</span>
                            <span class="badge rounded-pill text-bg-secondary">web development</span>
                            <span class="badge rounded-pill text-bg-secondary">software development</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make
                            up the
                            bulk
                            of the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>

                </article>
                <?php } ?>
            </div>
        </div>
    </section>
</main>