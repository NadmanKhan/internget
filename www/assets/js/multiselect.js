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
    get = function (name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    };
  }
  const cookie = get(field);
  return cookie ? JSON.parse(cookie) : [];
}

// helper function to set selected options to cookies
function setSelectedOptions(field, options) {
  let set = setCookie;
  if (typeof setCookie !== 'function') {
    set = function (name, value) {
      const days = 7; // expire after 7 days
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

      const expires = `expires=${date.toUTCString()}`;
      const path = `path=${window.location.pathname}`;
      document.cookie = `${name}=${(value || '')}; ${expires}; ${path}; SameSite=Lax`;
    };
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