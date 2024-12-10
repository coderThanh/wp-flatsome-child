function ptPopUpOpen(event) {
  jQuery(document).ready(function ($) {
    const classPopupName = $(event.target).attr('data-id-popup-show')
    $(event.target).closest('body').find(classPopupName).addClass('show')
  })
}

function ptPopUpClose(event) {
  jQuery(document).ready(function ($) {
    $(event.target).closest('.pt-popup-wrap').removeClass('show')
  })
}
