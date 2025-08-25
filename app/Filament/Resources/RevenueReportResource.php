<?php

namespace App\Filament\Resources;

use App\Models\Order;
use App\Models\Business;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class RevenueReportResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Reports';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return \App\Models\Order::query()
                    ->whereHas('payment', function ($q) {
                        $q->whereNotIn('status', ['incomplete', 'failed']);
                    })
                    ->whereNotIn('delivery_status', ['waiting', 'canceled'])
                    ->selectRaw('
                        business_id as id,    
                        business_id,
                        COUNT(*) as total_orders,
                        SUM(gross_price) as total_gross,
                        SUM(total_price - order_fee) as total_net
                    ')
                    ->with('business')
                    ->groupBy('business_id');
            })


            ->columns([
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Business'),

                Tables\Columns\TextColumn::make('total_orders')
                    ->label('Orders')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_gross')
                    ->label('Gross Revenue')
                    ->money('AUD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_net')
                    ->label('Net Revenue')
                    ->money('AUD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_payouts')
                    ->label('Total Payouts')
                    ->money('AUD')
                    ->getStateUsing(function ($record) {
                        return \App\Models\Payout::where('business_id', $record->business_id)
                            ->where('status', 'paid')
                            ->sum('amount');
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->money('AUD')
                    ->getStateUsing(function ($record) {
                        $totalNet = $record->total_net ?? 0;

                        $paidOut = \App\Models\Payout::where('business_id', $record->business_id)
                            ->where('status', 'paid')
                            ->sum('amount');

                        return $totalNet - $paidOut;
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                        Select::make('business_id')
                            ->label('Business')
                            ->options(Business::pluck('name', 'id'))
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('order_date', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('order_date', '<=', $date))
                            ->when($data['business_id'], fn($q, $biz) => $q->where('business_id', $biz));
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                        Select::make('business_id')
                            ->label('Business')
                            ->options(Business::pluck('name', 'id'))
                            ->searchable(),
                    ])
                    ->action(function (array $data) {
                        $params = [];
                        if (!empty($data['from'])) {
                            $params['from'] = \Illuminate\Support\Carbon::parse($data['from'])->format('Y-m-d');
                        }
                        if (!empty($data['until'])) {
                            $params['until'] = \Illuminate\Support\Carbon::parse($data['until'])->format('Y-m-d');
                        }
                        if (!empty($data['business_id'])) {
                            $params['business_id'] = $data['business_id'];
                        }

                        return redirect()->route('export.revenue', $params);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_orders')
                    ->label('View Orders')
                    ->url(fn($record) => route('filament.admin.resources.orders.index', [
                        'tableFilters[business_id][value]' => $record->business_id,
                    ]))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\RevenueReportResource\Pages\ListRevenueReports::route('/'),
        ];
    }
}
