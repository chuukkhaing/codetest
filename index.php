<?php

/**
 * Please, improve this class and fix all problems.
 *
 * You can change the Tenant class and its methods and properties as you want.
 * You can't change the AccountingService behavior.
 * You can choose PHP 7 or 8.
 * You can consider this class as an Eloquent model, so you are free to use
 * any Laravel methods and helpers.
 *
 * What is important:
 * - design (extensibility, testability)
 * - code cleanliness, following best practices
 * - consistency
 * - naming
 * - formatting
 *
 * Write your perfect code!
 */

namespace App\Models;
use App\Services\AccountingService;

class Tenant extends Model{

    protected $accountingService;

    function __construct(){
        $this->accountingService = new AccountingService();
    }

    public function get_invoices()
    {
        $params = [
            'tenant_id' => $this->id
        ];
        $invoices = $this->accountingService->getAllInvoices($params);
        $ap_invoices = [];
        if (isset($invoices))
        {
            // Loop through all invoices and choose only ones that await payment
            foreach ($invoices as $i)
            {
                if ($i['status'] == 'awaiting-payment')
                    $ap_invoices[] = $i;
            }
            return $ap_invoices;
        }

        return null;
    }

    public function get_old_invoices()
    {
        $params = [
            'tenant_id' => $this->id
        ];
        $invoices = $this->accountingService->getAllInvoices($params);

        if (isset($invoices)) {
            $paid_invoices = [];

            // Loop through all invoices and choose only paid ones
            foreach ($invoices as $i)
            {
                if ($i['status'] == 'paid') {
                    $paid_invoices[] = $i;
                }
            }

            return $paid_invoices;
        }
    }

    // ...
}