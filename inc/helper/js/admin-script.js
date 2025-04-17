/**
 *
 *  Add Fuction btn upload media
 *
 */
function buttonAddMediaList(event) {
  event.preventDefault()
  var mediaUploader

  // If the uploader object has already been created, reopen the dialog
  if (mediaUploader) {
    mediaUploader.open()
    return
  }

  // Extend the wp.media object
  mediaUploader = wp.media.frames.file_frame = wp.media({
    title: 'Media library',
    button: {
      text: 'Set  image',
    },
    multiple: false,
  })

  // When a file is selected, grab the URL and set it as the text field's value
  mediaUploader.on('select', function () {
    attachment = mediaUploader.state().get('selection').first().toJSON()

    var mediaView = event.target.closest('.attachment_media-view')
    var inputImage = mediaView.querySelector('.image-url ')
    var actions = mediaView.querySelector('.actions ')

    saveWidgetInputChange(event)

    if (inputImage) {
      inputImage.value = attachment.id
    }
    if (actions) {
      actions.innerHTML =
        '<button type="button" onclick="buttonRemoveMediaList(event)" class="button button_remove-media">x</button>'
    }

    var btnAddMedia = event.target.closest('.button_add-media')

    if (btnAddMedia) {
      btnAddMedia.innerHTML =
        '<img class="preview-img" src="' + attachment.url + '"/>'
    } else {
      event.target.innerHTML =
        '<img class="preview-img" src="' + attachment.url + '"/>'
    }
  })

  // Open the uploader dialog
  mediaUploader.open()
}

//remove image
function buttonRemoveMediaList(event) {
  event.preventDefault()

  var mediaView = event.target.closest('.attachment_media-view')
  var buttonAddMedia = mediaView.querySelector('.button_add-media')
  var inputImage = mediaView.querySelector('.image-url ')

  if (buttonAddMedia) {
    buttonAddMedia.innerHTML = 'Set image'
  }
  if (inputImage) {
    inputImage.value = ''
  }

  saveWidgetInputChange(event)
  event.target.remove()
}

// Add more img to parent
function addInputImageToParent(event, inputInner, wrapQuery, appendToQuery) {
  event.preventDefault()

  var btnClick = event.target
  var inputWrap = btnClick.closest(wrapQuery)
  var appendTo = inputWrap.querySelector(appendToQuery)

  if (appendTo) {
    appendTo.insertAdjacentHTML('beforeend', inputInner)
  }
}

function addInputImageToMetaBox(event, nameValue, wrapQuery, appendToQuery) {
  event.preventDefault()

  var btnClick = event.target
  var inputWrap = btnClick.closest(wrapQuery)
  var appendTo = inputWrap.querySelector(appendToQuery)

  var inputField = document.createElement('div')
  inputField.classList.add('input__content')

  var innerField = `
    <div class="attachment_media-view">
        <button type="button" class="button_add-media" onclick="buttonAddMediaList(event)">
          Upload image
        </button>
        <input class="image-url widefat" type="hidden" name="${nameValue}" value="" />
    </div>
    <a class=" btn__add_delete admin-btn__input" onclick="deleteInputWrap(event)">Xoá ảnh</a>
    `

  inputField.innerHTML = innerField

  if (appendTo) {
    appendTo.appendChild(inputField)
  }
}

/**
 * Function metabox delete
 *
 */

function addFieldOfMetaBox(event, content = '') {
  event.preventDefault()
  var metaBoxWrap = event.target.closest('.meta-box_block')

  jQuery(function ($) {
    $(metaBoxWrap).append(content)
  })
}

function removeFieldOfMetaBox(event) {
  event.preventDefault()
  var metaBoxWrap = event.target.closest('tr')

  jQuery(function ($) {
    $(metaBoxWrap).remove()
  })
}

/**
 * Class PT_INPUT
 * Change value width input type = range
 */

function changeValueInputRangeWrap(event) {
  event.preventDefault()
  var inputValue = event.target.value
  var inputWrap = event.target.closest('.form-range_wrap')
  inputWrap.querySelector('.form-range_value').innerHTML = inputValue
}

//
function addCardFieldHaveImgLink(event, imgName = '', linkName = '') {
  jQuery(document).ready(function ($) {
    const id = makeid()
    const parrentWrap = $(event.target).closest('.field-wraps')
    const contentItem = `
        <div class="card mb-3 input__content">
            <div class="attachment_media-view">
                <button type="button" class="button_add-media" onclick="buttonAddMediaList(event)">Upload image</button>
                <div class="actions"></div>
                <input  class="image-url widefat" type="hidden" name="${imgName}[${id}]" value />
            </div>
            <div class="input-group my-2">
                <div class="input-group-prepend">
                    <span class="input-group-text">Đường dẫn</span>
                </div>
                <input type="text"  class="form-control" name="${linkName}[${id}]" value="">
            </div>
            <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
        </div>
                    `
    $(parrentWrap).find('.field-content')?.append(contentItem)
  })
}

//
function addCardFieldHaveImgDesktopMobileLink(
  event,
  nameImg,
  nameMobile,
  nameLink,
) {
  jQuery(document).ready(function ($) {
    const id = makeid()
    const parrentWrap = $(event.target).closest('.field-wraps')
    const contentItem = `
      <div class="card mb-3 input__content">
         <div class="my-2">
            <label class="form-label">Desktop</label>
            <div class="attachment_media-view">
                <button type="button" class="button_add-media" onclick="buttonAddMediaList(event)">Upload image</button>
                <div class="actions"></div>
                <input  class="image-url widefat" type="hidden" name="${nameImg}[${id}]" value />
            </div>
        </div>
         <div class="my-2">
            <label class="form-label">Mobile</label>
            <div class="attachment_media-view">
                <button type="button" class="button_add-media" onclick="buttonAddMediaList(event)">Upload image</button>
                <div class="actions"></div>
                <input  class="image-url widefat" type="hidden" name="${nameMobile}[${id}]" value />
            </div>
        </div>
        <div class="input-group my-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Đường dẫn</span>
            </div>
            <input type="text"  class="form-control m-0" name="${nameLink}[${id}]" value="">
        </div>
        <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
    </div>
    `
    $(parrentWrap).find('.field-content')?.append(contentItem)
  })
}

//
function addCardFieldHaveImgLinkTitle(event, nameImg, nameTitle, nameLink) {
  jQuery(document).ready(function ($) {
    const id = makeid()
    const parrentWrap = $(event.target).closest('.field-wraps')
    const contentItem = `
      <div class="card mb-3 input__content">
        <div class="attachment_media-view">
            <button type="button" class="button_add-media" onclick="buttonAddMediaList(event)">Upload image</button>
            <div class="actions"></div>
            <input  class="image-url widefat" type="hidden" name="${nameImg}[${id}]" value />
        </div>
        <div class="input-group my-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Tiêu đề</span>
            </div>
            <input type="text"  class="form-control m-0" name="${nameTitle}[${id}]" value="">
        </div>
        <div class="input-group my-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Đường dẫn</span>
            </div>
            <input type="text"  class="form-control m-0" name="${nameLink}[${id}]" value="">
        </div>
        <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
    </div>
    `
    $(parrentWrap).find('.field-content')?.append(contentItem)
  })
}

/**
 * Script: Color Picker
 */

jQuery(document).ready(function ($) {
  $('.wp-color-field').wpColorPicker()
})

/**
 * Button use for gallery image
 */

function deleteInputWrap(event) {
  event.preventDefault()

  var btnClick = event.target
  var inputContent = btnClick.closest('.input__content')

  inputContent.remove()
}

//
function ptSearchPostAjax(event) {
  jQuery(document).ready(function ($) {
    var wrap = event.target.closest('.field-search-ajax')

    if (wrap.length === 0) return

    wrap = $(wrap)

    //
    var isLoading = wrap.attr('data-loading')

    if (isLoading === 'true') return

    wrap.attr('data-loading', 'true')

    // set button
    var button = $(event.target)

    var buttonTextSubmit = button.text()

    button.text('Loading...')

    //
    const hookBeforeExit = () => {
      wrap.attr('data-loading', 'false')

      button.text(buttonTextSubmit)
    }

    // fetch data
    const ajaxUrl = wrap.attr('data-ajax-url')

    const searchValue = wrap.find('input').val()

    var query = wrap.attr('data-query')

    query = JSON.parse(query)

    query.search_text = searchValue.trim()

    var data = {
      action: 'search_post_ajax',
      query: JSON.stringify(query),
    }

    $.ajax({
      url: ajaxUrl, // AJAX handler
      data: data,
      type: 'POST',
      success: function (data) {
        var data = JSON.parse(data)

        document.addEventListener('click', ptSearchPostAjaxAutoCloseBoxOptions)

        if (data.length === 0 || !data) {
          wrap.addClass('active')

          wrap.find('.el-result').css('display', 'none')
          wrap.find('.el-no-result').css('display', 'block')

          return
        }

        const options = data.map((item) => {
          return `<div onclick="ptSearchPostAjaxChoiced(event)" class="el-option" data-value="${item.ID}">${item.post_title}</div>`
        })

        wrap.find('.el-result').html(options)
        wrap.find('.el-result').css('display', 'block')
        wrap.find('.el-no-result').css('display', 'none')

        wrap.addClass('active')
      },
      complete: function () {
        hookBeforeExit()
      },
    })
  })
}

function ptSearchPostAjaxChoiced(event) {
  jQuery(document).ready(function ($) {
    const option = $(event.target)
    const wrap = $(event.target).closest('.field-search-ajax')

    const value = option.attr('data-value')
    const label = option.text()

    const valueCurrent = wrap.attr('data-value')

    if (valueCurrent == value) {
      wrap.attr('data-value', '')
      wrap.attr('data-label', '')
      wrap.find('input').val('')

      wrap.removeClass('active')
      document.removeEventListener('click', ptSearchPostAjaxAutoCloseBoxOptions)

      return
    }

    wrap.attr('data-value', value)
    wrap.attr('data-label', label)
    wrap.find('input').val(label)
    wrap.removeClass('active')
    document.removeEventListener('click', ptSearchPostAjaxAutoCloseBoxOptions)
  })
}

function ptSearchPostAjaxAutoCloseBoxOptions(event) {
  ptHandleCloseBoxOptions(
    event,
    'field-search-ajax',
    ptSearchPostAjaxAutoCloseBoxOptions,
  )
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
