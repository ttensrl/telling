<?php
/**
 * Created by PhpStorm.
 * Filename: telling.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 31/12/21
 * Time: 15:07
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
    'show' => [
        'table' => [
            'card' => [
                'title' => 'Storico Versioni'
            ],
            'caption' => [
                'edit_by' => 'Modificato da',
                'on_date' => 'Modificato il',
                'reasons'  => 'Motivi',
                'diff'    => 'Differenze',
                'actions'  => 'Azioni'
            ],
            'button' => [
                'label' => [
                    'revert' => 'Ritorna a questa Versione'
                    ]
            ]
        ],
        'select' => [
            'button' => [
                'label' => [
                    'show_version' => 'Visualizza Versione'
                ]
            ]
        ],
        'diff' => [
            'modal' => [
                'title' => 'Differenza tra la versione del :version_date e quella attuale',
                'button' => [
                    'label' => [
                        'action' => 'Azione',
                        'close' => 'Chiudi',
                        'revert' => 'Ritorna a questa Versione'
                    ]
                ],
                'label' => [
                    'current_version' => 'Versione Corrente'
                ]

            ]
        ]
    ]
];
