<main>
    <section class="container-fluid justify-content-center border rounded-top">
        <form role="form" action="<?= $page['url']; ?>" method="get">
            <section id="search_form_misc" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Miscellaneous</small>

                <div class="form-group col-sm-12 col-md-12">
                    <label for="tags" class="form-label mb-0">Tags</label>

                    <div role="textbox" class="multiselect" id="tags" data-name="tags" data-must-match-options data-max-select="10" data-use-cookies></div>
                </div>
            </section>

            <section id="search_form_role" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Role</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="positions" class="form-label mb-0">Positions</label>

                    <div role="textbox" class="multiselect" id="positions" data-name="positions" data-must-match-options data-max-select="10" data-use-cookies></div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="domains" class="form-label mb-0">Domains of work</label>

                    <div role="textbox" class="multiselect" id="domains" data-name="domains" data-must-match-options data-max-select="10" data-use-cookies></div>
                </div>
            </section>

            <section id="search_form_workplace" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Workplace</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="workplace_modes" class="form-label">Mode</label>

                    <div id="workplace_modes">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_modes[]" id="remote" value="remote" <?php if (isset($workplace_modes) && in_array('remote', $workplace_modes))
                                                                                                                                    echo 'checked'; ?>>

                            <label for="remote" class="form-check-label">Remote/virtual</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_modes[]" id="in-person" value="in-person" <?php if (isset($workplace_modes) && in_array('in-person', $workplace_modes))
                                                                                                                                            echo 'checked'; ?>>

                            <label for="in-person" class="form-check-label">In-person</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="workplace_modes[]" id="mixed" value="mixed" <?php if (isset($workplace_modes) && in_array('mixed', $workplace_modes))
                                                                                                                                    echo 'checked'; ?>>

                            <label for="mixed" class="form-check-label">Mixed</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="orgs" class="form-label mb-0">Organization names</label>

                    <div role="textbox" class="multiselect" id="orgs" data-name="orgs" data-must-match-options data-max-select="10" data-use-cookies></div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="locations" class="form-label mb-0">Locations (city and country)</label>

                    <div role="textbox" class="multiselect" id="locations" data-name="locations" data-must-match-options data-max-select="10" data-use-cookies></div>

                    <div class="invalid-feedback">fff</div>
                </div>
            </section>

            <section id="search_form_compensation" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Compensation</small>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="bonus" class="form-label">Bonus</label>

                    <div id="bonus">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="bonus" id="has_bonus" value="has_bonus" <?php if ($bonus)
                                                                                                                                echo 'checked'; ?>>

                            <label for="has_bonus" class="form-check-label">Has bonus?</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="min_pay" class="form-label mb-0">Minimum hourly pay</label>

                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>

                        <input type="number" class="form-control form-control-sm" name="min_pay" id="min_pay" value="<?= $min_pay ?>" min="0" max="100000" step="0.01">

                        <span class="input-group-text">/ hr</span>
                    </div>
                </div>
            </section>

            <section id="search_form_time" class="row border rounded g-2 px-1 py-2 pt-0 g-1 mb-2 m-3">
                <small class="text-secondary p-1 col-12">Time commitment</small>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="schedules" class="form-label">Type</label>

                    <div id="schedules">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="schedules[]" id="part-time" value="part-time">

                            <label for="part-time" class="form-check-label">Part-time</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="schedules[]" id="full-time" value="full-time">

                            <label for="full-time" class="form-check-label">Full-time</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="schedules[]" id="flexible" value="flexible">

                            <label for="flexible" class="form-check-label">Flexible</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="schedules[]" id="project-based" value="project-based">

                            <label for="project-based" class="form-check-label">Project-based</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="start_date" class="form-label mb-0">Start date</label>

                    <div class="d-flex flex-column flex-sm-row" id="start_date">
                        <div class="form-group form-group-sm m-1">
                            <label for="start_date_min" class="form-label mb-0">Minimum</label>

                            <input type="date" class="form-control form-control-sm" name="start_date_min" id="start_date_min">
                        </div>

                        <div class="form-group form-group-sm m-1">
                            <label for="start_date_max" class="form-label mb-0">Maximum</label>

                            <input type="date" class="form-control form-control-sm" name="start_date_max" id="start_date_max">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="duration" class="form-label mb-0">Duration (in months)</label>

                    <div class="d-flex flex-column flex-sm-row" id="duration">
                        <div class="form-group form-group-sm p-1">
                            <label for="duration_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="duration_min" id="duration_min">
                        </div>
                        <div class="form-group form-group-sm p-1">

                            <label for="duration_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="duration_max" id="duration_max">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="days_per_week" class="form-label mb-0">Days per week</label>

                    <div class="d-flex flex-column flex-sm-row" id="days_per_week">
                        <div class="form-group form-group-sm m-1">

                            <label for="days_per_week_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="days_per_week_min" id="days_per_week_min" min="1" max="7">
                        </div>
                        <div class="form-group form-group-sm m-1">

                            <label for="days_per_week_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="days_per_week_max" id="days_per_week_max" min="1" max="7">
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="hours_per_week" class="form-label mb-0">Hours per week</label>

                    <div class="d-flex flex-column flex-sm-row" id="hours_per_week">
                        <div class="form-group form-group-sm m-1">
                            <label for="hours_per_week_min" class="form-label mb-0">Minimum</label>

                            <input type="number" class="form-control form-control-sm" name="hours_per_week_min" id="hours_per_week_min" min="1" max="6">
                        </div>
                        <div class="form-group form-group-sm m-1">

                            <label for="hours_per_week_max" class="form-label mb-0">Maximum</label>

                            <input type="number" class="form-control form-control-sm" name="hours_per_week_max" id="hours_per_week_max" min="1" max="6">
                        </div>
                    </div>
                </div>
            </section>

            <section id="search_form_submit" class="row justify-content-center align-items-center">
                <input type="submit" id="search" name="search" value="Search" class="btn btn-primary m-2" style="max-width: 200px;">
            </section>
        </form>
    </section>

    <section class="container-fluid justify-content-center p-1">
        <div class="row">
            <div class="col-12 mt-5">
                <h2 class="text-center">Search results</h2>
            </div>
        </div>

        <div class="row">
            <?php foreach ($internships as $internship) { ?>
                <div class="col-12 my-3">
                    <?php require getenv('APP_VIEW_PARTIALS_DIR') . '/internship-card.php'; ?>
                </div>
            <?php } ?>
        </div>
    </section>
</main>