<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <style>
        .multiselect {
            /* to look and behave like bootstrap input */
            display: block;
            cursor: text;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            appearance: none;
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            /* make it a flexbox */
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .multiselect::-ms-expand {
            background-color: transparent;
            border: 0;
        }

        .multiselect:focus-within {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .multiselect::placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .multiselect:disabled,
        .multiselect[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }

        .multiselect .chips {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .multiselect .chip {
            display: flex;
            flex: row nowrap;
            align-items: center;
            width: fit-content;
            gap: 0.2rem;
            padding: 0.2rem 0.5rem;
            margin: 0.2rem;
            border-radius: 0.5rem;
            background-color: #e9ecef;
            color: #212529;
        }

        .multiselect .chip .chip-label {
            margin-right: 0.25rem;
            white-space: nowrap;
        }

        .multiselect .chip .chip-close {
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

        .multiselect .chip .chip-close:hover {
            background-color: darkgray;
            color: white;
            cursor: pointer;
        }

        .multiselect .chip .chip-close:focus {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .multiselect .chip .chip-close:focus-visible {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .multiselect .chip .chip-close:active {
            background-color: rgb(209, 98, 98);
            color: white;
        }

        .multiselect .chip .chip-close:disabled {
            background-color: #e9ecef;
            color: #212529;
        }

        .multiselect .chip .chip-close:disabled:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .multiselect .chip .chip-close:disabled:focus {
            background-color: #e9ecef;
            color: #212529;
        }

        .multiselect input {
            border: none;
            outline: none;
            background: none;
            padding: 0;
            margin: 0;
            font-size: 1rem;
            font-family: inherit;
            color: inherit;
        }

        .multiselect input:focus {
            outline: none;
        }
    </style>
</head>

<body>

    <form class="container m-5 p-10">
        <div>
            <div class="multiselect" data-name="locations"></div>
        </div>

        <input type=text class="form-control m-2" placeholder="Search for a city or country" />
    </form>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="/assets/js/cookies.js"></script>

    <script>
        // helper function to create a menu list item
        function createMenuItem(label, count) {
            const item = document.createElement('li');
            item.classList.add('list-group-item');

            // label
            const labelSpan = document.createElement('span');
            labelSpan.innerText = label;
            item.appendChild(labelSpan);

            // counter badge
            const countSpan = document.createElement('span');
            countSpan.classList.add('badge', 'bg-primary', 'rounded-pill', 'float-end');
            countSpan.innerText = count;
            item.appendChild(countSpan);

            return item;
        }

        // helper function to create a chip
        function createChip(label) {
            const chip = document.createElement('div');
            chip.classList.add('chip');

            // label
            const labelSpan = document.createElement('span');
            labelSpan.classList.add('chip-label');
            labelSpan.innerText = label;
            chip.appendChild(labelSpan);

            // close button
            const closeIcon = document.createElement('i');
            closeIcon.classList.add('chip-close');
            closeIcon.classList.add('fa', 'fa-times');

            chip.appendChild(closeIcon);

            return chip;
        }

        // helper function to get selected options from cookies
        function getSelectedOptions(field) {
            let get = getCookie;
            if (typeof getCookie !== 'function') {
                get = function(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }
            }
            const cookie = get(field);
            return cookie ? JSON.parse(cookie) : [];
        }

        // helper function to set selected options to cookies
        function setSelectedOptions(field, options) {
            let set = setCookie;
            if (typeof setCookie !== 'function') {
                set = function(name, value) {
                    const days = 7; // expire after 7 days
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

                    const expires = `expires=${date.toUTCString()}`;
                    const path = `path=${window.location.pathname}`;
                    document.cookie = `${name}=${(value || '')}; ${expires}; ${path}; SameSite=Lax`;
                }
            }
            set(field, JSON.stringify(options));
        }

        // helper function to fetch options from the server
        async function fetchOptions(field, value) {
            // const baseUrl = window.location.pathname;
            const baseUrl = '/';
            const url = `${baseUrl}?search=live&field=${field}&value=${value}`;
            const response = await fetch(url);
            const data = await response.json() || [{
                    label: 'x',
                    count: 1
                },
                {
                    label: 'y',
                    count: 2
                },
                {
                    label: 'z',
                    count: 3
                }
            ];
            return data;
        }

        // helper function to get options after fetching and filtering
        async function getOptions(field, value) {
            // fetch options from the server
            const options = await fetchOptions(field, value);
            // get currently selected options from cookies
            const selectedOptions = getSelectedOptions(field);
            // filter out selected options
            const filteredOptions = options.filter(option => !selectedOptions.includes(option));
            return filteredOptions;
        }

        document.querySelectorAll('form')
            .forEach(form => {
                // prepare each multiselect div
                form.querySelectorAll('.multiselect')
                    .forEach(multiselect => {
                        // section: prepare the multiselect
                        // ====================================================

                        // get the name of the multiselect
                        const name = multiselect.dataset.name;

                        // create a chip container inside the multiselect
                        const chips = document.createElement('div');
                        chips.classList.add('chips');
                        multiselect.appendChild(chips);

                        // create an input without borders inside the multiselect
                        const input = document.createElement('input');
                        input.type = 'text';
                        multiselect.appendChild(input);

                        // create dropdown menu after the multiselect
                        const menu = document.createElement('ul');
                        menu.classList.add('list-group');
                        menu.classList.add('mt-0');
                        multiselect.parentNode.insertBefore(menu, multiselect.nextSibling);

                        // section: handle events to let user type in the input
                        // ====================================================

                        // handle focus and blur events on the input
                        input.addEventListener('focus', async () => {
                            if (input.value.trim().length < 1) {
                                return;
                            }
                            await openMenu();
                        });
                        input.addEventListener('blur', () => {
                            closeMenu();
                        });

                        // focus the input when the multiselect is clicked
                        multiselect.addEventListener('click', () => {
                            input.focus();
                        });

                        // section: handle events to let user get options from input
                        // ====================================================

                        // handle input events on the input
                        input.addEventListener('input', async () => {
                            const value = input.value.trim();
                            if (value.length < 1) {
                                return;
                            }
                            await openMenu();
                        });

                        // handle click events on the list
                        menu.addEventListener('click', event => {
                            const item = event.target;
                            if (!item.classList.contains('list-group-item')) {
                                return;
                            }
                            const label = item.querySelector('.chip-label').textContent;

                            selectOption(label);
                        });

                        // handle keydown events on the input
                        input.addEventListener('keydown', event => {
                            const value = input.value.trim();

                            // get the currently selected menu item and its index
                            const selectedItem = menu.querySelector('.active');
                            const selectedIndex = Array.from(menu.children)
                                .indexOf(selectedItem);

                            // handle arrow up and arrow down keys
                            if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
                                // prevent the default behavior of the arrow keys
                                event.preventDefault();

                                // remove the `active` class from the currently selected menu item
                                if (selectedItem) {
                                    selectedItem.classList.remove('active');
                                }

                                // get the index of the menu item to be selected
                                let nextIndex = selectedIndex +
                                    (event.key === 'ArrowUp' ? -1 : 1);
                                if (nextIndex < 0) {
                                    nextIndex = menu.children.length - 1;
                                } else if (nextIndex >= menu.children.length) {
                                    nextIndex = 0;
                                }

                                // get the menu item to be highlighted next
                                const nextItem = menu.children[nextIndex];

                                // add the `active` class to the menu item to be selected
                                nextItem.classList.add('active');
                            }

                            // handle enter key
                            else if (event.key === 'Enter') {
                                // prevent the default behavior of the enter key
                                event.preventDefault();

                                if (selectedItem) {
                                    const label = selectedItem
                                        .querySelector('span:first-child').textContent;
                                    selectOption(label);
                                }
                            }

                            // handle backspace key
                            else if (event.key === 'Backspace' && value.length === 0) {
                                // prevent the default behavior of the backspace key
                                event.preventDefault();
                                // get the last selected option
                                const selectedOptions = getSelectedOptions(name);
                                const lastOption = selectedOptions[selectedOptions.length - 1];
                                
                                console.log(lastOption);

                                unselectOption(lastOption);
                            }

                            // handle escape key
                            else if (event.key === 'Escape') {
                                // prevent the default behavior of the escape key
                                event.preventDefault();

                                closeMenu();
                            }
                        });

                        // section: handle events to let user remove selected options
                        // ====================================================

                        // handle click events on the chip close buttons
                        chips.addEventListener('click', e => {
                            if (e.target.classList.contains('chip-close')) {
                                // unselect option
                                const label = e.target.parentElement
                                    .querySelector('.chip-label').textContent;
                                unselectOption(label);
                            }
                        });

                        // select options from cookies when the page loads
                        document.addEventListener('DOMContentLoaded', () => {
                            onSelectionChange();
                        });

                        // helper function to select an option
                        function selectOption(optionLabel) {
                            const label = optionLabel.trim();
                            if (!label) {
                                return;
                            }

                            const selectedOptions = getSelectedOptions(name);

                            if (selectedOptions.includes(label)) {
                                return;
                            }

                            selectedOptions.push(label);

                            setSelectedOptions(name, selectedOptions);

                            onSelectionChange();
                        }

                        // helper function to unselect an label
                        function unselectOption(optionLabel) {
                            const label = optionLabel.trim();
                            if (!label) {
                                return;
                            }

                            const selectedOptions = getSelectedOptions(name);

                            // remove the option label from the list
                            selectedOptions.splice(selectedOptions.indexOf(label), 1);

                            setSelectedOptions(name, selectedOptions);

                            onSelectionChange();
                        }

                        // helper function to handle selection change
                        function onSelectionChange() {
                            const selectedOptions = getSelectedOptions(name);

                            input.value = '';
                            menu.innerHTML = '';
                            chips.innerHTML = '';

                            selectedOptions.forEach(label => {
                                const chip = createChip(label);
                                chips.appendChild(chip);
                            });

                            closeMenu();
                        }

                        // helper function to open the dropdown menu
                        async function openMenu() {
                            menu.innerHTML = '';
                            const options = await getOptions(name, input.value);
                            options.forEach(option => {
                                const item = createMenuItem(option.label || '',
                                    option.count || 0);
                                menu.appendChild(item);
                            });
                            menu.style.display = 'block';
                        }

                        // helper function to close the dropdown menu
                        function closeMenu() {
                            menu.style.display = 'none';
                        }
                    });
            });
    </script>
</body>

</html>