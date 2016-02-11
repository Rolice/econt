<?php

return [
    'settlement' => [
        'type' => [
            'city' => 'гр.',
            'village' => 'с.',
        ],
    ],

    'attributes' => [
        'sender.name' => 'Име на изпращач',
        'sender.phone' => 'Телефон на изпращач',
        'sender.settlement' => '',
        'sender.pickup' => '',
        'sender.street' => '',
        'sender.street_num' => '',
        'sender.street_vh' => '',
        'sender.office' => '',

        'receiver.name' => '',
        'receiver.phone' => '',
        'receiver.settlement' => '',
        'receiver.pickup' => '',
        'receiver.street' => '',
        'receiver.office' => '',

        'shipment.num' => '',
        'shipment.type' => '',
        'shipment.description' => '',
        'shipment.count' => '',
        'shipment.weight' => '',

        'courier.date' => '',
        'courier.time_from' => '',
        'courier.time_to' => '',
    ],
];