<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Closure;
use Exception;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make(name: 'validation')
                    ->schema([
                        Select::make(name: 'rule')
                            ->name(name: 'rule')
                            ->options(options: [
                                'required' => 'required',
                                'nullable' => 'nullable',
                                'string'   => 'string',
                                'numeric'  => 'numeric',
                            ])
                            ->required()
                            ->reactive(),

                        TextInput::make(name: 'value')
                            ->label(label: 'value')
                            ->validationAttribute(label: 'value')
                            ->reactive()
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {
                                        if ($value === 'foo') {
                                            $fail("The $attribute is invalid.");
                                        }
                                    };
                                },
                            ]),
                    ])
                    ->columnSpan(span: 2),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSettings::route(path: '/'),
            'create' => Pages\CreateSetting::route(path: '/create'),
            'edit'   => Pages\EditSetting::route(path: '/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'slug',
            'author.name',
            'category.name',
        ];
    }
}
