<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChallengeResource\Pages;
use App\Filament\Resources\ChallengeResource\RelationManagers;
use App\Models\Challenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Models\Submission;
use App\Models\User;

class ChallengeResource extends Resource
{
    protected static ?string $model = Challenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('identifier')
                    ->required()
                    ->unique(Challenge::class, 'identifier', fn ($record) => $record),
                DatePicker::make('date')
                    ->required()
                    ->unique(Challenge::class, 'date', fn ($record) => $record),
                Textarea::make('prompt')
                    ->required(),
                Select::make('winner')
                    ->label('Winner')
                    ->relationship('winnerSubmission', 'id')
                    ->nullable()
                    ->searchable()
                    ->getOptionLabelUsing(function ($value) {
                        $submission = Submission::find($value);
                        if (!$submission) {
                            return null;
                        }
                        $user = User::find($submission->user_id);
                        return $user ? $user->name . ' (' . $submission->id . ')' : $submission->id;
                    })
                    ->options(function (callable $get) {
                        $challengeId = $get('id'); // This gets the current challenge ID
                        return Submission::where('challenge_id', $challengeId)
                            ->get()
                            ->mapWithKeys(function ($submission) {
                                $user = $submission->user;
                                return [$submission->id => $user ? $user->name . ' (' . $submission->id . ')' : $submission->id];
                            });
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identifier'),
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('prompt'),
                Tables\Columns\TextColumn::make('winnerSubmission.id')->label('Winner Submission'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListChallenges::route('/'),
            'create' => Pages\CreateChallenge::route('/create'),
            'edit' => Pages\EditChallenge::route('/{record}/edit'),
        ];
    }
}
