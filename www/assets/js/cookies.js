// set/update cookie
function setCookie(name, value, options = {}) {
  let expires = '';
  if (options.days) {
    const date = new Date();
    date.setTime(date.getTime() + (options.days * 24 * 60 * 60 * 1000));
    expires = '; expires=' + date.toUTCString();
  }
  const path = options.path || '/';
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
