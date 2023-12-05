<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestResource\Pages;
use App\Models\Guest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('number_of_guests')
                    ->label('Guest type')
                    ->options([
                        'Single' => 'Single',
                        'Couple' => 'Couple',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\Toggle::make('status')
                    ->label('Checked in?')
                    ->required(),
                Forms\Components\Select::make('seat_side')
                    ->label('Seat side')
                    ->options([
                        'Bride' => 'Bride',
                        'Groom' => 'Groom',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('table_number')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invitation_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_guests')
                    ->label('Guest type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Check-in status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('seat_side')
                    ->label('Seat side')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('table_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('number_of_guests')
                    ->label('Guest type')
                    ->options([
                        'Single' => 'Single',
                        'Couple' => 'Couple',
                    ])

                    ->default(null),
                SelectFilter::make('status')
                    ->label('Check-in status')
                    ->options([
                        '1' => 'Checked in',
                        '0' => 'Not checked in',
                    ])
                    ->default(null),
                SelectFilter::make('seat_side')
                    ->label('Seat side')
                    ->options([
                        'Bride' => 'Bride',
                        'Groom' => 'Groom',
                    ])
                    ->default(null),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGuests::route('/'),
        ];
    }
}
