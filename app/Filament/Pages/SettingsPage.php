<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Schema;
use UnitEnum;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';

    protected static ?string $slug = 'settings';

    protected static bool $shouldRegisterNavigation = true;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldSkipAuthorization = true;

    public array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('settings.manage') ?? false;
    }

    public function mount(): void
    {
        $settings = Setting::allGrouped();

        $this->form->fill($settings);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('data.shop_name')
                            ->label('Shop Name')
                            ->required(),
                        TextInput::make('data.shop_tagline')
                            ->label('Tagline'),
                        Textarea::make('data.shop_description')
                            ->label('Description')
                            ->rows(2),
                        FileUpload::make('data.shop_logo')
                            ->label('Logo')
                            ->image()
                            ->directory('settings'),
                        TextInput::make('data.shop_footer_text')
                            ->label('Footer Text'),
                    ])
                    ->columns(2),
                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('data.shop_address')
                            ->label('Address')
                            ->columnSpanFull(),
                        TextInput::make('data.shop_phone')
                            ->label('Phone'),
                        TextInput::make('data.shop_email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('data.shop_hours')
                            ->label('Business Hours')
                            ->columnSpanFull(),
                        TextInput::make('data.shop_facebook')
                            ->label('Facebook URL'),
                        Textarea::make('data.contact_map_embed')
                            ->label('Map Embed Code')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Actions::make([
                    Action::make('save')
                        ->label('Save Settings')
                        ->submit('save'),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}
