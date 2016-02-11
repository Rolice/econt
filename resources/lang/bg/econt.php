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
        'sender.settlement' => 'Населено място на изпращач',
        'sender.pickup' => 'Изпращачът ще вземе от място',
        'sender.street' => 'Улица',
        'sender.street_num' => 'Номер на улицата',
        'sender.street_vh' => 'Вход',
        'sender.office' => 'Офис',

        'receiver.name' => 'Име на получател',
        'receiver.phone' => 'Телефон на получател',
        'receiver.settlement' => 'Населено място на получател',
        'receiver.pickup' => 'Получателят ще вземе от място',
        'receiver.street' => 'Улица',
        'receiver.office' => 'Офис',

        'shipment.num' => 'Номер на пратката',
        'shipment.type' => 'Тип на пратката',
        'shipment.description' => 'Тук се избира типа на пратката.',
        'shipment.count' => 'Брой пакети',
        'shipment.weight' => 'Тегло на пратката',

        'courier.date' => 'Дата',
        'courier.time_from' => 'от',
        'courier.time_to' => 'до',
    ],
];