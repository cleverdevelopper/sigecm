$(document).ready(function () {
  var o,
    e = ["SEM VIATURA"];
  $("#the-basics").typeahead(
    { hint: !0, highlight: !0, minLength: 1 },
    {
      name: "states",
      source:
        ((o = e),
        function (e, a) {
          var t = [];
          (substrRegex = new RegExp(e, "i")),
            $.each(o, function (e, a) {
              substrRegex.test(a) && t.push(a);
            }),
            a(t);
        }),
    }
  );
  e = ["NAO PORTA ARMA"];
  $("#the-advanced").typeahead(
    { hint: !0, highlight: !0, minLength: 1 },
    {
      name: "states",
      source:
        ((o = e),
        function (e, a) {
          var t = [];
          (substrRegex = new RegExp(e, "i")),
            $.each(o, function (e, a) {
              substrRegex.test(a) && t.push(a);
            }),
            a(t);
        }),
    }
  );
});