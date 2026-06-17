<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Schemas;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class RoleForm
{
    public static function configure(Schema $schema, string $resourceClass): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Role Details')
                            ->description('Set a role name. Permissions are managed below.')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->unique(
                                        ignoreRecord: true,
                                        modifyRuleUsing: fn (Unique $rule): Unique => Utils::isTenancyEnabled() ? $rule->where(Utils::getTenantModelForeignKey(), Filament::getTenant()?->id) : $rule
                                    )
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-finger-print'),

                                TextInput::make('description')
                                    ->label('Description')
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-information-circle'),

                                Hidden::make('guard_name')
                                    ->default(Utils::getFilamentAuthGuard()),

                                Select::make(config('permission.column_names.team_foreign_key'))
                                    ->label(__('filament-shield::filament-shield.field.team'))
                                    ->placeholder(__('filament-shield::filament-shield.field.team.placeholder'))
                                    /** @phpstan-ignore-next-line */
                                    ->default(Filament::getTenant()?->id)
                                    ->options(fn (): array => in_array(Utils::getTenantModel(), [null, '', '0'], true) ? [] : Utils::getTenantModel()::pluck('name', 'id')->toArray())
                                    ->visible(fn (): bool => $resourceClass::shield()->isCentralApp() && Utils::isTenancyEnabled())
                                    ->dehydrated(fn (): bool => $resourceClass::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                                $resourceClass::getSelectAllFormComponent(),

                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Permissions')
                    ->description('Choose the areas this role can access.')
                    ->schema([$resourceClass::getShieldFormComponents()])
                    ->columnSpanFull(),
            ]);
    }
}