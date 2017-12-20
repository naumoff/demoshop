<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusPatch extends FormRequest
{
    protected $redirect;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $orderStatus = config('lists.order_status');
        foreach ($orderStatus AS $statusItem){
            $orderStatusList[] = $statusItem['en'];
        }

        $orderStatuses = implode(',', $orderStatusList);

        $invoiceStatus = config('lists.invoice_status');
        foreach ($invoiceStatus AS $statusItem){
            $invoiceStatusList[] = $statusItem['en'];
        }
        $invoiceStatuses = implode(',',$invoiceStatusList);

        return [
            'order_id'=>'required|exists:orders,id',
            'order_status'=>'required|in:'.$orderStatuses,
            'delivery_track_number'=>'nullable',
            'invoice_status'=>'required|in:'.$invoiceStatuses
        ];
    }

    public function withValidator($validator)
    {
        $orderId = $this->request->all()['order_id'];

        if($validator->fails()){
            $this->redirect = '/admin/sales/orders/'.$orderId.'/edit?tab=status';
        }
    }
}
