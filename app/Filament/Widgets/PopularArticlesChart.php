<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class PopularArticlesChart extends ChartWidget
{
    protected ?string $heading = 'En Çok Okunan Yazılar';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $articles = Article::orderByDesc('views')->take(5)->get();

        return [
            'datasets' => [
                [
                    'label' => 'Görüntülenme',
                    'data' => $articles->pluck('views')->toArray(),
                    'backgroundColor' => ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6'],
                ],
            ],
            'labels' => $articles->pluck('title')->map(fn($title) => \Illuminate\Support\Str::limit($title, 20))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
