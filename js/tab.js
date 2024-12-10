/**
 * Controller Tab Area
 */
function tabAreaController() {
  const classActive = "active";

  jQuery(document).ready(function ($) {
    $(".tab-area").each(function (indexInArray, tabElelement) {
      let currentIndex = 0;

      // init show
      $(tabElelement)
        .find(".tab-area-title-item")
        .eq(currentIndex)
        .addClass(classActive);

      $(tabElelement)
        .find(".tab-area-content-item")
        .eq(currentIndex)
        .addClass(classActive);

      $(tabElelement).find(".tab-area-content-item").hide();

      $(tabElelement).find(".tab-area-content-item").eq(currentIndex).show();

      // event
      $(tabElelement)
        .find(".tab-area-title-item")
        .click(function (e) {
          e.preventDefault();
          currentIndex = $(this).index();

          // change controll title
          $(tabElelement).find(".tab-area-title-item").removeClass(classActive);
          $(tabElelement)
            .find(".tab-area-title-item")
            .eq(currentIndex)
            .addClass(classActive);

          // change controll body
          $(tabElelement)
            .find(".tab-area-content-item")
            .removeClass(classActive)
            .hide();

          $(tabElelement)
            .find(".tab-area-content-item")
            .eq(currentIndex)
            .addClass(classActive)
            .fadeIn();
        });
    });
  });
}

tabAreaController();
