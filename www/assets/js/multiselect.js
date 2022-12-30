"use strict";

function renderOptionLabel(option) {
  const { text, count } = option.label;
  return `
    <span class="option-label-text">
      ${text}
    </span>
    <span class="option-label-count badge bg-primary rounded-pill float-end">
      ${count}
    </span>
  `;
}

// helper function to fetch options from the server
async function fetchOptions(name, value) {
  const baseUrl = '/';
  const url = `${baseUrl}?search=live&name=${encodeURIComponent(name)}&value=${encodeURIComponent(value)}`;
  const response = await fetch(url);
  const data = await response.json();
  return data;
}

document.querySelectorAll('form')
  .forEach(form => {
    // **************************************************************************
    // section: add selected values in hidden input to form data before submission
    // ==========================================================================

    form.addEventListener('submit', event => {
      event.preventDefault();
      form.querySelectorAll('.multiselect').forEach(multiselect => {
        const selectedOptions = Array.from(multiselect.querySelectorAll('.chip') || [])
          .map(chip => JSON.parse(chip.dataset.string));
        selectedOptions.forEach(option => {
          // append a hidden input to the form
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = multiselect.dataset.name;
          if (multiselect.dataset.maxSelect != 1) {
            hiddenInput.name += '[]';
          }
          console.log('hiddenInput.name', hiddenInput.name);
          hiddenInput.value = option.value;
          form.appendChild(hiddenInput);
        });
        // if (!multiselect.hasAttribute('data-use-cookies')) {
        //   // doesn't use cookies, so delete from local storage
        //   localStorage.removeItem(multiselect.dataset.name);
        // }
      });
      const formData = new FormData(form);
      console.log('formData', formData);
      form.submit();
    });

    // prepare each multiselect div
    form.querySelectorAll('.multiselect')
      .forEach(multiselect => {
        // **************************************************************************
        // section: prepare and initialize the multiselect
        // ==========================================================================

        // get the name of the multiselect for form submission
        const name = multiselect.dataset.name;
        const maxSelect = multiselect.dataset.maxSelect
          ? (
            parseInt(multiselect.dataset.maxSelect) < 0
              ? 1
              : parseInt(multiselect.dataset.maxSelect)
          )
          : -1;
        const onMaxExceed = multiselect.onMaxExceed;
        const useCookies = multiselect.hasAttribute('data-use-cookies');
        const mustMatchOptions = multiselect.hasAttribute('data-must-match-options');

        multiselect.classList.add('form-control');

        // create a chip container inside the multiselect
        const chips = document.createElement('div');
        chips.classList.add('chips');
        multiselect.appendChild(chips);

        // create an input without borders inside the multiselect
        const input = document.createElement('input');
        input.type = 'text';
        input.style.width = '100%';
        multiselect.appendChild(input);

        // create dropdown menu after the multiselect
        const menu = document.createElement('ul');
        menu.classList.add('list-group');
        menu.classList.add('mt-0');
        multiselect.parentNode.insertBefore(menu, multiselect.nextSibling);

        // select options from cookies when the page loads
        document.addEventListener('DOMContentLoaded', () => {
          const selectedOptions = getSelectedOptions();
          chips.innerHTML = '';
          selectedOptions.forEach(option => {
            const chip = createChip(option);
            chips.appendChild(chip);
          });
        });

        // **************************************************************************
        // section: handle events to let user type in the input and get and select options
        // ==========================================================================

        // focus the input when the multiselect is clicked
        multiselect.addEventListener('click', () => {
          input.focus();
        });

        // close the menu when user clicks outside the multiselect
        input.addEventListener('blur', () => {
          resetInputAndCloseMenu();
        });

        // open menu when user types in non-whitespace characters
        input.addEventListener('input', async () => {
          if (!input.value.trim().length) {
            return;
          }
          await prepareAndOpenMenu();
        });

        // select an option from the menu when user clicks on it
        menu.addEventListener('mousedown', event => {
          const item = event.target;
          if (!item.classList.contains('menu-item')) {
            return;
          }
          toggleSelectOption(JSON.parse(item.dataset.string), true);
        });

        // handle keydown events on the input
        input.addEventListener('keydown', event => {
          // get the currently highlighted menu item and its index
          const activeItem = menu.querySelector('.active');
          const activeIndex = Array.from(menu.children)
            .indexOf(activeItem);

          // navigate menu items on arrow up and arrow down keys
          if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
            event.preventDefault();

            // remove the "active" class from the currently highlighted menu item
            if (activeItem) {
              activeItem.classList.remove('active');
            }

            // get the menu item to be highlighted next
            let nextIndex = activeIndex +
              (event.key === 'ArrowUp' ? -1 : 1);
            if (nextIndex < 0) {
              nextIndex = menu.children.length - 1;
            } else if (nextIndex >= menu.children.length) {
              nextIndex = 0;
            }
            const nextItem = menu.children[nextIndex];

            // add the "active" class to the menu item to be highlighted
            nextItem.classList.add('active');
          }

          // select an option from the menu when user presses enter
          else if (event.key === 'Enter') {
            event.preventDefault();

            if (activeItem) {
              toggleSelectOption(JSON.parse(activeItem.dataset.string), true);
            }
          }

          // remove last selected option when user presses backspace and input is empty
          else if (event.key === 'Backspace') {
            if (!input.value.trim().length) {
              const selectedOptions = getSelectedOptions();
              if (selectedOptions.length) {
                // unselect the last selected option
                const lastOption = selectedOptions[selectedOptions.length - 1];
                toggleSelectOption(lastOption, false);
              }
            }
          }

          // close the menu on escape key
          else if (event.key === 'Escape') {
            event.preventDefault();
            resetInputAndCloseMenu();
          }
        });

        // **************************************************************************
        // section: handle events to let user remove selected options
        // ==========================================================================

        // handle click events on the chip close buttons
        chips.addEventListener('click', e => {
          if (event.target.classList.contains('chip-close')) {
            // unselect option
            const option = JSON.parse(event.target.parentNode.dataset.string);
            toggleSelectOption(option, false);
          }
        });

        // **************************************************************************
        // section: add button to select current location if the name is "locations"
        // ==========================================================================

        if (name === 'locations' || name === 'location') {
          // add button to add current location using geolocation

          const button = document.createElement('button');
          button.classList.add('btn', 'btn-secondary', 'btn-sm');
          button.textContent = 'Add your current location';

          const spinner = document.createElement('i');
          spinner.classList.add('fa', 'fa-spinner', 'fa-spin', 'd-none');
          spinner.classList.add('mx-2');
          button.appendChild(spinner);

          // add the created button after multiselect
          multiselect.parentNode.insertBefore(button, multiselect.nextSibling);

          button.addEventListener('click', async (event) => {
            event.preventDefault();
            if (!navigator || !navigator.geolocation) {
              alert('Geolocation is not supported by your browser');
              return;
            }

            navigator.geolocation.getCurrentPosition(async (position) => {
              spinner.classList.remove('d-none');
              const { latitude, longitude } = position.coords;
              const url =
                `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`;
              const response = await fetch(url);
              const data = await response.json();
              const city = data.city;
              const country = data.countryName;
              // get matching location from database; if not found, alert user
              const location = await matchFromDatabase(city, country);
              console.log(location);
              spinner.classList.add('d-none');
              if (!location) {
                alert('Your current location is not in our database');
                return;
              }
              // location exists, so select it
              toggleSelectOption(location, true);
            },
              (error) => {
                console.log(error);
              }
            );
          });

          async function matchFromDatabase(city, country) {
            console.log(city);
            console.log(country);
            const data = [
              ...(await getMenuOptions(city)),
              ...(await getMenuOptions(country)),
            ];
            return data.find(
              (option) =>
                option.label.text.toLowerCase().includes(city.toLowerCase()) ||
                option.label.text.toLowerCase().includes(country.toLowerCase())
            );
          }
        }

        // **************************************************************************
        // section: helper functions
        // ==========================================================================

        // helper function to select or unselect an option
        function toggleSelectOption(option, select = true) {
          // get the selected options
          let selectedOptions = getSelectedOptions();

          if (select) {
            // select the option
            if (selectedOptions.every(o => o.value !== option.value)) {
              if (maxSelect >= 0 && selectedOptions.length >= maxSelect) {
                if (onMaxExceed === 'replace') {
                  selectedOptions.shift();
                  selectedOptions.push(option);
                } else {
                  alert('You can only select ' + maxSelect + ' options.');
                }
              } else {
                selectedOptions.push(option);
              }
            }
          } else {
            // unselect the option
            selectedOptions = selectedOptions.filter(o => o.value !== option.value);
          }

          // update the selected options
          setSelectedOptions(selectedOptions);

          // post-process the selection change
          // ------------------------------------

          input.value = '';
          chips.innerHTML = '';
          selectedOptions.forEach(option => {
            const chip = createChip(option);
            chips.appendChild(chip);
          });

          resetInputAndCloseMenu();
        }


        // helper function to populate dropdown menu with options and open it
        async function prepareAndOpenMenu() {
          const options = await getMenuOptions(input.value.trim());
          menu.innerHTML = '';
          options.forEach(option => {
            const item = createMenuItem(option);
            menu.appendChild(item);
          });
          menu.style.display = 'block';
        }

        // helper function to clear input and close menu
        function resetInputAndCloseMenu() {
          input.value = '';
          menu.style.display = 'none';
        }

        // helper function to create a menu list item
        function createMenuItem(option) {
          const item = document.createElement('li');
          item.dataset.string = JSON.stringify(option);
          item.classList.add('list-group-item');
          item.classList.add('menu-item');
          item.style.cursor = 'pointer';
          item.innerHTML = renderOptionLabel(option);
          return item;
        }

        // helper function to create a chip for a selected option
        function createChip(option) {
          const chip = document.createElement('div');
          chip.classList.add('chip');
          chip.dataset.string = JSON.stringify(option);

          // label
          const labelSpan = document.createElement('span');
          labelSpan.classList.add('chip-label');
          labelSpan.innerText = option.label.text;
          chip.appendChild(labelSpan);

          // close button
          const closeIcon = document.createElement('i');
          closeIcon.classList.add('chip-close');
          closeIcon.classList.add('fa', 'fa-times');
          chip.appendChild(closeIcon);

          return chip;
        }

        if (typeof getCookie !== 'function') {
          // helper function to get a cookie
          var getCookie = function (name) {
            for (let cookie of document.cookie.split(';')) {
              const [cookieName, cookieValue] = cookie.split('=');
              if (cookieName.trim() === name) {
                return cookieValue;
              }
            }
            return null;
          };
        }

        if (typeof setCookie !== 'function') {
          // helper function to set a cookie
          var setCookie = function (name, value) {
            const days = 7; // expire after 7 days
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            const path = `path=${window.location.pathname}`;
            document.cookie = `${name}=${(value || '')}; ${expires}; ${path}; SameSite=Lax`;
          };
        }

        // helper function to get selected options from cookies or local storage
        function getSelectedOptions() {
          return useCookies
            ? [...(JSON.parse(getCookie(name) || '[]'))]
            : [...(JSON.parse(localStorage.getItem(name) || '[]'))];
        }

        // helper function to set selected options to cookies or local storage
        function setSelectedOptions(options) {
          if (useCookies) {
            setCookie(name, JSON.stringify(options));
          } else {
            localStorage.setItem(name, JSON.stringify(options));
          }
        }

        async function getMenuOptions(value) {
          // fetch options from the server
          const options = await fetchOptions(name, value);
          // get currently selected options from cookies
          const selectedOptions = getSelectedOptions();
          // filter out selected options
          let filteredOptions = [];
          if (!mustMatchOptions && options.every(o => o.value !== value)) {
            filteredOptions.push({
              value: value,
              label: {
                text: value,
                count: 'new',
              },
            });
          }
          filteredOptions = filteredOptions.concat(
            options.filter(option =>
              selectedOptions.every(o => o.value !== option.value)
            )
          );
          return filteredOptions;
        }

      });

  });