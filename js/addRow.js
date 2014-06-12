// JavaScript Document

var rowCount = document.getElementById('oTable').rows.length - 1 ;
var rowArrayId = rowCount ;

function addRow(){
var toBeAdded = document.getElementById('toBeAdded').value;
if (toBeAdded=='')
    { toBeAdded = 2; }
else if(toBeAdded>10)
{
  toBeAdded = 10;
}

  for (var i = 0; i < toBeAdded; i++) {
    var rowToInsert = '';
    rowToInsert = "<tr><td><input id='itemId"+rowArrayId+"' name='product["+rowArrayId+"][name]' class='form-control col-lg-5 itemSearch' type='text' placeholder='select item' /></td>";
    $("#tblItemList tbody").append(
        rowToInsert+
        "<td><textarea readonly name='product["+rowArrayId+"][description]' class='form-control description' rows='1' ></textarea></td>"+
        "<input type='hidden' name='product[" + rowArrayId + "][itemId]' id='itemId'>"+
        "<td><input type='number' min='1' max='9999' name='product["+rowArrayId+"][quantity]' class='qty form-control' required />"+
        "<input id='poItemId' type='hidden' name='product[" + rowArrayId + "][poContentId]'></td>"+
        "<td><input type='number' min='1' step='any' max='9999' name='product["+rowArrayId+"][price]' class='price form-control' required /></td>"+
        "<td class='subtotal'><center><h3>0.00</h3></center></td>"+
        "<input type='hidden' name='product["+rowArrayId+"][delete]' class='hidden-deleted-id'>"+
        "<td class='actions'><a href='#' class='btnRemoveRow btn btn-danger'>x</a></td>"+
        "</tr>");

var rowId = "#itemId"+rowArrayId;

$(rowId).select2({
    placeholder: 'Select an account',
    formatResult: productFormatResult,
    formatSelection: productFormatSelection,
    dropdownClass: 'bigdrop',
    escapeMarkup: function(m) { return m; },
    minimumInputLength:1,
    ajax: {
        url: '/api/productSearch',
        dataType: 'json',
        data: function(term, page) {
            return {
                q: term
            };  
        },  
        results: function(data, page) {
            return {results:data};
        }   
    }   
});

rowArrayId = rowArrayId + 1;
     };

$(".select2-drop").append('<table width="100%"><tr><td class="row"><button class="btn btn-block btn-default btn-xs" onClick="modal()">Add new Item</button></div></td></tr></table>');



function productFormatResult(product) {
var html = "<table><tr>";
html += "<td>";
html += product.itemName ;
html += "</td></tr></table>";
return html;
}

function productFormatSelection(product) {
var selected = "<input type='hidden' name='itemId' value='"+product.id+"'/>";
return selected + product.itemName;
}
    $(".qty, .price").bind("keyup change", calculate);
};