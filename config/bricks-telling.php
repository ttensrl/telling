<?php
/**
 * Created by PhpStorm.
 * Filename: bricks-telling.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 30/12/21
 * Time: 17:55
 * MIT License
 *
 * Copyright (c) [2021] [laravel-bricks-bootstrap5]
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Abilita funzione di Ripristina
    |--------------------------------------------------------------------------
    |
    | Questa impostazione abilita o disabilita la possibilita di ripristinare una versione
    |
    |
    */
    'enable_revert_function' => false,

    /*
    |--------------------------------------------------------------------------
    | Permette il supporto di campi spatie translatable
    |--------------------------------------------------------------------------
    |
    | Questa impostazione permette di verificare se il campo sia un campo json
    | usato nella gestione delle lingue nel package Spatie
    |
    |
    */
    'support_spatie_translatable' => true,

    /*
    |--------------------------------------------------------------------------
    | Impostare il motivo di default
    |--------------------------------------------------------------------------
    |
    | Questa Impostazione aggiungere la motivazione di default della modifica
    | nel caso non sia possibile aggiungere una motivazione
    |
    |
    */
    'default_reason' => 'Modifica',

    /*
    |--------------------------------------------------------------------------
    | Permette un proprio modello per il versionamento
    |--------------------------------------------------------------------------
    |
    | Questa impostazione permette di settare un modello custom per il salvataggio delle versioni
    |
    |
    */
    'version_model' => \TtenSrl\Telling\Models\Version::class
];
