// This function converts the string to lowercase, then perform the conversion
function toLowerCaseNonAccentVietnamese(str) {
  str = str.toLowerCase()
  //     We can also use this instead of from line 11 to line 17
  //     str = str.replace(/\u00E0|\u00E1|\u1EA1|\u1EA3|\u00E3|\u00E2|\u1EA7|\u1EA5|\u1EAD|\u1EA9|\u1EAB|\u0103|\u1EB1|\u1EAF|\u1EB7|\u1EB3|\u1EB5/g, "a");
  //     str = str.replace(/\u00E8|\u00E9|\u1EB9|\u1EBB|\u1EBD|\u00EA|\u1EC1|\u1EBF|\u1EC7|\u1EC3|\u1EC5/g, "e");
  //     str = str.replace(/\u00EC|\u00ED|\u1ECB|\u1EC9|\u0129/g, "i");
  //     str = str.replace(/\u00F2|\u00F3|\u1ECD|\u1ECF|\u00F5|\u00F4|\u1ED3|\u1ED1|\u1ED9|\u1ED5|\u1ED7|\u01A1|\u1EDD|\u1EDB|\u1EE3|\u1EDF|\u1EE1/g, "o");
  //     str = str.replace(/\u00F9|\u00FA|\u1EE5|\u1EE7|\u0169|\u01B0|\u1EEB|\u1EE9|\u1EF1|\u1EED|\u1EEF/g, "u");
  //     str = str.replace(/\u1EF3|\u00FD|\u1EF5|\u1EF7|\u1EF9/g, "y");
  //     str = str.replace(/\u0111/g, "d");
  str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
  str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
  str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i')
  str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
  str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
  str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
  str = str.replace(/đ/g, 'd')
  // Some system encode vietnamese combining accent as individual utf-8 characters
  str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, '') // Huyền sắc hỏi ngã nặng
  str = str.replace(/\u02C6|\u0306|\u031B/g, '') // Â, Ê, Ă, Ơ, Ư
  return str
}

// This function keeps the casing unchanged for str, then perform the conversion
function toNonAccentVietnamese(str) {
  str = str.replace(/A|Á|À|Ã|Ạ|Â|Ấ|Ầ|Ẫ|Ậ|Ă|Ắ|Ằ|Ẵ|Ặ/g, 'A')
  str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
  str = str.replace(/E|É|È|Ẽ|Ẹ|Ê|Ế|Ề|Ễ|Ệ/, 'E')
  str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
  str = str.replace(/I|Í|Ì|Ĩ|Ị/g, 'I')
  str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i')
  str = str.replace(/O|Ó|Ò|Õ|Ọ|Ô|Ố|Ồ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ỡ|Ợ/g, 'O')
  str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
  str = str.replace(/U|Ú|Ù|Ũ|Ụ|Ư|Ứ|Ừ|Ữ|Ự/g, 'U')
  str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
  str = str.replace(/Y|Ý|Ỳ|Ỹ|Ỵ/g, 'Y')
  str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
  str = str.replace(/Đ/g, 'D')
  str = str.replace(/đ/g, 'd')
  // Some system encode vietnamese combining accent as individual utf-8 characters
  str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, '') // Huyền sắc hỏi ngã nặng
  str = str.replace(/\u02C6|\u0306|\u031B/g, '') // Â, Ê, Ă, Ơ, Ư
  return str
}

/**
 *
 */
function setCookie(cname, cvalue, exdays) {
  const d = new Date()
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000)
  let expires = 'expires=' + d.toUTCString()
  document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/'
}

/**
 *
 */
function getCookie(cname) {
  let name = cname + '='
  let ca = document.cookie.split(';')
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1)
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length)
    }
  }
  return ''
}

/**
 * Generates a random integer between the specified minimum and maximum values (inclusive).
 *
 * @param {number} min - The minimum value for the random integer.
 * @param {number} max - The maximum value for the random integer.
 * @return {number} The randomly generated integer.
 */
function randomInt(min, max) {
  min = Math.ceil(min)
  max = Math.floor(max)
  return Math.floor(Math.random() * (max - min + 1) + min)
}

// Check is In clien view
function isInViewport(elemt) {
  const rect = elemt.getBoundingClientRect()

  const viewportHeight =
    window.innerHeight || document.documentElement.clientHeight

  if (
    rect.top >= 0 &&
    rect.bottom >= 0 &&
    rect.top + viewportHeight * 0.1 <= viewportHeight
  ) {
    return true
  }

  if (
    rect.top <= 0 &&
    rect.bottom >= 0 &&
    rect.bottom >= viewportHeight * 0.5
  ) {
    return true
  }

  // if (rect.top >= 0 && rect.top + viewportHeight * 0.1 <= viewportHeight) {
  //   return true;
  // }

  // if (rect.top >= 0 && rect.bottom - rect.height / 2 <= viewportHeight) {
  //   return true;
  // }

  return false
}

//
class ValidForm {
  static isFilled(value) {
    if (value === undefined || value === null || value === '') {
      return false
    }
    return true
  }

  static isEmail(value) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    return re.test(String(value).toLowerCase())
  }

  static isPhone(value) {
    const re = /^0[0-9]{9,10}$/
    return re.test(String(value).toLowerCase())
  }

  static isNumber(value) {
    const re = /^[0-9]+$/
    return re.test(String(value).toLowerCase())
  }

  static isStrongPassword(value) {
    const re = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/
    return re.test(String(value).toLowerCase())
  }
}

/**
 * Removes key-value pairs from an object if the value is empty.
 *
 * @param {Object} object The object to remove empty key-value pairs from.
 * @returns {Object} The new object with only the non-empty key-value pairs.
 */
function removeObjectKeyEmpty(object) {
  var newObject = {}

  for (const key in object) {
    if (Object.hasOwnProperty.call(object, key)) {
      if (object[key]) {
        newObject[key] = object[key]
      }
    }
  }
  return newObject
}

/**
 * Checks if an object is empty or not.
 *
 * @param {Object} object The object to check.
 * @returns {boolean} True if the object is empty, false otherwise.
 */
function isObjectEmty(object) {
  return Object.keys(object).length === 0
}

/**
 * Returns a promise that resolves after the specified delay in milliseconds.
 *
 * @param {number} delayInms The delay in milliseconds.
 * @returns {Promise} A promise that resolves after the specified delay.
 */
//
const delay = (delayInms) => {
  return new Promise((resolve) => setTimeout(resolve, delayInms))
}

//
const parseTimeFromToday = (time, ifFail) => {
  const today = new Date()
  const diff = today - time

  const month = Math.floor(diff / (1000 * 60 * 60 * 24 * 30))
  const days = Math.floor(diff / (1000 * 60 * 60 * 24))
  const hours = Math.floor(diff / (1000 * 60 * 60))
  const minutes = Math.floor(diff / (1000 * 60))

  if (month > 0) {
    return `${month} tháng trước`
  }

  if (days > 0) {
    return `${days} ngày trước`
  }

  if (hours > 0) {
    return `${hours} giờ trước`
  }

  if (minutes > 0) {
    return `${minutes} phút trước`
  }

  return ifFail
}

/**
 * Make random string, id
 */

function makeid(length = 10) {
  let result = ''
  const characters =
    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
  const charactersLength = characters.length
  let counter = 0
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength))
    counter += 1
  }
  return result
}

const ptHandleCloseBoxOptions = (
  event,
  classWrap,
  fnRemove,
  classRemove = 'active',
) => {
  var wrapEl = event.target.closest(`.${classWrap}`)

  if (event.target.classList.contains(classWrap) || wrapEl) {
    return
  }

  document
    .querySelectorAll(`.${classWrap}.${classRemove}`)
    .forEach((item) => item.classList.remove(classRemove))

  document.removeEventListener('click', fnRemove)
}
