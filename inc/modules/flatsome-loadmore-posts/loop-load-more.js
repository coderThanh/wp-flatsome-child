jQuery(document).ready(function ($) {
  // On Button Load more click
  $('.btn_loop_load_more').click(function () {
    var button = $(this),
      data = {
        action: 'loadmore',
        query: pt_loadmore_params.posts,
        page: pt_loadmore_params.current_page,
      }

    var buttonText = $(button).find('span').text()

    $.ajax({
      url: pt_loadmore_params.ajaxurl, // AJAX handler
      data: data,
      type: 'POST',
      beforeSend: function (xhr) {
        $(button).find('span').text('Loading...')
      },
      success: function (data) {
        if (data) {
          $(button).closest('.col').find('.row').append(data) // insert new posts

          let baseUrl = window.location.href
          baseUrl = baseUrl.replace(/page\/\d*\/*/g, '')
          window.history.pushState(
            '',
            '',
            baseUrl +
              'page/' +
              (parseInt(pt_loadmore_params.current_page++) + 1),
          )

          if (pt_loadmore_params.current_page == pt_loadmore_params.max_page)
            button.remove()
        } else {
          button.remove()
        }
      },
      complete: function () {
        $(button)?.find('span')?.text(buttonText)
      },
    })
  })

  // On scroll load
  // ptLoadMoreWhenScroll();

  function ptLoadMoreWhenScroll() {
    var canBeLoaded = true // this param allows to initiate the AJAX call only if necessary

    $(window).scroll(function () {
      var data = {
          action: 'loadmore',
          query: pt_loadmore_params.posts,
          page: pt_loadmore_params.current_page,
        },
        bottomOffset = $('.load_more_when_scroll'),
        buttonText = $('.btn_loop_load_more').text(),
        targetHeight

      if (!bottomOffset.position()) {
        return
      } else {
        targetHeight = $(bottomOffset).position().top
      }

      var minToLoadMore = targetHeight - window.innerHeight - 350

      var isOverButtonLoadMore =
        $(document).scrollTop() > minToLoadMore ? true : false

      if (isOverButtonLoadMore && canBeLoaded == true) {
        $.ajax({
          url: pt_loadmore_params.ajaxurl,
          data: data,
          type: 'POST',
          beforeSend: function (xhr) {
            // you can also add your own preloader here
            // you see, the AJAX call is in process, we shouldn't run it again until complete
            canBeLoaded = false
            $(bottomOffset).find('div').text('Loading...')
          },
          success: function (data) {
            if (data) {
              $('.load_more_when_scroll').prev().append(data) // where to insert posts

              let baseUrl = window.location.href
              baseUrl = baseUrl.replace(/page\/\d*\/*/g, '')
              window.history.pushState(
                '',
                '',
                baseUrl +
                  'page/' +
                  (parseInt(pt_loadmore_params.current_page++) + 1),
              )

              if (
                pt_loadmore_params.current_page == pt_loadmore_params.max_page
              ) {
                bottomOffset.remove()
              }
            } else {
              bottomOffset.remove()
            }
          },
          complete: function () {
            $(bottomOffset)?.find('div')?.text(buttonText)
            canBeLoaded = true // the ajax is completed, now we can run it again
          },
        })
      }
    })
  }
})
