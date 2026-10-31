<dialog class="finder" id="finder" aria-label="Search Tend">
    <div class="finder__bar">
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="6.5"></circle>
            <path d="m16 16 4 4"></path>
        </svg>
        <input
            id="finder-q"
            type="text"
            role="combobox"
            aria-expanded="true"
            aria-controls="finder-list"
            aria-autocomplete="list"
            placeholder="Search patients, phone numbers, conversations…"
            autocomplete="off"
            spellcheck="false"
        />
        <kbd>esc</kbd>
    </div>
    <ul class="finder__list" id="finder-list" role="listbox" aria-label="Results"></ul>
</dialog>
