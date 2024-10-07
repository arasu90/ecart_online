<?php

return [
    'deliverystatus' => [
        1 => ['name'=>'Yet to Deliver','color'=>'badge-secondary'],
        2 => 'Out for Delivery',
        3 => 'Delivered',
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'orderstatus' => [
        1 => ['name'=>'Yet to Order','color'=>'badge-secondary'],
        0 => ['name'=>'InActive','color'=>'badge-danger'],
    ],
    'paymentstatus' => [
        1 => ['name'=>'Pending','color'=>'badge-secondary'],
        2 => ['name'=>'Success','color'=>'badge-primary'],
        3 => 'Ordered',
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
