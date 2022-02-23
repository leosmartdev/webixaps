/*=========================================================================================
    File Name: card-statistics.js
    Description: Card-statistics page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function(){


  $.get("/admin/statistics", {get_revenue: "true"} , function(data){
    // Display the returned data in browser
    $("#this-month").html(data.this_month);
    $("#this-week").html(data.this_week);
    $("#yesterday").html(data.yesterday);
    $("#today").html(data.today);
  });

  $.get("/admin/statistics", {get_revenue: "true", country_name: "Spain"} , function(data){
    // Display the returned data in browser
        $("#es-this-month").html(data.this_month);
        $("#es-this-week").html(data.this_week);
        $("#es-yesterday").html(data.yesterday);
        $("#es-today").html(data.today);
    });


    $.get("/admin/statistics", {get_revenue: "true", country_name: "Mexico"} , function(data){
    // Display the returned data in browser
        $("#mx-this-month").html(data.this_month);
        $("#mx-this-week").html(data.this_week);
        $("#mx-yesterday").html(data.yesterday);
        $("#mx-today").html(data.today);
    });

    $.get("/admin/statistics", {get_revenue: "true", country_name: "Sweden"} , function(data){
    // Display the returned data in browser
        $("#se-this-month").html(data.this_month);
        $("#se-this-week").html(data.this_week);
        $("#se-yesterday").html(data.yesterday);
        $("#se-today").html(data.today);
    });

    $.get("/admin/statistics", {get_revenue: "true", country_name: "Norway"} , function(data){
    // Display the returned data in browser
        $("#no-this-month").html(data.this_month);
        $("#no-this-week").html(data.this_week);
        $("#no-yesterday").html(data.yesterday);
        $("#no-today").html(data.today);
    });

    $.get("/admin/statistics", {get_revenue: "true", country_name: "United Kingdom"} , function(data){
    // Display the returned data in browser
        $("#uk-this-month").html(data.this_month);
        $("#uk-this-week").html(data.this_week);
        $("#uk-yesterday").html(data.yesterday);
        $("#uk-today").html(data.today);
    });

    $.get("/admin/statistics", {get_revenue: "true", country_name: "Finland"} , function(data){
    // Display the returned data in browser
        $("#fi-this-month").html(data.this_month);
        $("#fi-this-week").html(data.this_week);
        $("#fi-yesterday").html(data.yesterday);
        $("#fi-today").html(data.today);
    });

    $.get("/admin/statistics", {get_revenue: "true", country_name: "Poland"} , function(data){
    // Display the returned data in browser
        $("#pl-this-month").html(data.this_month);
        $("#pl-this-week").html(data.this_week);
        $("#pl-yesterday").html(data.yesterday);
        $("#pl-today").html(data.today);
    });

});
