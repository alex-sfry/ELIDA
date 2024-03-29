export function Table(cnt) {
    this.cnt = cnt;
}

Table.prototype.getRows = function() {
    return $(`#${this.cnt} tbody tr`);
};

Table.prototype.fillTable = function(data) {
    this.getRows().each(function(rowIndex) {
        if (!data[rowIndex]) {
            $(this).remove();
            return;
        }

        $(this).find('td').each(function (cellIndex) {
            cellIndex === 0 && $(this).text(data[rowIndex].commodity);
            cellIndex === 1 && $(this).text(data[rowIndex].station);
            cellIndex === 2 && $(this).text(data[rowIndex].type);
            if (cellIndex === 2 && data[rowIndex].surface) {
                $(this).addClass('text-success');
                $(this).removeClass('text-primary');
            } else if (cellIndex === 2) {
                $(this).addClass('text-primary');
                $(this).removeClass('text-success');
            }
            cellIndex === 3 && $(this).text(data[rowIndex].pad);
            cellIndex === 4 && $(this).text(data[rowIndex].system);
            cellIndex === 5 && $(this).text(data[rowIndex].distance_ly);
            cellIndex === 6 && $(this).text(data[rowIndex].distance_ls);
            cellIndex === 7 && $(this).text(data[rowIndex].demand);
            cellIndex === 8 && $(this).text(data[rowIndex].sell_price || data[rowIndex].buy_price);
            cellIndex === 9 && $(this).text(data[rowIndex].time_diff);
        });
    });
};