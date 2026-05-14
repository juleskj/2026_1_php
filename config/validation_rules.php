
<?php
return [
    'property' => [
        'zip_code' => [
        'type' => 'string', 
        'min' => 4,
        'max' => 4,
        'pattern' => '/^\d{4}$/',
        'required' => true,
    ],
        'city_name' => [
            'type' => 'string',
            'min' => 2,
            'max' => 50,
            'pattern' => '/^[a-zA-Z\s\-]+$/', // Only letters, spaces, and hyphens
            'required' => true,
        ],
        'house_number' => [
            'type' => 'string',
            'min' => 1,
            'max' => 10,
            'pattern' => '/^[a-zA-Z0-9\s\-]+$/', // Alphanumeric, spaces, and hyphens
            'required' => true,
        ],
        'type' => [
            'type' => 'string',
            'min' => 3,
            'max' => 20,
            'pattern' => '/^[a-zA-Z\s]+$/',
            'required' => true,
        ],
        'price' => [
            'type' => 'float',
            'min' => 0,
            'max' => null, // No max
            'required' => true,
        ],
        'lat' => [
            'type' => 'float',
            'min' => -90,
            'max' => 90,
            'required' => true,
        ],
        'lon' => [
            'type' => 'float',
            'min' => -180,
            'max' => 180,
            'required' => true,
        ],
        
        'energy_label' => [
            'type' => 'string',
            'min' => 1,
            'max' => 1,
            'pattern' => '/^[A-G]$/', // A, B, C, D, E, F, or G
            'required' => false,
        ],
        'monthly_expenses' => [
            'type' => 'float',
            'min' => 0,
            'max' => null,
            'required' => false,
        ],
        'lot_square_meters' => [
            'type' => 'float',
            'min' => 0,
            'max' => null,
            'required' => true,
        ],
        'floor_square_meters' => [
            'type' => 'float',
            'min' => 0,
            'max' => null,
            'required' => false,
        ],
        'road_name' => [
            'type' => 'string',
            'min' => 2,
            'max' => 50,
            'pattern' => '/^[a-zA-Z\s\-]+$/',
            'required' => true,
        ],
        'number_of_rooms' => [
            'type' => 'int',
            'min' => 1,
            'max' => 20,
            'required' => true,
            ],
        'price_per_meter' => [
            'type' => 'float',
            'min' => 0,
            'max' => null,
            'required' => true,
            ],
        'number_of_baths' => [
            'type' => 'int',
            'min' => 1,
            'max' => 10,
            'required' => true,
        ],
        'year_build' => [
            'type' => 'int',
            'min' => 1800,
            'max' => date('Y'), // Current year
            'required' => true,
        ],
        'main_image_alt' => [
            'type' => 'string',
            'min' => 5,
            'max' => 100,
            'required' => false,
        ],
        'main_image_path' => [
            'type' => 'string',
            'min' => 5,
            'max' => 255,
            'required' => false,
        ],
        'floor_plan_path' => [
            'type' => 'string',
            'min' => 5,
            'max' => 255,
            'required' => false,
        ],
    ]
];