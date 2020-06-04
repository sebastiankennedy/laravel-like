<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Like Model
    |--------------------------------------------------------------------------
    |
    | This option sets the like model
    |
    */
    'model' => SebastianKennedy\LaravelLike\Like::class,
    /*
    |--------------------------------------------------------------------------
    | User Model Table Foreign Key
    |--------------------------------------------------------------------------
    |
    | This option controls the foreign key of the user table
    |
    */
    'foreign_key' => 'user_id',
    /*
    |--------------------------------------------------------------------------
    | Like Model Table Name
    |--------------------------------------------------------------------------
    |
    | This option controls the name of the data table corresponding to the like model
    |
    */
    'table_name' => 'likes',
    /*
    |----------------------------------------------------------------------
    | Like Model Relationship Field Name
    |--------------------------------------------------------------------------
    |
    | This option define a field name of polymorphic many-to-many relationship
    |
    */
    'morph_many_id' => 'likable_id',
    'morph_many_type' => 'likable_type',
    'morph_many_name' => 'likable',
];
