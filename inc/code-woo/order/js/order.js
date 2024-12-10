function handleRemakeUICheckBoxField() {
  jQuery(document).ready(function ($) {
    $(
      'body.woocommerce-checkout .woocommerce-billing-fields__field-wrapper .is-field-invoice',
    ).remove()
  })
}
handleRemakeUICheckBoxField()

//

var globalProvinces = null
var globalDistricts = []
var globalWards = []

function setGlobalAddress() {
  if (globalProvinces || globalDistricts.length || globalWards.length) {
    return
  }

  var provincesEl = document.getElementById('data-provinces')
  var districtsEl = document.getElementById('data-districts')
  var wardsEl = document.getElementById('data-wards')

  if (provincesEl) {
    globalProvinces = JSON.parse(provincesEl.getAttribute('data-value'))
  }

  if (districtsEl) {
    globalDistricts = JSON.parse(districtsEl.getAttribute('data-value'))
  }
  if (wardsEl) {
    globalWards = JSON.parse(wardsEl.getAttribute('data-value'))
  }
}

//
function handleWCAddressSelectSearchBox() {
  const htmlSelectSearchBox = `
    <div class="wc-select-search-box">
        <div class="el-curent-name"></div>
        <div class="el-popup">
            <div class="el-input-wrap">
                <input type="text" class="field-search placeholder="Tìm kiếm" />
            </div>
            <div class="el-options-wrap">
                <div class="el-options">
                </div>
            </div>
        </div>
    </div>
`

  jQuery(document).ready(function ($) {
    $('.wc-address-search .woocommerce-input-wrapper').each(function (
      indexInArray,
      wrapperEl,
    ) {
      const classActive = 'active'
      const classShow = 'show'
      const classCurrent = 'current'

      //
      setGlobalAddress()

      if (!globalProvinces || !globalDistricts.length || !globalWards.length) {
        return
      }

      // Hook
      const setLayoutForm = () => {
        var options = ''
        var currentValue = ''
        var currentOption = 'Không có dữ liệu'

        $(wrapperEl).find('input[type="text"]')?.addClass('input-main')

        if ($(wrapperEl).find('.input-main')?.val()) {
          currentValue = $(wrapperEl).find('.input-main')?.val()
        }

        // for provinces
        if (
          $(wrapperEl)
            .closest('.wc-address-search')
            .hasClass('wc-procinves-select')
        ) {
          for (const key in globalProvinces) {
            options += `<div class="option ${
              key == currentValue ? classCurrent : ''
            } ${classShow}" value="${key}">${globalProvinces[key]}</div>`
          }

          if (globalProvinces[currentValue]) {
            currentOption = globalProvinces[currentValue]
          } else {
            currentOption = 'Chọn tỉnh / thành phố'
          }
        }

        //for districts
        if (
          $(wrapperEl)
            .closest('.wc-address-search')
            .hasClass('wc-district-select')
        ) {
          var index = globalDistricts.findIndex((x) => x.maqh == currentValue)

          if (index != -1) {
            currentOption = globalDistricts[index].name

            var listDistricts = globalDistricts.filter(
              (x) => x.matp == globalDistricts[index].matp,
            )

            listDistricts.forEach((item) => {
              options += `<div class="option ${
                item.maqh == currentValue ? classCurrent : ''
              } ${classShow}" value="${item.maqh}">${item.name}</div>`
            })
          } else {
            options = `<div class="option ${classShow}">Chọn Quận / huyện</div>`
            currentOption = `Chọn quận / huyện`
          }
        }

        //for wards
        if (
          $(wrapperEl).closest('.wc-address-search').hasClass('wc-ward-select')
        ) {
          var index = globalWards.findIndex((x) => x.xaid == currentValue)

          if (index != -1) {
            currentOption = globalWards[index].name

            var listWards = globalWards.filter(
              (x) => x.maqh == globalWards[index].maqh,
            )

            listWards.forEach((item) => {
              options += `<div class="option ${
                item.maqh == currentValue ? classCurrent : ''
              } ${classShow}" value="${item.xaid}">${item.name}</div>`
            })
          } else {
            options = `<div class="option ${classShow}">Chọn Phường / xã</div>`
            currentOption = `Chọn phường / xã`
          }
        }

        $(wrapperEl)
          .find('input[type="text"]:not(.field-search)')
          .attr('data-current', currentValue)
        $(wrapperEl)
          .find('input[type="text"]:not(.field-search)')
          .val(currentValue)

        $(wrapperEl).append(htmlSelectSearchBox)

        $(wrapperEl).find('.el-options').html(options)

        $(wrapperEl).find('.el-curent-name').text(currentOption)
      }

      const handleCloseBox = (event) => {
        ptHandleCloseBoxOptions(
          event,
          'wc-select-search-box',
          handleCloseBox,
          classActive,
        )
      }

      const handleToggleSearchBox = () => {
        $(wrapperEl)
          .find('.el-curent-name')
          .click(function (e) {
            //   e.preventDefault()

            if (
              $(wrapperEl).find('.wc-select-search-box').hasClass(classActive)
            ) {
              $(wrapperEl)
                .find('.wc-select-search-box')
                .removeClass(classActive)
              document.removeEventListener('click', handleCloseBox)
            } else {
              $('.wc-select-search-box').removeClass(classActive)
              document.removeEventListener('click', handleCloseBox)

              $(wrapperEl).find('.wc-select-search-box').addClass(classActive)
              document.addEventListener('click', handleCloseBox)
            }
          })
      }

      const handleSearchChing = () => {
        $(wrapperEl)
          .find('.field-search')
          .on('input', function (event) {
            if (event.target.value) {
              $(wrapperEl)
                .find('.el-options .option')
                .each(function (indexInArray, optionEl) {
                  var text = $(optionEl).text()

                  text = text.trim()
                  text = toLowerCaseNonAccentVietnamese(text)

                  var value = event.target.value
                  value = value.trim()
                  value = toLowerCaseNonAccentVietnamese(value)

                  if (text.includes(value)) {
                    $(optionEl).addClass(classShow)
                  } else {
                    $(optionEl).removeClass(classShow)
                  }
                })

              // empty result
              if ($(wrapperEl).find(`.el-options .${classShow}`).length == 0) {
                if (
                  $(wrapperEl).find(`.el-options .option-empty-result`)
                    .length == 0
                ) {
                  $(wrapperEl)
                    .find(`.el-options`)
                    .append(
                      `<div class="option-empty-result">Không có kết quả</div>`,
                    )
                }
              } else {
                $(wrapperEl).find(`.el-options .option-empty-result`).remove()
              }
            } else {
              // reset
              $(wrapperEl).find('.el-options .option').addClass(classShow)
            }
          })
      }

      // Run
      setLayoutForm()

      handleChangeWCAddress()

      handleToggleSearchBox()

      handleSearchChing()
    })
  })
}

handleWCAddressSelectSearchBox()

//
function handleChangeWCAddress() {
  const targetWrapper = '.clear, .order-data-item' // on cms / fe

  jQuery(document).ready(function ($) {
    setGlobalAddress()

    if (!globalProvinces || !globalDistricts.length || !globalWards.length) {
      return
    }

    const handleSelectProvince = () => {
      //
      $('.wc-procinves-select .el-options-wrap .option').on(
        'click',
        function (event) {
          // change value
          const wrapEl = $(event.target).closest('.woocommerce-input-wrapper')

          const textName = $(event.target).text()

          const id = $(event.target).attr('value')

          $(wrapEl).find('.wc-select-search-box').removeClass('active')

          $(wrapEl).find('.el-curent-name').text(textName)
          $(wrapEl).find('input.input-main').val(id)
          $(wrapEl).find('input.input-main').attr('data-current', id)

          resetDistrict(event)
          resetWard(event)

          //redender list options
          var listOptions = globalDistricts.filter((item) => item['matp'] == id)


          var html_options =
            '<div class="option-empty-result">Không có kết quả</div>'

          if (listOptions.length > 0) {
            html_options = listOptions
              .map(
                (item) =>
                  `<div value="${item['maqh']}" class="option show">${item['name']}</div>`,
              )
              .join('')
          }

          $(event.target)
            .closest(targetWrapper)
            .find('.wc-district-select .el-options')
            .html(html_options)

          $(event.target)
            .closest(targetWrapper)
            .find('.wc-district-select .field-search')
            .val('')

          handleSelectDistrich()
        },
      )
    }
    handleSelectProvince()

    //
    const handleSelectDistrich = () => {
      $('.wc-district-select .el-options-wrap .option').on(
        'click',
        function (event) {
          const wrapEl = $(event.target).closest('.woocommerce-input-wrapper')

          const textName = $(event.target).text()

          const id = $(event.target).attr('value')

          $(wrapEl).find('.wc-select-search-box').removeClass('active')

          $(wrapEl).find('.el-curent-name').text(textName)
          $(wrapEl).find('input.input-main').val(id)
          $(wrapEl).find('input.input-main').attr('data-current', id)

          resetWard(event)

          //
          var listOptions = globalWards.filter((item) => item['maqh'] == id)

          var html_options =
            '<div class="option-empty-result">Không có kết quả</div>'

          if (listOptions.length > 0) {
            html_options = listOptions
              .map(
                (item) =>
                  `<div value="${item['xaid']}" class="option show">${item['name']}</div>`,
              )
              .join('')
          }

          $(event.target)
            .closest(targetWrapper)
            .find('.wc-ward-select .el-options')
            .html(html_options)

          $(event.target)
            .closest(targetWrapper)
            .find('.wc-ward-select .field-search')
            .val('')

          handleSelectWard()
        },
      )
    }
    handleSelectDistrich()

    //
    const handleSelectWard = () => {
      $('.wc-ward-select .el-options-wrap .option').on(
        'click',
        function (event) {
          const wrapEl = $(event.target).closest('.woocommerce-input-wrapper')

          const textName = $(event.target).text()

          const id = $(event.target).attr('value')

          $(wrapEl).find('.wc-select-search-box').removeClass('active')

          $(wrapEl).find('.el-curent-name').text(textName)
          $(wrapEl).find('input.input-main').val(id)
          $(wrapEl).find('input.input-main').attr('data-current', id)
        },
      )
    }
    handleSelectWard()

    //
    const resetDistrict = (event) => {
      $(event.target)
        .closest(targetWrapper)
        .find('.wc-district-select input.input-main')
        .val('')
      $(event.target)
        .closest(targetWrapper)
        .find('.wc-district-select input.input-main')
        .attr('data-current', '')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-district-select .el-options')
        .html('<div class="option-empty-result">Chọn tỉnh / thành phố</div>')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-district-select .el-curent-name')
        .text('Chọn quận / huyện')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-district-select .field-search')
        .val('')
    }

    const resetWard = (event) => {
      $(event.target)
        .closest(targetWrapper)
        .find('.wc-ward-select input.input-main')
        .val('')
      $(event.target)
        .closest(targetWrapper)
        .find('.wc-ward-select input.input-main')
        .attr('data-current', '')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-ward-select .el-options')
        .html('<div class="option-empty-result">Chọn quận / huyện</div>')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-ward-select .el-curent-name')
        .text('Chọn phường / xã')

      $(event.target)
        .closest(targetWrapper)
        .find('.wc-ward-select .field-search')
        .val('')
    }
  })
}

handleChangeWCAddress()

//
function handleShowWCInvoiceField() {
  jQuery(document).ready(function ($) {
    $('.woocommerce-invoice-fields').each(function (indexInArray, wrappEl) {
      $(wrappEl)
        .find('#require-invoice-checkbox')
        .on('change', function (event) {
          if (this.checked) {
            $(wrappEl).addClass('active')
          } else {
            $(wrappEl).removeClass('active')
          }
        })
    })
  })
}

handleShowWCInvoiceField()

//
function handleAddminToggleOrderFields() {
  jQuery(document).ready(function ($) {
    $('.order-fields').each(function (indexInArray, wrappEl) {
      $(wrappEl)
        .find('.el-btn-edit')
        .on('click', function (event) {
          $(wrappEl).find('.el-info').css('display', 'none')
          $(wrappEl).find('.el-field-wrapper').css('display', 'block')
          $(wrappEl).find('.el-btn-edit').css('display', 'none')
        })
    })
  })
}
handleAddminToggleOrderFields()

//
function handleAdminOrderRemakeUI() {
  jQuery(document).ready(function ($) {
    $('body.wp-admin .order_data_column .order_note').appendTo(
      'body.wp-admin .order-data-item.order-data-billing',
    )
  })
}

handleAdminOrderRemakeUI()
