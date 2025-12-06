<?php

namespace App\Filament\Resources\SocialMedia\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;

class SocialMediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Platform Adı')
                    ->required()
                    ->placeholder('Örn: Twitter'),
                TextInput::make('url')
                    ->label('Link URL')
                    ->url()
                    ->required()
                    ->placeholder('https://twitter.com/kullanici'),
                TextInput::make('icon')
                    ->label('İkon (SVG veya FontAwesome Sınıfı)')
                    ->placeholder('fa-brands fa-twitter')
                    ->helperText('FontAwesome sınıflarını kullanabilirsiniz.'),
                ColorPicker::make('color')
                    ->label('Renk Kodu')
                    ->nullable(),
                Toggle::make('is_active')
                    ->label('Aktif mi?')
                    ->default(true),
            ]);
    }
}
