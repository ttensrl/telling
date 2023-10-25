<?php
/**
 * Created by PhpStorm.
 * Filename: ShowStoryTelling.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 30/12/21
 * Time: 17:41
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
namespace TtenSrl\Telling\Http\Livewire;

use TtenSrl\Telling\Classes\HistoricizedFields;
use Livewire\Component;

class ShowStoryTelling extends Component
{
    /**
     * Elenco delle modifiche
     *
     * @var null
     */
    private $histories = null;

    /**
     * Oggeto Corrente
     *
     * @var null
     */
    private $current = null;

    /**
     * Elencpo dei camppi da vedere nello storico
     *
     * @var array
     */
    public $listOfField = [];

    /**
     * Teplate da Visualizzare
     *
     * @var string
     */
    public $template = 'table';

    /**
     * Versione selezionata
     *
     * @var null
     */
    public $selected_version_id = null;

    /**
     * Oggetto sottoposto a versionamento
     *
     * @var HistoricizedFields
     */
    public HistoricizedFields $historiesOf;

    /**
     * @param  HistoricizedFields  $historiesOf
     *
     * @return void
     */
    public function mount(HistoricizedFields $historiesOf)
    {
        $this->historiesOf = $historiesOf;
    }

    /**
     * Caricamento dati
     *
     * @return void
     */
    public function loadData()
    {
        $this->current = $this->historiesOf->currentVersion();
        $this->histories = $this->historiesOf->versions()->orderBy('created_at', 'DESC');
        $this->listOfField = $this->historiesOf->getFieldsToDisplay();
        if(config('bricks-telling.support_spatie_translatable')) {
            $this->translatedField = $this->historiesOf->translatable ?? [];
        }
    }

    /**
     * Render della vista Livewire
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->loadData();
        if($this->template == 'table')
        {
            $histories_table = $this->histories->paginate();
        }
        else {
            $histories_table = $this->histories->get();
            $histories_table->shift();
        }
        return view('bricks-telling::livewire.show-story-telling-'.$this->template, ['histories_table' => $histories_table, 'current' => $this->current ]);
    }
}
