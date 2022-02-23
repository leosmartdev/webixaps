/*=========================================================================================
    File Name: app-user.js
    Description: User page JS
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {

  var isRtl;
  if ( $('html').attr('data-textdirection') == 'rtl' ) {
    isRtl = true;
  } else {
    isRtl = false;
  }

  //  Rendering badge in status column
  var customBadgeHTML = function (params) {
    var color = "";
    if (params.value == "active") {
      color = "success"
      return "<div class='badge badge-pill badge-light-" + color + "' >" + params.value + "</div>"
    } else if (params.value == "blocked") {
      color = "danger";
      return "<div class='badge badge-pill badge-light-" + color + "' >" + params.value + "</div>"
    } else if (params.value == "deactivated") {
      color = "warning";
      return "<div class='badge badge-pill badge-light-" + color + "' >" + params.value + "</div>"
    }
  }

  //  Rendering bullet in verified column
  var customBulletHTML = function (params) {
    var color = "";
    if (params.value == true) {
      color = "success"
      return "<div class='bullet bullet-sm bullet-" + color + "' >" + "</div>"
    } else if (params.value == false) {
      color = "secondary";
      return "<div class='bullet bullet-sm bullet-" + color + "' >" + "</div>"
    }
  }

  // Renering Icons in Actions column
  var customIconsHTML = function (params) {
    var usersIcons = document.createElement("span");
    var editIconHTML = "<a href='/admin/feed_subcategories/"+ params.data.id +"/edit'><i class='users-edit-icon feather icon-edit-1 mr-50'></i></a>";
    var deleteIconHTML = document.createElement('i');
    var attr = document.createAttribute("class")
    attr.value = "users-delete-icon feather icon-trash-2"
    deleteIconHTML.setAttributeNode(attr);
    // selected row delete functionality
    deleteIconHTML.addEventListener("click", function () {
      deleteArr = [
        params.data
      ];
      if (confirm("Are you sure you want to delete " + params.data.feed_subcategory_name + "?")) {
        $.ajax({
          url: "/admin/feed_subcategories/" + params.data.id,
          type: "DELETE",
          cache: false,
          data:{
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
              // $ele.fadeOut().remove();
              gridOptions.api.updateRowData({
                remove: deleteArr
              });
            }
          }
        });
      }
    });
    usersIcons.appendChild($.parseHTML(editIconHTML)[0]);
    usersIcons.appendChild(deleteIconHTML);
    return usersIcons
  }

  //  Rendering avatar in username column
  var customAvatarHTML = function (params) {
    return "<span class='avatar'><img src='/storage/avatars/" + params.value + "' height='32' width='32'></span>";
  }


  // ag-grid
  /*** COLUMN DEFINE ***/

  var columnDefs = [{
      headerName: 'ID',
      field: 'id',
      filter: true,
      checkboxSelection: true,
      headerCheckboxSelectionFilteredOnly: true,
      headerCheckboxSelection: true,
    },
    {
      headerName: 'Feed Subcategory Name',
      field: 'feed_subcategory_name',
      filter: true
    },
    {
      headerName: 'Country Name',
      field: 'country_name',
      filter: true
    },
    {
      headerName: 'Feed Category',
      field: 'feed_category_name',
      filter: true
    },
    {
      headerName: 'Actions',
      field: 'transactions',
      cellRenderer: customIconsHTML,
    }
  ];

  /*** GRID OPTIONS ***/
  var gridOptions = {
    defaultColDef: {
      sortable: true,
      resizable: true,
      filter: true,
      sizeColumnsToFit: true
    },
    enableRtl: isRtl,
    columnDefs: columnDefs,
    rowSelection: "multiple",
    floatingFilter: true,
    pagination: true,
    paginationPageSize: 20,
    pivotPanelShow: "always",
    colResizeDefault: "shift",
    animateRows: true,
    onColumnResized: true
  };
  if (document.getElementById("myGrid")) {
    /*** DEFINED TABLE VARIABLE ***/
    var gridTable = document.getElementById("myGrid");

    /*** GET TABLE DATA FROM URL ***/
    agGrid
      .simpleHttpRequest({
        url: "/admin/feed_subcategories/feed_subcategory_ajax_list"
      })
      .then(function (data) {
        gridOptions.api.setRowData(data);
      });

    /*** FILTER TABLE ***/
    function updateSearchQuery(val) {
      gridOptions.api.setQuickFilter(val);
    }

    $(".ag-grid-filter").on("keyup", function () {
      updateSearchQuery($(this).val());
    });

    /*** CHANGE DATA PER PAGE ***/
    function changePageSize(value) {
      gridOptions.api.paginationSetPageSize(Number(value));
    }

    $(".sort-dropdown .dropdown-item").on("click", function () {
      var $this = $(this);
      changePageSize($this.text());
      $(".filter-btn").text("1 - " + $this.text() + " of 50");
    });

    /*** EXPORT AS CSV BTN ***/
    $(".ag-grid-export-btn").on("click", function (params) {
      var params = {
          columnKeys: ['id', 'feed_subcategory_name','feed_category_name', 'country_code'],
          fileName: 'webix_feed_categories.csv'
      };
      gridOptions.api.exportDataAsCsv(params);
    });

    $(".ag-grid-print-btn").on("click", function (params) {
      var params = {
          columnKeys: ['id', 'feed_subcategory_name','feed_category_name', 'country_code']
      };
      gridOptions.api.setDomLayout("print");
    });

    //  filter data function
    var filterData = function agSetColumnFilter(column, val) {
      var filter = gridOptions.api.getFilterInstance(column)
      var modelObj = null
      if (val !== "all") {
        modelObj = {
          type: "equals",
          filter: val
        }
      }
      filter.setModel(modelObj)
      gridOptions.api.onFilterChanged()
    }
    /*** INIT TABLE ***/
    new agGrid.Grid(gridTable, gridOptions);
  }
  // users language select
  // Input, Select, Textarea validations except submit button validation initialization
  if ($(".users-edit").length > 0) {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  }
});
