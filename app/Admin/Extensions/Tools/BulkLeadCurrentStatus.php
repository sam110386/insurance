<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class BulkLeadCurrentStatus extends BatchAction
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
    $('#current_status').select2({ width: '100%' });
    var  ids =  selectedRows();
    if(ids.length){    
        $("#change_status #lead_ids").val(ids); 
        $("#change_status").modal("show");
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