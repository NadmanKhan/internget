// get all forms on the page and loop through them to add event listeners
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    const chipsAutocompleteDivs = form.querySelectorAll('.chips-autocomplete');
    chipsAutocompleteDivs.forEach(chipsAutocompleteDiv => {
        const chipInput = chipsAutocompleteDiv.querySelector('.chip-input');
        const selectedOptionsText = chipsAutocompleteDiv.querySelector('.selected-options');
        const autocompleteMenu = chipsAutocompleteDiv.querySelector('.autocomplete-menu');
        const chipContainer = chipsAutocompleteDiv.querySelector('.chip-container');

        // reset chip input and close autocomplete menu
        function resetInputAndCloseMenu() {
            chipInput.value = '';
            autocompleteMenu.classList.remove('show');
            chipInput.ariaExpanded = false;
        }

        // open autocomplete menu
        function openMenu() {
            updateAutocompleteOptions();
            autocompleteMenu.classList.add('show');
            chipInput.ariaExpanded = true;
        }

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
            console.log('before push');
            console.log(selectedOptions);
            selectedOptions.push(option.trim());
            console.log('after push');
            console.log(selectedOptions);
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
            setCookie(selectedOptionsText.name, selectedOptionsText.value, 7, '/');
            updateAutocompleteOptions();
            updateChips();
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
        document.addEventListener('DOMContentLoaded', updateChips);

        // fire update chips when selected option changes (input event)
        selectedOptionsText.addEventListener('input', updateChips);

        // fire update chips when selected option changes (change event)
        selectedOptionsText.addEventListener('change', updateChips);

        // get autocomplete options
        function getAutocompleteOptions() {
            const baseUrl = window.location.href.split('?')[0];
            const params = new URLSearchParams({
                search: 'live',
                field: selectedOptionsText.name,
                value: chipInput.value
            });
            const url = baseUrl + '?' + params.toString();

            let autocompleteOptions = [];
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                autocompleteOptions = JSON.parse(this.responseText);
            };
            xhttp.open('GET', url, false);
            xhttp.send();
            return autocompleteOptions;
        }

        // create autocomplete option
        function createAutocompleteOptionElement(option) {
            const element = document.createElement('li');
            element.classList.add('dropdown-item');
            element.style.cursor = 'pointer';
            element.textContent = option;
            return element;
        }

        // filter autocomplete options
        function filterAutocompleteOptions() {
            const autocompleteOptions = getAutocompleteOptions();
            const selectedOptions = selectedOptionsText.value.split(',');
            const chipInputValue = chipInput.value;
            const filteredAutocompleteOptions
                = autocompleteOptions.filter(autocompleteOption => {
                    return !selectedOptions.includes(autocompleteOption) &&
                        autocompleteOption
                            .toLowerCase()
                            .startsWith(chipInputValue.toLowerCase());
                });
            return filteredAutocompleteOptions;
        }

        // update autocomplete options
        function updateAutocompleteOptions() {
            const filteredAutocompleteOptions = filterAutocompleteOptions();
            autocompleteMenu.innerHTML = '';
            filteredAutocompleteOptions.forEach(option => {
                const element = createAutocompleteOptionElement(option);
                autocompleteMenu.appendChild(element);
            });
        }

        // handle chip text input
        chipInput.addEventListener('input', e => {
            const chipInputValue = e.target.value;
            if (chipInputValue) {
                updateAutocompleteOptions();
                openMenu();
            }
        });

        // handle blur on chip input
        chipInput.addEventListener('blur', e => {
            resetInputAndCloseMenu();
        });

        // handle focus on chip input
        chipInput.addEventListener('focus', e => {
            const chipInputValue = e.target.value;
            if (chipInputValue.length) {
                updateAutocompleteOptions();
                openMenu();
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
        chipInput.addEventListener('keydown', e => {
            // check and add chip on enter key
            if (e.key === 'Enter') {
                e.preventDefault();
                const value = e.target.value;
                if (filterAutocompleteOptions().includes(value)) {
                    selectOption(value);
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
