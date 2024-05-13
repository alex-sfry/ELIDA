<?php

namespace app\widgets\Table;

use yii\base\Widget;
use yii\helpers\VarDumper;

class Table extends Widget
{
    public string $container = '';
    public array $model = [];
    public array $columns = [];
    public string $default_sorting = 'desc';

    public function init(): void
    {
        TableAsset::register($this->getView());
        parent::init();
    }

    public function run(): string
    {
        $filtered_columns = $this->getFiltersQty();

        return $this->render(
            'index',
            [
                'container' => $this->container,
                'model' => $this->model,
                'columns' => $this->columns,
                'column_labels' => $this->getColumnLabels(),
                'column_filters' => $this->getFilter(),
                'default_sorting' => $this->default_sorting,
                'filtered_columns' => $filtered_columns,
                'styles' => $this->getStyles($filtered_columns)
            ]
        );
    }

    private function getColumnLabels(): array
    {
        $labels = [];

        foreach ($this->columns as $column) {
            $labels[] = isset($column['label']) ? $column['label'] : $column['attribute'];
        }

        return $labels;
    }

    private function getFilter(): array
    {
        $filters = [];

        foreach ($this->columns as $column) {
            if (!isset($column['filterInputOptions'])) {
                $filters[]['type'] = '';
                continue;
            }

            switch ($column['filterInputOptions']['class']) {
                case 'form-select':
                    $filters[] = [
                        'name' => isset($column['label']) ? $column['label'] : $column['attribute'],
                        'type' => 'dropDownList',
                        'option_items' => $column['filter']
                    ];
                    break;

                case 'form-control':
                    $filters[] = [
                        'name' => isset($column['label']) ? $column['label'] : $column['attribute'],
                        'type' => 'textInput'
                    ];
                    break;
            }
        }

        return $filters;
    }

    private function getFiltersQty(): array
    {
        $filtered_columns = [];

        foreach ($this->columns as $key => $value) {
            if (isset($value['filterInputOptions'])) {
                $filtered_columns[] = $key;
            };
        }

        return $filtered_columns;
    }

    private function getStyles($filtered_columns): string
    {
        $styles = '';

        foreach ($filtered_columns as $column) {
            $styles .= ".w-table .hiddden-c-$column {
                display: none;
            }";
        }

        return $styles;
    }
}
