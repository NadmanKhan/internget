<main>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Create a new internship</h1>

        <form method="POST" action="<?= $page['url'] ?>" class="row g-2">
            <div class="form-group col-12">
                <label for="position">Position</label>

                <div role="textbox" class="multiselect <?= $position_error ? 'is-invalid' : null ?>" id="position"
                    data-name="position" data-max-select="1" data-on-max-exceed="alert"></div>

                <div class="invalid-feedback">
                    <?= $position_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="description">A short description</label>

                <textarea class="form-control <?= $description_error ? 'is-invalid' : null ?>" id="description"
                    name="description" rows="3"><?= $description ?></textarea>

                <div class="invalid-feedback">
                    <?= $description_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="qualifications">Qualifications</label>

                <textarea class="form-control <?= $qualifications_error ? 'is-invalid' : null ?>" id="qualifications"
                    name="qualifications" rows="3"><?= $qualifications ?></textarea>

                <div class="invalid-feedback">
                    <?= $qualifications_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="responsibilities">Responsibilities</label>

                <textarea class="form-control <?= $responsibilities_error ? 'is-invalid' : null ?>"
                    id="responsibilities" name="responsibilities" rows="3"><?= $responsibilities ?></textarea>

                <div class="invalid-feedback">
                    <?= $responsibilities_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="application_process">Application process</label>

                <textarea class="form-control <?= $application_process_error ? 'is-invalid' : null ?>"
                    id="application_process" name="application_process" rows="3"><?= $application_process ?></textarea>

                <div class="invalid-feedback">
                    <?= $application_process_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="contact_details">Contact details</label>

                <textarea class="form-control <?= $contact_details_error ? 'is-invalid' : null ?>" id="contact_details"
                    name="contact_details" rows="3"><?= $contact_details ?></textarea>

                <div class="invalid-feedback">
                    <?= $contact_details_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="tags">Tags</label>

                <div class="multiselect <?= $tags_error ? 'is-invalid' : null ?>" id="tags" data-name="tags"
                    data-max-select="12" data-on-max-exceed="alert"></div>

                <div class="invalid-feedback">
                    <?= $tags_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="domains">Domains of work</label>

                <div class="multiselect <?= $domains_error ? 'is-invalid' : null ?>" id="domains" data-name="domains"
                    data-max-select="3" data-on-max-exceed="alert"></div>

                <div class="invalid-feedback">
                    <?= $domains_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="workplace_mode">Workplace Mode</label>

                <select class="form-control <?= $workplace_mode_error === 'in-person' ? 'is-invalid' : null ?>"
                    id="workplace_mode" name="workplace_mode">
                    <option value="in-person" <?= $workplace_mode === 'in-person' ? 'selected' : null ?>>
                        In-person
                    </option>

                    <option value="remote" <?= $workplace_mode === 'remote' ? 'selected' : null ?>>
                        Remote (virtual)
                    </option>

                    <option value="mixed" <?= $workplace_mode === 'mixed' ? 'selected' : null ?>>
                        Mixed (in-person and remote)
                    </option>
                </select>

                <div class="invalid-feedback">
                    <?= $workplace_mode_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="location">Location</label>

                <div class="multiselect <?= $location_error ? 'is-invalid' : null ?>" id="location" data-name="location"
                    data-max-select="1" data-on-max-exceed="alert" data-must-match-options>
                </div>

                <div class="invalid-feedback">
                    <?= $location_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="hourly_pay">Hourly pay</label>

                <input type="number" class="form-control <?= $hourly_pay_error ? 'is-invalid' : null ?>" id="hourly_pay"
                    name="hourly_pay" step="0.01" value="<?= $hourly_pay ?>">

                <div class="invalid-feedback">
                    <?= $hourly_pay_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="has_bonus" name="has_bonus" <?= $has_bonus ? 'checked' : null ?>>

                    <label class="form-check-label" for="has_bonus">Has bonus?</label>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="schedule">Schedule</label>

                <select class="form-control <?= $schedule_error ? 'is-invalid' : null ?>" id="schedule" name="schedule">
                    <option value="full-time">
                        <?= $schedule === 'full-time' ? 'selected' : null ?>
                        Full-time
                    </option>

                    <option value="part-time">
                        <?= $schedule === 'part-time' ? 'selected' : null ?>
                        Part-time
                    </option>

                    <option value="flexible">
                        <?= $schedule === 'flexible' ? 'selected' : null ?>
                        Flexible
                    </option>

                    <option value="project-based">
                        <?= $schedule === 'project-based' ? 'selected' : null ?>
                        Project-based
                    </option>
                </select>
            </div>

            <div class="form-group col-12">
                <label for="start_date">Start date</label>

                <input type="date" class="form-control <?= $start_date_error ? 'is-invalid' : null ?>" id="start_date"
                    name="start_date" value="<?= $start_date ?>">

                <div class="invalid-feedback">
                    <?= $start_date_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="duration">Duration in months</label>

                <input type="number" class="form-control <?= $duration_error ? 'is-invalid' : null ?>" id="duration"
                    name="duration" value="<?= $duration ?>">

                <div class="invalid-feedback">
                    <?= $duration_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="hours_per_week">Hours per Week</label>

                <input type="number" class="form-control <?= $hours_per_week_error ? 'is-invalid' : null ?>"
                    id="hours_per_week" name="hours_per_week" value="<?= $hours_per_week ?>">

                <div class="invalid-feedback">
                    <?= $hours_per_week_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="days_per_week">Days per Week</label>

                <input type="number" class="form-control <?= $days_per_week_error ? 'is-invalid' : null ?>"
                    id="days_per_week" name="days_per_week" value="<?= $days_per_week ?>">

                <div class="invalid-feedback">
                    <?= $days_per_week_error ?>
                </div>
            </div>

            <div class="p-0 col-12">
                <div class="d-none <?= $main_error ? 'is-invalid' : null ?>"></div>
                <div class="invalid-feedback p-2">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <?= $main_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <input type="submit" name="create" class="btn btn-primary mt-2" value="Create">
            </div>
        </form>
    </div>
</main>