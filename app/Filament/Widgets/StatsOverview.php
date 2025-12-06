<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Toplam İçerik', Article::count())
                ->description('Sitedeki toplam yazı sayısı')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Toplam Görüntülenme', Article::sum('views'))
                ->description('Tüm yazıların toplam okunma sayısı')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('info'),
            Stat::make('Kayıtlı Kullanıcı', User::count())
                ->description('Sisteme kayıtlı kullanıcı sayısı')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
