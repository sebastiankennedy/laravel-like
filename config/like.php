<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

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
    | Like Model Relationship Fields Name
    |--------------------------------------------------------------------------
    |
    | This option define fields name of polymorphic many-to-many relationship
    |
    */
    'morph_many_id' => 'likable_id',
    'morph_many_type' => 'likable_type',
    'morph_many_name' => 'likable',
];
