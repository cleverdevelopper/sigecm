/*$(document).ready(function () {
  "use strict";
  $("#basic-datatable").DataTable({
    keys: !0,
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });
  var a = $("#datatable-buttons").DataTable({
    lengthChange: !1,
    buttons: ["copy", "print"],
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });
  $("#selection-datatable").DataTable({
    select: { style: "multi" },
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  }),
    a
      .buttons()
      .container()
      .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
    $("#alternative-page-datatable").DataTable({
      pagingType: "full_numbers",
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
    }),
    $("#scroll-vertical-datatable").DataTable({
      scrollY: "350px",
      scrollCollapse: !0,
      paging: !1,
      language: {
        paginate: {
          next: "<i class='mdi mdi-chevron-right'>",
        },
      },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
    }),
    $("#scroll-horizontal-datatable").DataTable({
      scrollX: !0,
      language: {
        paginate: {
          previous: "<i class='mdi mdi-chevron-left'>",
          next: "<i class='mdi mdi-chevron-right'>",
        },
      },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
    }),
    $("#complex-header-datatable").DataTable({
      language: {
        paginate: {
          previous: "<i class='mdi mdi-chevron-left'>",
          next: "<i class='mdi mdi-chevron-right'>",
        },
      },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
      columnDefs: [{ visible: !1, targets: -1 }],
    }),
    $("#row-callback-datatable").DataTable({
      language: {
        paginate: {
          previous: "<i class='mdi mdi-chevron-left'>",
          next: "<i class='mdi mdi-chevron-right'>",
        },
      },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
      createdRow: function (a, e, t) {
        15e4 < +e[5].replace(/[\$,]/g, "") &&
          $("td", a).eq(5).addClass("text-danger");
      },
    }),
    $("#state-saving-datatable").DataTable({
      stateSave: !0,
      language: {
        paginate: {
          previous: "<i class='mdi mdi-chevron-left'>",
          next: "<i class='mdi mdi-chevron-right'>",
        },
      },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
    }),
    $("#fixed-header-datatable").DataTable({ fixedHeader: !0 }),
    $("#fixed-columns-datatable").DataTable({
      scrollY: 300,
      scrollX: !0,
      scrollCollapse: !0,
      paging: !1,
      fixedColumns: !0,
    }),
    $(".dataTables_length select").addClass("form-select form-select-sm"),
    $(".dataTables_length label").addClass("form-label");
});*/



$(document).ready(function () {
  "use strict";
  
  // Inicializa o DataTable básico
  $("#basic-datatable").DataTable({
    keys: true,
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com botões de cópia e impressão
  var a = $("#datatable-buttons").DataTable({
    lengthChange: false,
    buttons: ["copy", "print"],
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // Adiciona os botões de ação na posição correta
  a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

  // DataTable com seleção de múltiplas linhas
  $("#selection-datatable").DataTable({
    select: { style: "multi" },
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com paginacao de números
  $("#alternative-page-datatable").DataTable({
    pagingType: "full_numbers",
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com rolagem vertical
  $("#scroll-vertical-datatable").DataTable({
    scrollY: "350px",
    scrollCollapse: true,
    paging: false,
    language: {
      paginate: {
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com rolagem horizontal
  $("#scroll-horizontal-datatable").DataTable({
    scrollX: true,
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com cabeçalho complexo
  $("#complex-header-datatable").DataTable({
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
    columnDefs: [{ visible: false, targets: -1 }],
  });

  // DataTable com callback para linhas
  $("#row-callback-datatable").DataTable({
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
    createdRow: function (a, e, t) {
      if (15e4 < +e[5].replace(/[\$,]/g, "")) {
        $("td", a).eq(5).addClass("text-danger");
      }
    },
  });

  // DataTable com armazenamento de estado
  $("#state-saving-datatable").DataTable({
    stateSave: true,
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });

  // DataTable com cabeçalho fixo
  $("#fixed-header-datatable").DataTable({ fixedHeader: true });

  // DataTable com colunas fixas e rolagem
  $("#fixed-columns-datatable").DataTable({
    scrollY: 300,
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: true,
  });

  // Ajustes na exibição das opções de length
  $(".dataTables_length select").addClass("form-select form-select-sm");
  $(".dataTables_length label").addClass("form-label");

  // Adiciona delay antes de imprimir para garantir o carregamento das imagens
  $(document).on("click", ".btn-print", function () {
    setTimeout(function () {
      window.print(); // Imprime a tabela após o delay
    }, 1000); // Espera 1 segundo para garantir o carregamento completo das imagens
  });
});
