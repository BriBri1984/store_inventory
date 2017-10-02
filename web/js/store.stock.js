$(document).ready(function() {

    console.log('everything is loaded');

    // Tap into the form submit event
    $("#store-form").submit(function(event) {

        event.preventDefault();

        $("#report-container").html('<img src="/loading.gif"/>');

        var storeId = $("#store-selection").val();

        console.log('Form was submitted 2');
        console.log('store selected=' + storeId);

        var apiUrl = "/api/store-stock/" + storeId;

        $.ajax({
            url: apiUrl,
            dataType: 'json',
            success: function(data) {

                // create a variable to hold all the html for the table
                var reportHtml = '<div class="table-responsive">' +
                    '<table class="table-bordered table-striped">' +
                    '<thead>' +
                    '<tr>' +
                    '   <th>Stock Item Name</th><th>Date</th><th>Quantity</th><th>Price</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';


                var grandTotal = 0;
                // loop through the data
                for (var index in data) {

                    var item = data[index];

                    // create a row for each record in the report and add it to the variable
                    reportHtml += '<tr>';

                    reportHtml += '<td>';
                    reportHtml += item.stock.name;
                     reportHtml += '</td>';

                    reportHtml += '<td>';
                    reportHtml += item.date_given;
                    reportHtml += '</td>';

                    reportHtml += '<td>';
                    reportHtml += item.quantity;
                    reportHtml += '</td>';

                    reportHtml += '<td>';
                    reportHtml += '$' + item.price / 100;
                    reportHtml += '</td>';

                    reportHtml += '</tr>';

                    grandTotal += item.price;
                }

                    reportHtml += '<tr>';
                    reportHtml += '<td colspan="4" align="right">';
                    reportHtml += '$' + grandTotal / 100;
                    reportHtml += '</td>';
                    reportHtml += '</tr>';


                reportHtml += '</tbody></table></div>';

                // write the variable to the DOM
                $("#report-container").html(reportHtml);

            }
        });
    });


});