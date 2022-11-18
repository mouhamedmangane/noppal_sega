<?php

namespace Npl\Brique\View\Components\Charts;

use Illuminate\View\Component;

class Chart extends Component
{
    public $id,$label,$labels,$datas,$xAxisKey,$yAxisKey,$type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $type,$id, $labels, $datas,$label="", $xAxisKey='', $yAxisKey='')
    {
        $this->id=$id;
        $this->type=$type;
        $this->label=$label;
        $this->labels=$labels;
        $this->datas=$datas;
        $this->xAxisKey=$xAxisKey;
        $this->yAxisKey=$yAxisKey;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.charts.chart');
    }
}
