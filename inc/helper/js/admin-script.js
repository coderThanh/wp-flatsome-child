/**
 *
 *  Add Fuction btn upload media
 *
 */
function buttonAddMediaList(event, isSaveWidget = false) {
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

    isSaveWidget && saveWidgetInputChange(event)

    if (inputImage) {
      inputImage.value = attachment.id
    }
    if (actions) {
      actions.innerHTML = `<button type="button" onclick="buttonRemoveMediaList(event,${
        isSaveWidget ? 'true' : 'false'
      })" class="button button_remove-media">x</button>`
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
function buttonRemoveMediaList(event, isSaveWidget = false) {
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

  isSaveWidget && saveWidgetInputChange(event)
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
// Popup script
function openPopup(event, idPopup, idCallback = '') {
  event.preventDefault()

  var popupWrap = document.getElementById(idPopup)

  popupWrap.classList.add('show')
  popupWrap.dataset.callbackId = idCallback
}

function openPopupSearchPostType(
  event,
  idPopup,
  idCallback = '',
  callbackOnChoiced = null,
) {
  event.preventDefault()

  var popupWrap = document.getElementById(idPopup)

  popupWrap.classList.add('show')
  popupWrap.dataset.callbackId = idCallback

  jQuery(document).ready(function ($) {
    $(popupWrap)
      .find('.field-search-ajax')
      .attr('data-handle-on-choiced', callbackOnChoiced)

    // reset event choiced if item rendered
    if (callbackOnChoiced) {
      $(popupWrap)
        .find('.el-result-item')
        .attr('onclick', `${callbackOnChoiced}(event)`)
    } else {
      $(popupWrap)
        .find('.el-result-item')
        .attr('onclick', `ptSearchPostAjaxChoiced(event)`)
    }
  })
}

function openPopupSearchPostTypeToSelectOther(
  event,
  idPopup,
  idCallback = '',
  callbackOnChoiced = null,
) {
  event.preventDefault()

  event.target
    .closest('.input__content')
    .classList.add('input__content-current-change')

  var popupWrap = document.getElementById(idPopup)

  popupWrap.classList.add('show')
  popupWrap.dataset.callbackId = idCallback

  jQuery(document).ready(function ($) {
    if (callbackOnChoiced) {
      $(popupWrap)
        .find('.field-search-ajax')
        .attr('data-handle-on-choiced', callbackOnChoiced)
    }

    // reset event choiced if item rendered
    if (callbackOnChoiced) {
      $(popupWrap)
        .find('.el-result-item')
        .attr('onclick', `${callbackOnChoiced}(event)`)
    } else {
      $(popupWrap)
        .find('.el-result-item')
        .attr('onclick', `ptSearchPostAjaxChoiced(event)`)
    }
  })
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
    const handleOnChoiced = wrap.attr('data-handle-on-choiced')
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

        wrap.addClass('active')
        wrap.find('.el-result-wrap').css('display', 'block')

        if (data.length === 0 || !data) {
          wrap.find('.el-result').css('display', 'none')
          wrap.find('.el-no-result').css('display', 'block')

          return
        }

        const options = data.map((item) => {
          return `<div onclick="${
            handleOnChoiced
              ? `${handleOnChoiced}(event)`
              : 'ptSearchPostAjaxChoiced(event)'
          }" class="tw-p-[12px] tw-cursor-pointer hover:tw-bg-gray-100 el-result-item" data-value="${
            item.ID
          }">${item.post_title}</div>`
        })

        wrap.find('.el-result').html(options)
        wrap.find('.el-result').css('display', 'block')
        wrap.find('.el-no-result').css('display', 'none')
      },
      complete: function () {
        hookBeforeExit()
      },
    })
  })
}

function ptSearchPostAjaxChoiced(event) {
  jQuery(document).ready(function ($) {
    var wrap = $(event.target.closest('.popup-wrap'))
    const idPopup = wrap.attr('id')
    const idOfRenderItemsCurrent = wrap.attr('data-callback-Id')
    const postTitle = event.target.innerText
    const postID = $(event.target).attr('data-value')

    if (!idOfRenderItemsCurrent) return
    var currentItems = $(`#${idOfRenderItemsCurrent}`)
    const fieldName = currentItems.attr('data-field-name') ?? ''

    currentItems.append(
      `<div
					class="input__content tw-border-0 !tw-border-b tw-border-gray-300 tw-border-solid tw-pb-[14px]  tw-flex tw-gap-[14px] tw-items-center">
          <span class="tw-flex-1 el-post-title">${postTitle}</span>
          <div class=" tw-cursor-pointer text-success"
						onclick="openPopupSearchPostTypeToSelectOther(event, '${idPopup}', '${idOfRenderItemsCurrent}', 'ptSearchPostAjaxChoicedToChange')">Chọn</div>
					<div class=" tw-cursor-pointer text-danger" onclick="deleteInputWrap(event)">Xóa item</div>
					<input type="hidden" name="${fieldName}"
						value="${postID}"
						class="tw-hidden el-post-input">
				</div>`,
    )

    $(event.target).addClass('tw-opacity-50')
  })
}

function ptSearchPostAjaxChoicedToChange(event) {
  jQuery(document).ready(function ($) {
    var wrap = $(event.target.closest('.popup-wrap'))
    const idOfRenderItemsCurrent = wrap.attr('data-callback-Id')
    const postTitle = event.target.innerText
    const postID = $(event.target).attr('data-value')

    if (!idOfRenderItemsCurrent) return
    var currentItems = $(`#${idOfRenderItemsCurrent}`)

    currentItems
      .find('.input__content-current-change .el-post-title')
      .text(postTitle)
    currentItems
      .find('.input__content-current-change .el-post-input')
      .val(postID)

    currentItems
      .find('.input__content-current-change')
      .removeClass('input__content-current-change')

    wrap.removeClass('show')
    $(event.target).addClass('tw-opacity-50')
  })
}

function ptSearchPostAjaxAutoCloseBoxOptions(event) {
  ptHandleCloseBoxOptions(
    event,
    'field-search-ajax',
    ptSearchPostAjaxAutoCloseBoxOptions,
  )
}
