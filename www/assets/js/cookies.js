// set/update cookie
function setCookie(name, value, days = 7, path = '/') {
  let expires = '';
  if (days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = '; expires=' + date.toUTCString();
  }
  document.cookie = `${name}=${value || ''}${expires}; path=${path}`;
}

// get cookie
function getCookie(name) {
  document.cookie.split(';').forEach(cookie => {
    const [cookieName, cookieValue] = cookie.split('=').map(c => c.trim());
    if (cookieName === name) {
      return cookieValue;
    }
  });
  return '';
}

// delete cookie
function deleteCookie(name) {
  document.cookie = name + '=; max-age=-99999999;';
}
