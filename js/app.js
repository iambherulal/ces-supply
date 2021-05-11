/* 

1. Prodile Update Validation

*/

var dealFeedPost = 2;

// A $( document ).ready() block.
$(document).ready(function () {
  /*  1. Prodile Update */

  $("#updateProfile").validate({
    rules: {
      password1: {
        minlength: 6,
      },
      password2: {
        minlength: 6,
        equalTo: "#newpassword",
      },
    },

    messages: {
      password2: "Password Mismatch",
    },
  });

  /* 2. Single Deal */

  $("select#vendor_address").on("change", function () {
    const vendorAddress = this.value;
    const newAddress = $("textarea#vendorNewAddress");

    if (vendorAddress === "new") {
      newAddress.css("display", "block").attr("required", "true");
    } else {
      newAddress.css("display", "none").removeAttr("required");
    }
  });

  $("#emailNotification").change(function () {
    if ($(this).prop("checked")) {
      $("div#emailAddressContainer").show();
      $("input#emailAddress").attr("required", "true");
    } else {
      $("div#emailAddressContainer").hide();
      $("input#emailAddress").removeAttr("required");
    }
  });

  // remove no validate attribute

  $("form#dealApplyForm").removeAttr("novalidate");

  // run date function only single deals page

  // datetimepicker
  if ($("body").hasClass("single-deals")) {
    $("#deals_pickup_date").datetimepicker({
      allowInputToggle: true,
      showClose: true,
      showClear: true,
      showTodayButton: true,
      format: "MM/DD/YYYY hh:mm:ss A",
    });
  }

  // Ajex Post load More

  function appendDealsFeed(data, callback) {
    $.post(dealFeed.ajaxurl, data, function (response) {
      if ($.trim(response) == "") {
        $(".loadmore").hide();
      }
      $("#deals__feed").append(response);
      dealFeedPost++;
      data.page = dealFeedPost;
      $("button#loadMoreFeed").html("Load more");
      $.post(dealFeed.ajaxurl, data, function (response) {
        if ($.trim(response) == "") {
          $(".loadmore").hide();
        }
      });
    });
  }

  $(".deals__feed-container").on("click", ".loadmore", function () {
    $("button#loadMoreFeed").html(
      'Loading.... <span class="spinner-border spinner-border-sm"></span>'
    );
    var data = {
      action: "load_deals_by_ajax",
      page: dealFeedPost,
      security: dealFeed.security,
    };
    appendDealsFeed(data);
  });

  /* 3. Activity */
  if (
    $("body").hasClass("page-template-activity") ||
    $("body").hasClass("page-template-deals-listing")
  ) {
    $("#vendor_activity")
      .DataTable({
        responsive: true,
        // lengthChange: false,
        autoWidth: false,
        dom: "lBfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          ["10", "25", "50", "Show all"],
        ],
        buttons: ["copy", "csv", "excel", "pdf", "print"],
      })
      .buttons()
      .container()
      .appendTo("#vendor_activity_wrapper .col-md-6:eq(0)");
  }

  // Search Using Ajex
  class Search {
    // 1. describe our object
    constructor() {
      this.addSearhHtml();
      this.resultsDiv = jQuery("#search-overlay__results");
      this.openButton = jQuery(".js-search-trigger");
      this.closeButton = jQuery(".search-overlay__close");
      this.searchOverlay = jQuery(".search-overlay");
      this.searchField = jQuery("#search-term");
      this.events();
      this.isOverlayOpen = false;
      this.isSpinnerVisiable = false;
      this.previousValue;
      this.typingTimer;
    }

    // 2. events
    events() {
      this.openButton.on("click", this.openOverlay.bind(this));
      this.closeButton.on("click", this.closeOverlay.bind(this));
      jQuery(document).on("keydown", this.keyPressDispatcher.bind(this));
      this.searchField.on("keyup", this.typingLogic.bind(this));
    }

    // 3. Methods
    typingLogic() {
      if (this.searchField.val() != this.previousValue) {
        clearTimeout(this.typingTimer);
        if (this.searchField.val()) {
          if (!this.isSpinnerVisiable) {
            this.resultsDiv.html('<div class="spinner-loader"></div>');
            this.isSpinnerVisiable = true;
          }
          this.typingTimer = setTimeout(this.getResults.bind(this), 750);
        } else {
          this.resultsDiv.html("");
          this.isSpinnerVisiable = false;
        }
      }

      this.previousValue = this.searchField.val();

      console.log(this.previousValue);
    }
    getResults() {
      // New Custom API URL

      jQuery.getJSON(
        dealFeed.rooturl +
          "/wp-json/wp/v2/deals?search=" +
          this.searchField.val(),
        (results) => {
          this.resultsDiv.html(`
          <div class="container deals_search-result">
          <div class="row">
          <div class="col-md-12 mt-4">
                <h2 class="search-overlay__section-title">Search Results</h2>
                ${
                  results.length
                    ? '<ul class="link-list min-list">'
                    : "<p>No Deals found related to your search Query</p>"
                }
                  ${results
                    .map(
                      (item) =>
                        `<li><a target="_blank" href="${item.link}">${
                          item.title.rendered
                        }</a> ${
                          item.deal_status == 3
                            ? '<span class="badge badge-danger">Closed</span>'
                            : '<span class="badge badge-primary">Open</span>'
                        } </li>`
                    )
                    .join("")}
                ${results.length ? "</ul>" : ""}
                </div>
                </div>
                </div>
            `);
          // console.log(results.generalInfo.length);
        }
      );
      this.isSpinnerVisiable = false;
      throw new Error("Search result finished");
    }

    keyPressDispatcher(e) {
      if (
        e.keyCode == 83 &&
        !this.isOverlayOpen &&
        !jQuery("input, textarea").is(":focus")
      ) {
        this.openOverlay();
      }

      if (e.keyCode == 27 && this.isOverlayOpen) {
        this.closeOverlay();
      }
    }

    openOverlay() {
      this.searchOverlay.addClass("search-overlay--active");
      jQuery("body").addClass("body-no-scroll");
      setTimeout(() => this.searchField.focus(), 301);
      console.log("Open method rend");
      this.isOverlayOpen = true;
    }

    closeOverlay() {
      this.searchOverlay.removeClass("search-overlay--active");
      jQuery("body").removeClass("body-no-scroll");
      console.log("close method rend");
      this.searchField.val("");
      jQuery(".deals_search-result").remove();
      this.isOverlayOpen = false;
    }

    addSearhHtml() {
      jQuery("body ").append(`
        <div class="search-overlay">
          <div class="search-overlay__top">
            <div class="container">
              <i class="fa fa-search search-overlay__icon" area-hidden="true"></i>
              <input type="text" class="search-term" placeholder="Search Deals" id="search-term">
              <i class="fa fa-window-close search-overlay__close" area-hidden="true"></i>
            </div>
          </div>
          <div class="container">
            <div id="search-overlay__results">
            </div>
          </div>
        </div>
        `);
    }
  }

  const livesearch = new Search();
	
	  // New onchange filter
  $("#deal__dropdown").on("change", (e) => {
    var filter = $("#deal__filter");
    // console.log(e.target);
    $.ajax({
      url: dealFeed.ajaxurl,
      data: filter.serialize(), // form data
      type: "POST", // POST
      beforeSend: function (xhr) {
        // filter.find("button").text("Processing..."); // changing the button label
      },
      success: function (data) {
        // filter.find("button").text("Apply filter"); // changing the button label back
        $("#deals__feed").html(data); // insert data
      },
    });
    return false;
  });
});
