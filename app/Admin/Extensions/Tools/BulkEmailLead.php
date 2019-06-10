<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class BulkEmailLead extends BatchAction
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
    $('#admin_users').select2({ width: '100%' });
    var  ids =  selectedRows();
    $("#bulkMail #lead_ids").val(ids); 
    $("#bulkMail").modal("show");
});

EOT;

    }
}