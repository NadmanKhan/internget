// set/update cookie
function setCookie(name, value, days = 7, path = '/') {
  let expires = '';
  if (days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = '; expires=' + date.toUTCString();
  }
  document.cookie = `${name}=${value || ''}${expires}; path=${path}; SameSite=Lax`;
}

// get cookie
function getCookie(name) {
  for (let cookie of document.cookie.split(';')) {
    const [cookieName, cookieValue] = cookie.split('=');
    if (cookieName.trim() === name) {
      return cookieValue;
    }
  }
  return null;
}

// delete cookie
function deleteCookie(name) {
  document.cookie = name + '=; max-age=-99999999;';
}
