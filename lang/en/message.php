<?php

return[

    /*
    |--------------------------------------------------------------------------
    | CRUD MESSAGES
    |--------------------------------------------------------------------------
    |
    | all the crud based messages are metioned bellow
    |
    */
    'crud' => [
       'create' => ':module created successfully.',
       'update' => ':module updated successfully.',
       'delete' => ':module deleted successfully.',
       'duplicated' => ':module duplicated successfully.',
    ],

    /*
    |--------------------------------------------------------------------------
    | ERROR MESSAGES
    |--------------------------------------------------------------------------
    |
    | all the system Valiation and Exception messages are metioned bellow
    |
    */

    'error' => [
        'automation' => [
            'state_id' => 'Automation with similar state, carrier, or warehouse exist.',
            'is_default' => 'Default Automation with in the provided state already exist.',
            'is_priority' => 'Priority Automation with in the provided state already exist.',
            'cannot' => [
                'delete' => 'This automation can\'t be deleted. Remove status, priority or default'
            ]
        ],
        'adjustment' => [
            'delete'=> 'This inventory adjustment can\'t be deleted. its is merged in the inventory'
        ],
        'stock_transfers' => [
            'arrival_date' => 'Stock Transfer with similar arrival date, origin, or destination exist.',
        ],
        'warehouse' => [
            'cannot' => [
                'delete' => 'This warehouse can\'t be deleted. Remove status, default or related automation'
            ]
        ],
        'carrier' => [
            'cannot' => [
                'delete' => 'This carrier can\'t be deleted. Remove status, default or related automation'
            ]
        ],
        'shipping_rate' => [
            'cannot' => [
                'delete' => 'This Shipping rate can\'t be deleted. Remove active status or default'
            ]
            ],
        'courier' => [
            'cannot' => [
                'delete' => 'This courier can\'t be deleted. Remove carriers'
            ]
        ],
        'shipping_costs' => [
            'min_cost' => [
                'exist' => 'Minimum cost range already exist in one of the rule.',
                'greater' => 'Minimum cost should be lesser than the maximum cost.'
            ],
            'max_cost' => [
                'exist' => 'Maximum cost range already exist in one of the rule.',
                'lesser' => 'Maximum cost should be greater than the minimum cost.'
            ],
        ],


        'update permission' => 'Oops You dont have permission to update this permissions.',
        'cannot delete role' => 'Oops this role cannot be deleted, as this is associated with users.',
        'role' => [
            'cannot' => [
                'delete' => 'This role can\'t be deleted. Remove active users associated with this role first.'
            ]
            ],
        'update permission' => 'You don\'t have permission to update this permissions.',
        'supplier' => [
            'email_address' => 'This email address already exists',
            'cannot' => [
                'delete' => 'You can\'t delete this supplier as this is associated with a stock transfer.'
            ]
        ],
    ]
];
