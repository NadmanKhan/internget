<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Cookies helper -->
    <script src="/assets/js/cookies.js"></script>

    <!-- Custom CSS -->
    <style>
        .chips-autocomplete {
            display: flex;
            flex: row wrap;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: center;
            padding: 0;
            height: auto;
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            cursor: text;
        }

        .chips-autocomplete:focus-within {
            color: #212529;
            background-color: white;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .chips-autocomplete .chip-container {
            display: flex;
            flex: row wrap;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.2rem;
            padding-left: 0.5rem;
        }

        .chips-autocomplete .chip-input,
        .chips-autocomplete .chip-input:focus {
            padding: 0;
            border: none;
            margin: 0;
            outline: none;
        }

        .chips-autocomplete .chip-container.has-chips {
            margin-right: 0.5rem;
        }

        .chips-autocomplete .chip-input::placeholder {
            color: #6c757d;
        }

        .chips-autocomplete .chip {
            display: flex;
            flex: row nowrap;
            align-items: center;
            width: fit-content;
            gap: 0.2rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.5rem;
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .chip .chip-label {
            white-space: nowrap;
        }

        .chips-autocomplete .chip .chip-remove {
            display: flex;
            flex: row nowrap;
            align-items: center;
            justify-content: center;
            gap: 0.2rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.5rem;
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .chip .chip-remove:hover {
            background-color: darkgray;
            color: white;
            cursor: pointer;
        }

        .chips-autocomplete .chip .chip-remove:focus {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .chips-autocomplete .chip .chip-remove:focus-visible {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .chips-autocomplete .chip .chip-remove:active {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .chips-autocomplete .chip .chip-remove:disabled {
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .chip .chip-remove:disabled:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .chip .chip-remove:disabled:focus {
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .chip .chip-remove:disabled:focus-visible {
            background-color: #e9ecef;
            color: #212529;
        }

        .chips-autocomplete .selected-options {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <form action="">
            <div class="chips-autocomplete form-control form-control-sm dropdown">
                <div class="chip-container">
                </div>

                <input type="text" autocomplete="off" class="chip-input dropdown-toggle" data-bs-toggle="dropdown">

                <input type="text" class="selected-options" name="keywords" value="Chip 1, Chip 2">

                <ul class="autocomplete-menu dropdown-menu">
                </ul>
            </div>

            <input type="submit" value="Submit">
        </form>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>

    <!-- Custom JavaScript -->

    <script>
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
                    const selectedOptions = selectedOptionsText.value.split(',');
                    selectedOptions.push(option.trim());
                    selectedOptionsText.value = selectedOptions.join(',');
                    resetInputAndCloseMenu();
                    postProcessUpdateSelectedOptions();
                }

                // remove from selected options
                function unselectOption(option) {
                    const selectedOptions = selectedOptionsText.value.split(',')
                        .filter(selectedOption => selectedOption !== option)
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
                    // const baseUrl = window.location.href.split('?')[0];
                    const baseUrl = '/';
                    console.log(baseUrl);
                    const params = new URLSearchParams({
                        search: 'live',
                        name: selectedOptionsText.name,
                        value: chipInput.value
                    });
                    const url = baseUrl + '?' + params.toString();

                    let autocompleteOptions = [];
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function () {
                        console.log(this.responseText);
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
                    console.log('new: ' + option);
                    return element;
                }

                // filter autocomplete options
                function filterAutocompleteOptions() {
                    const autocompleteOptions = getAutocompleteOptions();
                    console.log('before');
                    console.log(autocompleteOptions);
                    const selectedOptions = selectedOptionsText.value.split(',');
                    const chipInputValue = chipInput.value;
                    const filteredAutocompleteOptions
                        = autocompleteOptions.filter(autocompleteOption => {
                            return !selectedOptions.includes(autocompleteOption) &&
                                autocompleteOption
                                    .toLowerCase()
                                    .startsWith(chipInputValue.toLowerCase());
                        });
                    console.log('after');
                    console.log(filteredAutocompleteOptions);
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
                    console.log('html:===>' + autocompleteMenu.innerHTML);
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
    </script>
</body>

</html>