<?php

return [
    'settlement' => [
        'type' => [
            'city' => 'City',
            'village' => 'vlg.',
        ],
    ],
    'attributes' => [
        'sender' => [
            'name' => 'Sender name',
            'phone' => 'Sender phone',
            'settlement' => 'Sender settlement',
            'pickup' => 'The sender will pick up from',
            'street' => 'Street',
            'street_num' => 'Street Number',
            'street_vh' => 'Entrance',
            'office' => 'Office',
        ],

        'receiver' => [
            'name' => 'Receiver name',
            'phone' => 'Receiver phone',
            'settlement' => 'Receiver settlement',
            'pickup' => 'The receiver will pick it up from',
            'street' => 'Street',
            'office' => 'Office',
        ],

        'shipment' => [
            'num' => 'Shipment number',
            'type' => 'Type of shipment',
            'description' => 'Choose the type of the shipment',
            'count' => 'Package quantity',
            'weight' => 'Weight of shipment',
        ],

        'courier' => [
            'date' => 'Data',
            'time_from' => 'From',
            'time_to' => 'To',
        ],
    ],
];