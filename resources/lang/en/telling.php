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
                    'title' => 'Version History'
                ],
                'caption' => [
                    'edit_by' => 'Edited By',
                    'on_date' => 'Edited on date',
                    'reason'  => 'Reason of editing',
                    'diff'    => 'Difference',
                    'action'  => 'Action'
                ],
                'button' => [
                    'label' => [
                        'revert' => 'Revert to this version'
                    ]
                ]
            ],
            'select' => [
                'button' => [
                    'label' => [
                        'show_version' => 'Show this Version'
                    ]
                ]
            ],
            'diff' => [
                'modal' => [
                    'title' => 'Difference between version of :version_date and current version',
                    'button' => [
                        'label' => [
                            'action' => 'Action',
                            'close' => 'Close',
                            'revert' => 'Revert to this version'
                        ]
                    ],
                    'label' => [
                        'current_version' => 'Current Version'
                    ]

                ]
            ]
        ]
    ];


