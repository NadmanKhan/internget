// get all forms on the page and loop through them to add event listeners
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    const chipsAutocompleteDivs = form.querySelectorAll('.chips-autocomplete');
    chipsAutocompleteDivs.forEach(chipsAutocompleteDiv => {
        // add dropdown class
        chipsAutocompleteDiv.classList.add('dropdown');
        // create children
        {
            // selected options element
            const selectedOptionsText = document.createElement('input');
            selectedOptionsText.classList.add('selected-options');
            selectedOptionsText.setAttribute('type', 'hidden');
            selectedOptionsText.setAttribute('name', chipsAutocompleteDiv.dataset.name);
            chipsAutocompleteDiv.appendChild(selectedOptionsText);
            // chip container element
            const chipContainer = document.createElement('div');
            chipContainer.classList.add('chip-container');
            chipsAutocompleteDiv.appendChild(chipContainer);
            // chip input element
            const chipInput = document.createElement('input');
            chipInput.classList.add('chip-input');
            chipInput.classList.add('dropdown-toggle');
            chipInput.dataset.bsToggle = 'dropdown';
            chipInput.setAttribute('type', 'text');
            chipInput.setAttribute('autocomplete', 'off');
            chipInput.setAttribute('spellcheck', 'false');
            chipInput.setAttribute('autocapitalize', 'off');
            chipInput.setAttribute('autocorrect', 'off');
            chipInput.setAttribute('aria-autocomplete', 'list');
            chipInput.setAttribute('aria-haspopup', 'true');
            chipInput.setAttribute('aria-expanded', 'false');
            chipInput.setAttribute('aria-owns', 'autocomplete-menu');
            chipInput.setAttribute('aria-controls', 'autocomplete-menu');
            const placeholder = chipsAutocompleteDiv.dataset.placeholder;
            if (placeholder) {
                chipInput.setAttribute('placeholder', placeholder);
            }
            chipsAutocompleteDiv.appendChild(chipInput);
            // autocomplete menu element
            const autocompleteMenu = document.createElement('ul');
            autocompleteMenu.classList.add('autocomplete-menu');
            autocompleteMenu.classList.add('dropdown-menu');
            chipsAutocompleteDiv.appendChild(autocompleteMenu);
        }
        const selectMatchOnly = chipsAutocompleteDiv.dataset.selectMatchOnly !== undefined;
        const selectSingle = chipsAutocompleteDiv.dataset.selectSingle !== undefined;
        const initialValue = chipsAutocompleteDiv.dataset.initialValue || '';
        const required = chipsAutocompleteDiv.dataset.required !== undefined;

        const selectedOptionsText = chipsAutocompleteDiv.querySelector('input[type="hidden"]');
        selectedOptionsText.toggleAttribute('required', required);
        const chipContainer = chipsAutocompleteDiv.querySelector('.chip-container');
        const chipInput = chipsAutocompleteDiv.querySelector('input.chip-input');
        const autocompleteMenu = chipsAutocompleteDiv.querySelector('.autocomplete-menu');

        // create chip from chip label
        function createChipElement(chipLabel) {
            const element = document.createElement('div');
            element.classList.add('chip');

            const chipLabelSpan = document.createElement('span');
            chipLabelSpan.classList.add('chip-label');
            chipLabelSpan.textContent = chipLabel;

            const chipRemoveIcon = document.createElement('i');
            chipRemoveIcon.classList.add('chip-remove');
            chipRemoveIcon.classList.add('fa');
            chipRemoveIcon.classList.add('fa-times');
            chipRemoveIcon.setAttribute('type', 'i');

            element.appendChild(chipLabelSpan);
            element.appendChild(chipRemoveIcon);

            return element;
        }

        // remove chips when remove icon is clicked
        chipContainer.addEventListener('click', e => {
            if (e.target.classList.contains('chip-remove')) {
                // unselect option
                const chipLabel = e.target.parentElement.querySelector('.chip-label').textContent;
                unselectOption(chipLabel);
            }
        });

        // add to selected options
        function selectOption(option) {
            const selectedOptions = selectedOptionsText.value.split(',')
                .filter(selectedOption => selectedOption !== '');
            if (selectSingle && selectedOptions.length > 0) {
                selectedOptions[0] = option.trim();
            } else {
                selectedOptions.push(option.trim());
            }
            selectedOptions.filter(selectedOption => selectedOption !== '');
            selectedOptionsText.value = selectedOptions.join(',');
            resetInputAndCloseMenu();
            postProcessUpdateSelectedOptions();
        }

        // remove from selected options
        function unselectOption(option) {
            const selectedOptions = selectedOptionsText.value.split(',')
                .filter(selectedOption =>
                    selectedOption !== option && selectedOption !== '')
                .map(selectedOption => selectedOption.trim());
            selectedOptionsText.value = selectedOptions.join(',');
            postProcessUpdateSelectedOptions();
        }

        // post-process update of selected options
        function postProcessUpdateSelectedOptions() {
            if (typeof setCookie === 'function') {
                setCookie(
                    selectedOptionsText.name,
                    selectedOptionsText.value,
                    7,
                    window.location.pathname
                );
            }
            updateChips();
            chipInput.dispatchEvent(new Event('input'));
        }

        // update chips from selected options
        function updateChips() {
            const chipLabels = selectedOptionsText.value.split(',');
            chipContainer.innerHTML = '';
            chipLabels.forEach(chipLabel => {
                if (chipLabel) {
                    const chip = createChipElement(chipLabel.trim());
                    chipContainer.appendChild(chip);
                }
            });
            if (chipContainer.innerHTML.length > 0) {
                chipContainer.classList.add('has-chips');
            } else {
                chipContainer.classList.remove('has-chips');
            }
        }

        // update chips when document is ready
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof getCookie === 'function') {
                const cookieValue = getCookie(selectedOptionsText.name);
                if (cookieValue) {
                    selectedOptionsText.value = cookieValue;
                }
            } else if (initialValue) {
                selectedOptionsText.value = initialValue;
            }
            if (selectSingle && selectedOptionsText.value.split(',').length > 1) {
                selectedOptionsText.value = selectedOptionsText.value.split(',')[0];
            }
            updateChips();
        });

        // fire update chips when selected option changes (input event)
        selectedOptionsText.addEventListener('input', updateChips);

        // fire update chips when selected option changes (change event)
        selectedOptionsText.addEventListener('change', updateChips);

        // create autocomplete option
        function createAutocompleteOptionElement(option) {
            const element = document.createElement('li');
            element.classList.add('dropdown-item');
            element.style.cursor = 'pointer';
            element.textContent = option;
            return element;
        }

        // get autocomplete options
        async function getAutocompleteOptions() {
            try {
                const value = chipInput.value.trim();
                if (value.length === 0) {
                    return [];
                }
                // if countries field, use restcountries.com API
                if (selectedOptionsText.name === 'countries' || selectedOptionsText.name === 'countries[]' || selectedOptionsText.name === 'country') {
                    const url = `https://restcountries.com/v3.1/name/${value.trim().toLowerCase()}`;
                    const response = await fetch(url);
                    const countries = await response.json();
                    const options = countries
                        .filter(country =>
                            country !== undefined &&
                            country.name !== undefined &&
                            country.name.common !== undefined &&
                            country.name.common.toLowerCase().startsWith(value.trim().toLowerCase()))
                        .map(country => country.name.common);
                    return options;
                }
                // other fields
                else {
                    const baseUrl = window.location.pathname;
                    const params = new URLSearchParams({
                        search: 'live',
                        field: selectedOptionsText.name,
                        value: value
                    });
                    const url = baseUrl + '?' + params.toString();

                    const response = await fetch(url);
                    if (!response.ok) {
                        return [];
                    }
                    const json = await response.json();
                    console.log('json: ' + json);
                    if (!json || json.error) {
                        return [];
                    }
                    return json.options || [];
                }
            } catch (error) {
                console.error('error: ' + JSON.stringify(error));
                return [];
            }
        }

        // filter autocomplete options
        async function filterAutocompleteOptions() {
            const autocompleteOptions = await getAutocompleteOptions();
            const selectedOptions = selectedOptionsText.value.split(',');
            const chipInputValue = chipInput.value.trim();
            const filteredAutocompleteOptions
                = autocompleteOptions.filter(autocompleteOption => {
                    return !selectedOptions.includes(autocompleteOption) &&
                        autocompleteOption
                            .toLowerCase()
                            .startsWith(chipInputValue.toLowerCase());
                });
            if (!selectMatchOnly && chipInputValue.length > 0 && !filteredAutocompleteOptions.includes(chipInputValue) && !selectedOptions.includes(chipInputValue)) {
                filteredAutocompleteOptions.unshift(chipInputValue);
            }
            return filteredAutocompleteOptions;
        }

        // update autocomplete options
        async function updateAutocompleteOptions() {
            const filteredAutocompleteOptions = await filterAutocompleteOptions();
            autocompleteMenu.innerHTML = '';
            filteredAutocompleteOptions.forEach(option => {
                const element = createAutocompleteOptionElement(option);
                autocompleteMenu.appendChild(element);
            });
        }

        // reset chip input and close autocomplete menu
        function resetInputAndCloseMenu() {
            chipInput.value = '';
            autocompleteMenu.classList.remove('show');
            autocompleteMenu.innerHTML = '';
            chipInput.ariaExpanded = false;
        }

        // open autocomplete menu
        function openMenu() {
            if (autocompleteMenu.innerHTML.length) {
                autocompleteMenu.classList.add('show');
                chipInput.ariaExpanded = true;
            }
        }

        // handle chip text input
        chipInput.addEventListener('input', async e => {
            const chipInputValue = e.target.value;
            if (chipInputValue) {
                await updateAutocompleteOptions();
                openMenu();
            }
        });

        // handle blur on chip input
        chipInput.addEventListener('blur', e => {
            resetInputAndCloseMenu();
        });

        // handle focus on chip input
        chipInput.addEventListener('focus', async e => {
            if (e.target.value.trim().length) {
                await updateAutocompleteOptions();

            } else {
                resetInputAndCloseMenu();
            }
        });

        // focus chip input on click on whole chips autocomplete div
        chipsAutocompleteDiv.addEventListener('click', e => {
            chipInput.focus();
        });

        // handle mousedown on autocomplete option
        autocompleteMenu.addEventListener('mousedown', e => {
            const option = e.target.textContent;
            if (option.length) {
                selectOption(option);
            }
        });

        // handle keydown on chip input
        chipInput.addEventListener('keydown', async e => {
            // check and add chip on enter key
            if (e.key === 'Enter') {
                e.preventDefault();
                const value = e.target.value.trim();
                if (!value.length) {
                    return;
                }
                if (!selectMatchOnly) {
                    selectOption(value);
                    resetInputAndCloseMenu();
                    chipInput.focus();
                    return;
                }
                const options = await filterAutocompleteOptions();
                const matching = options.filter(option => option.toLowerCase() === value.toLowerCase());
                if (matching.length) {
                    selectOption(matching[0]);
                    resetInputAndCloseMenu();
                    chipInput.focus();
                }
            }
            // remove last chip on backspace key
            else if (e.key === 'Backspace') {
                const value = e.target.value;
                if (!value.length && selectedOptionsText.value.length) {
                    unselectOption(chipContainer.lastElementChild.textContent);
                    resetInputAndCloseMenu();
                    chipInput.focus();
                }
            }
            // handle up and down arrow keys
            else if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                e.preventDefault();
                const options = autocompleteMenu.querySelectorAll('.dropdown-item');
                if (options.length) {
                    const activeOption = autocompleteMenu.querySelector('.active');
                    if (activeOption) {
                        activeOption.classList.remove('active');
                        if (e.key === 'ArrowUp') {
                            const prevOption = activeOption.previousElementSibling;
                            if (prevOption) {
                                prevOption.classList.add('active');
                            } else {
                                options[options.length - 1].classList.add('active');
                            }
                        } else {
                            const nextOption = activeOption.nextElementSibling;
                            if (nextOption) {
                                nextOption.classList.add('active');
                            } else {
                                options[0].classList.add('active');
                            }
                        }
                    } else {
                        options[0].classList.add('active');
                    }
                }
            }
        });


        // handle keydown on chips autocomplete div
        chipsAutocompleteDiv.addEventListener('keydown', e => {
            // check and add chip on enter key
            if (e.key === 'Enter') {
                e.preventDefault();
                const activeOption = autocompleteMenu.querySelector('.active');
                if (activeOption) {
                    const option = activeOption.textContent;
                    if (option.length) {
                        selectOption(option);
                    }
                }
            }
        });
    });
});
