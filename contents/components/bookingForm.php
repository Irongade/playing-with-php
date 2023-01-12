<!-- booking form used in index page, this does not actually do anything. -->
<div class="banner-form">
    <form action="#">
        <div class="form-header">
            <h4 class="banner__heading heading-4">
                What are you waiting for?
            </h4>
        </div>

        <div class="input-container">
            <input class="input" type="text" name="full-name" id="full-name" placeholder="Full Name" />
            <label class="label_floating" for="full-name">Full Name</label>
        </div>

        <div class="input-container">
            <input class="input" type="email" name="email" id="email" placeholder="Email" />
            <label class="label_floating" for="email">Email</label>
        </div>

        <div class="input-container">
            <div class="input">
                <img src="../assets/svgs/Date.svg" alt="Date Logo" />
                <label class="visually-hidden" for="departure-date">Depature Date</label>
                <input class="input-date" type="text" name="departure-date" id="departure-date" placeholder="Depature Date" />
            </div>
        </div>

        <div class="input-container">
            <div class="input">
                <img src="../assets/svgs/Date.svg" alt="Date Logo" />
                <label class="visually-hidden" for="arrival-date">Arrival Date</label>
                <input class="input-date" type="text" name="arrival-date" id="arrival-date" placeholder="Arrival Date" />
            </div>
        </div>

        <div role="radiogroup" class="checkbox-section">
            <div class="checkbox-container">
                <label for="one-off">One-off
                    <input class="input-checkbox label_floating" type="radio" name="input-radio" id="one-off" checked />
                    <span tabindex="0" role="radio" aria-checked="true" class="mark-indicator" aria-label="one-off-radio-option"></span>
                </label>
            </div>

            <div class="checkbox-container">
                <label for="round-trip">Round-trip
                    <input class="input-checkbox visually-hidden" type="radio" name="input-radio" id="round-trip" />
                    <span tabindex="0" role="radio" aria-checked="false" class="mark-indicator" aria-label="round-trip-radio-input"></span>
                </label>
            </div>
        </div>

        <div class="input-container">
            <input class="input" type="text" name="people-count" id="people-count" placeholder="How many people?" />
            <label class="label_floating" for="people-count">Number of People</label>
        </div>

        <div class="btn-container max-width">
            <button class="btn btn-primary center-btn-text">
                <span> Start Now</span>
                <img class="btn-arrow" src="../assets/svgs/Arrow-White.svg" alt="Button arrow" />
            </button>
        </div>
    </form>
</div>