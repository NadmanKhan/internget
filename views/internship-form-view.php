<main>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5 mw-100">
        <h1>Create a new internship</h1>

        <form method="POST" action="<?= $page_url ?>" class="row g-2">
            <div class="form-group col-12">
                <label for="position">Position</label>

                <div role="textbox" class="chips-autocomplete form-control form-control-sm" id="position" data-name="position" data-initial-value="<?= $position ?>" data-select-single></div>

                <div class="invalid-feedback">
                    <?= $position_error ?>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="description">A short description</label>

                <textarea class="form-control form-control-sm" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="form-group col-12">
                <label for="qualifications">Qualifications</label>

                <textarea class="form-control form-control-sm" id="qualifications" name="qualifications" rows="3"></textarea>
            </div>

            <div class="form-group col-12">
                <label for="responsibilities">Responsibilities</label>

                <textarea class="form-control form-control-sm" id="responsibilities" name="responsibilities" rows="3"></textarea>
            </div>

            <div class="form-group col-12">
                <label for="application_process">Application process</label>

                <textarea class="form-control form-control-sm" id="application_process" name="application_process" rows="3"></textarea>
            </div>

            <div class="form-group col-12">
                <label for="contact_details">Contact details</label>

                <textarea class="form-control form-control-sm" id="contact_details" name="contact_details" rows="3"></textarea>
            </div>

            <div class="form-group col-12">
                <label for="tags">Tags</label>

                <div class="chips-autocomplete form-control form-control-sm" id="tags" data-name="tags" data-initial-value="<?= $tags ?>"></div>
            </div>

            <div class="form-group col-12">
                <label for="domains">Domains of work</label>

                <div class="chips-autocomplete form-control form-control-sm" id="domains" data-name="domains" data-initial-value="<?= $domains ?>"></div>
            </div>

            <div class="form-group col-12">
                <label for="workplace_mode">Workplace Mode</label>

                <select class="form-control form-control-sm" id="workplace_mode" name="workplace_mode">
                    <option value="in-person" <?php if ($workplace_mode == 'in-person') echo 'selected' ?>
                    >In-person</option>
                    <option value="remote" <?php if ($workplace_mode == 'remote') echo 'selected' ?>
                    >Remote</option>
                    <option value="mixed" <?php if ($workplace_mode == 'mixed') echo 'selected' ?>
                    >Mixed</option>
                </select>
            </div>

            <div class="form-group col-12">
                <label for="city">City</label>

                <div class="chips-autocomplete form-control form-control-sm" id="city" data-name="city" data-initial-value="<?= $city ?>" data-select-single data-select-match-only></div>
            </div>

            <div class="form-group col-12">
                <label for="country">Country</label>

                <div class="chips-autocomplete form-control form-control-sm" id="country" data-name="country" data-initial-value="<?= $country ?>" data-select-single data-select-match-only></div>
            </div>

            <div class="form-group col-12">
                <label for="hourly_pay">Hourly pay</label>

                <input type="number" class="form-control form-control-sm" id="hourly_pay" name="hourly_pay" step="0.01">
            </div>

            <div class="form-group col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="has_bonus" name="has_bonus" value="true">

                    <label class="form-check-label" for="has_bonus">Has bonus?</label>
                </div>
            </div>

            <div class="form-group col-12">
                <label for="schedule">Schedule</label>

                <select class="form-control form-control-sm" id="schedule" name="schedule">
                    <option value="full-time" <?php if ($schedule == 'full-time') echo 'selected' ?>
                    >Full-time</option>
                    <option value="part-time" <?php if ($schedule == 'part-time') echo 'selected' ?>
                    >Part-time</option>
                    <option value="flexible" <?php if ($schedule == 'flexible') echo 'selected' ?>
                    >Flexible</option>
                    <option value="project-based" <?php if ($schedule == 'project-based') echo 'selected' ?>
                    >Project-based</option>
                </select>
            </div>

            <div class="form-group col-12">
                <label for="start_date">Start date</label>

                <input type="date" class="form-control form-control-sm" id="start_date" name="start_date">
            </div>

            <div class="form-group col-12">
                <label for="duration">Duration in months</label>

                <input type="number" class="form-control form-control-sm" id="duration" name="duration">
            </div>

            <div class="form-group col-12">
                <label for="hours_per_week">Hours per Week</label>

                <input type="number" class="form-control form-control-sm" id="hours_per_week" name="hours_per_week">
            </div>

            <div class="form-group col-12">
                <label for="days_per_week">Days per Week</label>

                <input type="number" class="form-control form-control-sm" id="days_per_week" name="days_per_week">
            </div>

            <div class="form-group col-12 col-12">
                <input type="submit" name="submit" class="btn btn-primary mt-2" value="Create">
            </div>
        </form>
    </div>
</main>