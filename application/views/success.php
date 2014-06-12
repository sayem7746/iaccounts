<script type="text/javascript">
$(document).ready(function() {
	$(function(){
    $("#row_edit").dialog({
        autoOpen: true,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
                $(this).dialog("close");
            }
        }
    });    
	});
		
});
</script>
<div class="dialog" id="row_edit" style="display: none;" title="New Data">
                        <div class="info">
                            <h1>Success</h1>
                            <ul class="breadcrumb">
                                <li><a href="#">Home</a> <span class="divider">-</span></li>
                                <li><a href="#">One more</a> <span class="divider">-</span></li>
                                <li class="active">Success</li>
                            </ul>
                        </div>
    <p>New Data Created ..</p>
</div>   
