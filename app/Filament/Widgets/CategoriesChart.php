<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoriesChart extends ChartWidget
{
    protected ?string $heading = 'Kategori Dağılımı';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Get categories with article counts
        $data = Category::withCount('articles')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Yazı Sayısı',
                    'data' => $data->pluck('articles_count')->toArray(),
                    'backgroundColor' => [
                        '#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', 
                        '#ec4899', '#6366f1', '#14b8a6'
                    ],
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
