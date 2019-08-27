<?php
namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class BulkLeadAssignment extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }
    
    public function script()
    {
        return <<<EOT
$('{$this->getElementClass()}').on('click', function() {
    $('#assign_to,#assign_id').select2({ width: '100%' });
    var  ids =  selectedRows();
    if(ids.length){
        $("#assignment #lead_ids").val(ids); 
        $("#assignment").modal("show");    
    }else{
        Swal.fire({
            text: 'Please select at least one record',
            type: 'warning',
            confirmButtonText: 'Close'
        });
    }
});

EOT;

    }
}