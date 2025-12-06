<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Components\Section;

use BackedEnum;

class ManageAbout extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Genel Ayarlar';
    protected static ?string $title = 'Site Ayarları';

    protected string $view = 'filament.pages.manage-about';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_title' => SiteSetting::get('site.title', config('app.name')),
            'site_logo' => SiteSetting::get('site.logo'),
            'site_favicon' => SiteSetting::get('site.favicon'),
            'about_title' => SiteSetting::get('about.title', 'Hakkımda'),
            'content' => SiteSetting::get('about.content', ''),
            'image' => SiteSetting::get('about.image'),
        ]);
    }

    public function form($form)
    {
        return $form
            ->schema([
                // Site Kimliği
                TextInput::make('site_title')
                    ->label('Site Başlığı')
                    ->required(),
                FileUpload::make('site_logo')
                    ->label('Logo')
                    ->image()
                    ->directory('settings')
                    ->visibility('public'),
                FileUpload::make('site_favicon')
                    ->label('Favicon')
                    ->image()
                    ->directory('settings')
                    ->visibility('public'),

                // Hakkımızda
                TextInput::make('about_title')
                    ->label('Hakkımda Başlık')
                    ->required(),
                RichEditor::make('content')
                    ->label('Hakkımda İçerik')
                    ->required(),
                FileUpload::make('image')
                    ->label('Hakkımda Görsel')
                    ->image()
                    ->directory('about')
                    ->visibility('public'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // Helper to save or update
        $this->updateSetting('site.title', $state['site_title']);
        if (isset($state['site_logo'])) $this->updateSetting('site.logo', null, $state['site_logo']);
        if (isset($state['site_favicon'])) $this->updateSetting('site.favicon', null, $state['site_favicon']);

        $this->updateSetting('about.title', $state['about_title']);
        $this->updateSetting('about.content', $state['content']);
        if (isset($state['image'])) $this->updateSetting('about.image', null, $state['image']);

        Notification::make()
            ->title('Ayarlar Kaydedildi')
            ->success()
            ->send();
    }

    private function updateSetting($key, $value = null, $image = null)
    {
        $setting = SiteSetting::firstOrNew(['key' => $key]);
        if ($value !== null) $setting->value = $value;
        if ($image !== null) $setting->image = $image;
        $setting->save();
    }
}
