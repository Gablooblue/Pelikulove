<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    
    public $timestamps = true;
    public $incrementing = true;
   
    protected $fillable = [
        'period', 'sales', 'orders', 'net_amount', 'net_servicefee', 'paid', 'created_at',
    ];
    
    
    public static function saveInvoice($data) {
        $invoice  = new Invoice;
        $invoice->period = $data['period'];
        $invoice->sales = $data['sales'];
         $invoice->orders = $data['orders'];
        $invoice->net_amount = $data['net_amount'];
        $invoice->net_servicefee = $data['net_servicefee'];
        $invoice->paid = 0;
        $invoice->save();
        return $invoice->id;
     } 
    
    public static function updateInvoice($data) {
    
        $invoice = Invoice::find($data['invoice_id']); 
        
        $invoice->period = $data['period'];
        $invoice->sales = $data['sales'];
        $invoice->orders = $data['orders'];
        $invoice->net_amount = $data['net_amount'];
        $invoice->net_servicefee = $data['net_servicefee'];
        $invoice->paid = $data['paid'];
        $invoice->save();
        return $invoice->id;
    } 

	
}
