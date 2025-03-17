<?php
namespace App;

class CommonClass
{
    public $country=['USA','Japan','Italy'];
    private $statusName;
    private $className;
    
    use CommonFunction;
    
    public function getOrderStatus($orderid)
    {
        switch ($orderid) {
            case 1:
                $this->statusName = "Order Confirmed";
                $this->className = "badge-primary";
                break;
            case 2:
                $this->statusName = "Payment Success";
                $this->className = "badge-info";
                break;
            case 3:
                $this->statusName = "Yet to Shipping";
                $this->className = "badge-primary";
                break;
            case 4:
                $this->statusName = "Item Dispatched";
                $this->className = "badge-info";
                break;
            case 5:
                $this->statusName = "Out for Delivery";
                $this->className = "badge-warning";
                break;
            case 6:
                $this->statusName = "Item Delivered";
                $this->className = "badge-success";
                break;
            case 7:
                $this->statusName = "Order Cancelled";
                $this->className = "badge-danger";
                break;
            default:
                $this->statusName = "Pending";
                $this->className = "badge-default";
                break;
          }

        return '<span class="badge '.$this->className.' rounded-lg">'.$this->statusName.'</span>';
    }

    public function getStatus($orderid)
    {
        $this->statusName = "InActive";
        $this->className = "badge-danger";
        if($orderid == 1){
            $this->statusName = "Active";
                $this->className = "badge-success";
        }
        return '<span class="badge '.$this->className.'">'.$this->statusName.'</span>';
    }
}
