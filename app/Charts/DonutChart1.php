<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class DonutChart1
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->donutChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData([20, 24, 30])
            ->setLabels(['Player 7', 'Player 10', 'Player 9'])
            ->toVue();
    }
}
