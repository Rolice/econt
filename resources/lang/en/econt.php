<?php

return [
    'settlement' => [
        'type' => [
            'city' => 'City',
            'village' => 'vlg.',
        ],
    ],
    'attributes' => [
        'sender.name' => 'Sender name',
        'sender.phone' => 'Sender phone',
        'sender.settlement' => 'Sender settlement',
        'sender.pickup' => 'The sender will pick up from',
        'sender.street' => 'Street',
        'sender.street_num' => 'Street Number',
        'sender.street_vh' => 'Entrance',
        'sender.office' => 'Office',

        'receiver.name' => 'Receiver name',
        'receiver.phone' => 'Receiver phone',
        'receiver.settlement' => 'Receiver settlement',
        'receiver.pickup' => 'The receiver will pick it up from',
        'receiver.street' => 'Street',
        'receiver.office' => 'Office',

        'shipment.num' => 'Shipment number',
        'shipment.type' => 'Type of shipment',
        'shipment.description' => 'Choose the type of the shipment',
        'shipment.count' => 'Packаge quantity',
        'shipment.weight' => 'Weight of shipment',

        'courier.date' => 'Data',
        'courier.time_from' => 'From',
        'courier.time_to' => 'To',
    ],
];