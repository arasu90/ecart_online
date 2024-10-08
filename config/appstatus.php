<?php

return [
    'deliverystatus' => [
        1 => ['name'=>'Yet to Deliver','color'=>'badge-secondary'],
        2 => 'Out for Delivery',
        3 => 'Delivered',
        4 => ['name'=>'Payment Failed','color'=>'badge-danger'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'orderstatus' => [
        1 => ['name'=>'Pending Order','color'=>'badge-secondary'],
        2 => ['name'=>'Order Confirmation','color'=>'badge-primary'],
        3 => ['name'=>'Order Confirmed','color'=>'badge-warning'],
        4 => ['name'=>'Payment Failed','color'=>'badge-danger'],
        5 => ['name'=>'Order Cancelled','color'=>'badge-danger'],
        6 => ['name'=>'Create Order Failed','color'=>'badge-danger'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'paymentstatus' => [
        1 => ['name'=>'Pending','color'=>'badge-secondary'],
        2 => ['name'=>'Payment Initiate','color'=>'badge-primary'],
        3 => ['name'=>'Payment Success','color'=>'badge-secondary'],
        4 => ['name'=>'Payment Failed','color'=>'badge-danger'],
        5 => ['name'=>'Payment Failed','color'=>'badge-danger'],
        6 => ['name'=>'Create Order Failed','color'=>'badge-danger'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'userstatus' => [
        1 => ['name'=>'Active','color'=>'badge-secondary'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'brandstatus' => [
        1 => ['name'=>'Active','color'=>'badge-secondary'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'categorystatus' => [
        1 => ['name'=>'Active','color'=>'badge-secondary'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'productstatus' => [
        1 => ['name'=>'Active','color'=>'badge-secondary'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ]
];
