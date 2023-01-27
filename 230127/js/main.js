(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Progress Bar
//    $('.pg-bar').waypoint(function () {
//        $('.progress .progress-bar').each(function () {
//            $(this).css("width", $(this).attr("aria-valuenow") + '%');
//        });
//    }, {offset: '80%'});


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav : false
    });

    $.ajax({
        type: "get",
        url: "../php/read.php",
        dataType:"json",
        success: function (data) {
            
	    // console.log(typeof(data))
            let aData = Object.values(data[0])
            let cData = Object.values(data[1])
	
            let YearA = new Array()
            let WearingA = new Array()
            let ReleaseA = new Array()
            let StockA = new Array()
            let ReturnA = new Array()

            aData.map((element)=>{
                YearA.push(element.enc_Year)
                WearingA.push(element.enc_Wearing)
                ReleaseA.push(element.enc_Release)
                StockA.push(element.enc_Stock)
                ReturnA.push(element.enc_Return)
            })
            
            // Worldwide Sales Chart
            var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
            var myChart1 = new Chart(ctx1, {
                type: "bar",
                data: {
                    labels: YearA,
                    datasets: [{
                            label: "입고",
                            data: WearingA,
                            backgroundColor: "rgba(0, 156, 255, .7)"
                        },
                        {
                            label: "출고",
                            data: ReleaseA,
                            backgroundColor: "rgba(0, 156, 255, .5)"
                        },
                        {
                            label: "재고",
                            data: StockA,
                            backgroundColor: "rgba(0, 156, 255, .3)"
                        }
                    ]
                    },
                options: {
                    responsive: true
                }
            });


            // Salse & Revenue Chart
            var ctx2 = $("#salse-revenue").get(0).getContext("2d");
            var myChart2 = new Chart(ctx2, {
                type: "line",
                data: {
                    labels: YearA,
                    datasets: [{
                            label: "출고",
                            data: StockA,
                            backgroundColor: "rgba(0, 156, 255, .5)",
                            fill: true
                        },
                        {
                            label: "재고",
                            data: ReturnA,
                            backgroundColor: "rgba(0, 156, 255, .3)",
                            fill: true
                        }
                    ]
                    },
                options: {
                    responsive: true
                }
            });
    
        }
    });


    $.ajax({
        type: "get",
        url: "../php/rm_read.php",
        dataType: "json",
        success: function(data) {

            var aData = Object.values(data[0])
            var eData = Object.values(data[1])

            var SumData = new Array()
            var MonthData = new Array()

            aData.map((e)=>{
                SumData.push(e.총입고수량)
                MonthData.push(e.월별입고량)
            })
            
            var barLineCtx = $("#bar-line").get(0).getContext("2d")
            var myBarLineCtx = new Chart(barLineCtx, {
                type: "line",
                data: {
                    labels: MonthData,
                    datasets: [
                        {
                            label: "월별입고량",
                            data: SumData,
                            backgroundColor: "rgba(0, 156, 255, .5)",
                        },
                        {
                            label: "SKU",
                            data: [30, 40, 50, 60, 30],
                            backgroundColor: "rgba(0, 156, 255, .5)",
                            type: "bar"
                        }

                    ]
                },
                options: {
                    responsive: true
                }
            })

            var stackedbarCtx = $("#stacked-bar").get(0).getContext("2d")
            var myStackedBarCtx = new Chart(stackedbarCtx, {
                type: "bar",
                data : {
                    labels: [ 'BOX', 'SKU' ],
                    datasets: [
                        {
                            label: "상온",
                            backgroundColor: "rgba(0, 128, 0, .5)",
                            data: [eData[0].상온, 100]
                        },
                        {
                            label: "냉장",
                            backgroundColor: "rgba(0, 156, 244, .5)",
                            data: [eData[1].냉장, 200]
                        },
                        {
                            label: "냉동",
                            backgroundColor: "rgba(8, 3, 255, .5)",
                            data: [eData[2].냉동, 300]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked:true,
                        },
                        y: {
                            stacked:true,
                        }
                    }
                }
            })

            var horizontalBarCtx = $("#horizontal-bar").get(0).getContext("2d")
            var myHorizontalBarCtx = new Chart(horizontalBarCtx, {
                type: "bar",
                data: {
                    labels: MonthData,
                    datasets: [
                        {
                            label: "월별입고량",
                            data: SumData,
                            backgroundColor: "rgba(0, 156, 255, .5)",
                        }
                    ]
                },
                options: {
                    indexAxis: 'y'
                }

            })
        }
    })

    // Single Line Chart
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "line",
        data: {
            labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(0, 156, 255, .3)",
                data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Single Bar Chart
    var ctx4 = $("#bar-chart").get(0).getContext("2d");
    var myChart4 = new Chart(ctx4, {
        type: "bar",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Pie Chart
    var ctx5 = $("#pie-chart").get(0).getContext("2d");
    var myChart5 = new Chart(ctx5, {
        type: "pie",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Doughnut Chart
    var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
    var myChart6 = new Chart(ctx6, {
        type: "doughnut",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });

    
})(jQuery);

