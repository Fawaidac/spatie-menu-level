<header class="head">
    <div class="head__lead">
        <div class="head__text">
            <p class="head__eyebrow" style="">Northside Family Clinic</p>
            <h1 class="head__title" tabindex="-1" aria-label="Patients" data-split="Patients">
                <span class="word" aria-hidden="true"
                    ><span class="ch" style="">P</span><span class="ch" style="">a</span
                    ><span class="ch" style="">t</span><span class="ch" style="">i</span
                    ><span class="ch" style="">e</span><span class="ch" style="">n</span
                    ><span class="ch" style="">t</span><span class="ch" style="">s</span></span
                >
            </h1>
        </div>
    </div>
    <div class="head__actions">
        <button type="button" class="btn btn--ghost" data-export="" style="">
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 4v11.5M7 10.5l5 5 5-5M5 20h14"></path></svg
            >Export CSV</button
        ><button type="button" class="btn btn--primary magnetic" data-new="" style="">
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <circle cx="10" cy="8.5" r="3.8"></circle>
                <path d="M3 20c.8-3.8 3.4-6 7-6 1.7 0 3.2.5 4.3 1.4M18 13v6M15 16h6"></path>
            </svg
            >New patient
        </button>
    </div>
    <dl class="head__stats">
        <div class="stat" data-stat="total" style="">
            <dt class="stat__label">
                <span class="stat__ico"
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="9" cy="8.5" r="3.5"></circle>
                        <path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"></path>
                        <path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"></path>
                    </svg>></span
                >Patients
            </dt>
            <dd class="stat__value"><b data-count="900" data-fmt="int">900</b></dd>
        </div>
        <div class="stat" data-stat="fresh" style="">
            <dt class="stat__label">
                <span class="stat__ico"
                    ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="10" cy="8.5" r="3.8"></circle>
                        <path d="M3 20c.8-3.8 3.4-6 7-6 1.7 0 3.2.5 4.3 1.4M18 13v6M15 16h6"></path>
                    </svg></span
                >New this month
            </dt>
            <dd class="stat__value">
                <b data-count="23" data-fmt="int">23</b><span class="badge badge--plain">Since the 1st</span>
            </dd>
        </div>
        <div class="stat" data-stat="optin" style="">
            <dt class="stat__label">
                <span class="stat__ico"
                    ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"></path>
                        <path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"></path>
                    </svg></span
                >WhatsApp opt-in rate
            </dt>
            <dd class="stat__value"><b data-count="0.8433333333333334" data-fmt="pct">84%</b></dd>
        </div>
        <div class="stat" data-stat="recalls" style="">
            <dt class="stat__label">
                <span class="stat__ico"
                    ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M19.5 12a7.5 7.5 0 1 1-2.2-5.3"></path>
                        <path d="M19.5 4.5v4h-4"></path>
                    </svg></span
                >Recalls due
            </dt>
            <dd class="stat__value">
                <b data-count="70" data-fmt="int">70</b><span class="badge badge--warn">Next 14 days</span>
            </dd>
        </div>
    </dl>
</header>
<div class="toolbar pt-tools">
    <label class="search pt-search" style=""
        ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="6.5"></circle>
            <path d="m16 16 4 4"></path>
        </svg
        ><span class="sr">Search patients</span
        ><input
            type="search"
            placeholder="Search name, phone or email"
            value=""
            data-q=""
            autocomplete="off"
            spellcheck="false"
    /></label>
    <div class="seg" role="group" aria-label="WhatsApp consent" style="">
        <span
            class="seg__pill"
            aria-hidden="true"
            style="opacity: 1; clip-path: inset(3px 544px 3px 3px round 999px)"
        ></span
        ><button type="button" class="seg__btn" data-value="all" aria-pressed="true">All</button
        ><button type="button" class="seg__btn" data-value="opted-in" aria-pressed="false">Opted in</button
        ><button type="button" class="seg__btn" data-value="pending" aria-pressed="false">Pending</button
        ><button type="button" class="seg__btn" data-value="opted-out" aria-pressed="false">Opted out</button>
    </div>
    <span class="toolbar__spacer" style=""></span>
    <button
        type="button"
        class="btn btn--ghost btn--sm pt-menu"
        data-doc=""
        aria-haspopup="menu"
        aria-expanded="false"
        style=""
    >
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M6 3.5v5a4 4 0 0 0 8 0v-5"></path>
            <path d="M10 12.5v2a5 5 0 0 0 10 0v-1.5"></path>
            <circle cx="20" cy="11" r="2"></circle>
            <path d="M5 3.5h2M13 3.5h2"></path>
        </svg>
        ><span data-doc-label="">All clinicians</span
        ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="m6 9.5 6 6 6-6"></path></svg>
    </button>
    <button
        type="button"
        class="btn btn--ghost btn--sm pt-menu"
        data-sort=""
        aria-haspopup="menu"
        aria-expanded="false"
        style=""
    >
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 6h16M7 12h10M10 18h4"></path></svg
        ><span data-sort-label="">Name</span
        ><svg class="ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="m6 9.5 6 6 6-6"></path></svg>
    </button>
</div>
<div class="pt-chips hfade" role="group" aria-label="Filter by tag" data-chips="">
    <button type="button" class="chip" data-tag="all" aria-pressed="true" style="">All<b>900</b></button
    ><button type="button" class="chip pt-chip--new" data-tag="new" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>New patient<b>23</b></button
    ><button type="button" class="chip pt-chip--chronic" data-tag="chronic" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Chronic care<b>129</b></button
    ><button type="button" class="chip pt-chip--pregnancy" data-tag="pregnancy" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Pregnancy<b>6</b></button
    ><button type="button" class="chip pt-chip--pediatric" data-tag="pediatric" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Pediatric<b>175</b></button
    ><button type="button" class="chip pt-chip--senior" data-tag="senior" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Senior<b>152</b></button
    ><button type="button" class="chip pt-chip--vip" data-tag="vip" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Priority<b>3</b></button
    ><button type="button" class="chip pt-chip--follow-up" data-tag="follow-up" aria-pressed="false" style="">
        <i class="pt-chip__dot" aria-hidden="true"></i>Needs follow-up<b>45</b>
    </button>
</div>
<p class="sr" role="status" data-count-sr="">900 patients</p>
