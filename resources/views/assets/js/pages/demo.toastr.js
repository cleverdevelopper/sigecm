!(function (i) {
  "use strict";
  i("#toastr-one").on("click", function (t) {
    i.NotificationApp.send(
      "Heads up!",
      "This alert needs your attention, but it is not super important.",
      "top-right",
      "rgba(0,0,0,0.2)",
      "info"
    );
  }),
    i("#toastr-two").on("click", function (t) {
      i.NotificationApp.send(
        "Heads up!",
        "Check below fields please.",
        "top-center",
        "rgba(0,0,0,0.2)",
        "warning"
      );
    }),
    i("#toastr-three").on("click", function (t) {
      i.NotificationApp.send(
        "Well Done!",
        "You successfully read this important alert message",
        "bottom-right",
        "rgba(0,0,0,0.2)",
        "success"
      );
    }),
    i("#toastr-four").on("click", function (t) {
      i.NotificationApp.send(
        "Oh snap!",
        "Change a few things up and try submitting again.",
        "bottom-left",
        "rgba(0,0,0,0.2)",
        "error"
      );
    }),
    i("#toastr-five").on("click", function (t) {
      i.NotificationApp.send(
        "How to contribute?",
        [
          "Fork the repository",
          "Improve/extend the functionality",
          "Create a pull request",
        ],
        "top-right",
        "rgba(0,0,0,0.2)",
        "info"
      );
    }),
    i("#toastr-six").on("click", function (t) {
      i.NotificationApp.send(
        "Can I add <em>icons</em>?",
        "Yes! check this <a href='https://github.com/kamranahmedse/jquery-toast-plugin/commits/master'>update</a>.",
        "top-right",
        "rgba(0,0,0,0.2)",
        "info",
        !1
      );
    }),
    i("#toastr-seven").on("click", function (t) {
      i.NotificationApp.send(
        "",
        "Set the `hideAfter` property to false and the toast will become sticky.",
        "top-right",
        "rgba(0,0,0,0.2)",
        "success"
      );
    }),
    i("#toastr-eight").on("click", function (t) {
      i.NotificationApp.send(
        "",
        "Set the `showHideTransition` property to fade|plain|slide to achieve different transitions.",
        "top-right",
        "rgba(0,0,0,0.2)",
        "info",
        3e3,
        1,
        "fade"
      );
    });
})(window.jQuery);
