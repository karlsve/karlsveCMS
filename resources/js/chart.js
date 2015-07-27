var chartJS = {
    init: function () {
        $('table.table').each(this.chart);
    },
    chart: function (i, object) {
        var table = $(object);
        var chart = $('<canvas class="chart"></canvas>');
        var axis = [];
        table.find('thead>tr>th').each(function () {
            axis.push($(this).html());
        });
        var rows = [];
        table.find('tbody>tr').each(function () {
            var columns = [];
            $(this).find('td').each(function () {
                columns.push($(this).html());
            });
            rows.push(columns);
        });
        if (rows.length > 0) {
            table.after(chart);
            var context = chart.get(0).getContext("2d");
            var offset = 20;
            var bar_width = 20;
            context.save();
            context.font = "10px 'arial'";
            context.fillStyle = "#000";
            for(i=0; i<rows.length; i++) {
                context.fillText(rows[i][0], (i*bar_width + i*offset), 120);
            }
            context.restore();
        }
    }
};

$(document).ready(function () {
    //chartJS.init();
});