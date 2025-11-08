<?php

namespace App\Filament\Resources\Customers\Widgets;

use Filament\Widgets\Widget;

class CustomerActivityTimeLine extends Widget
{
    protected string $view = 'filament.resources.customers.widgets.customer-activity-time-line';

    public ?int $record = null;

    protected int | string | array $columnSpan = 'full';

    public function getActivities()
    {
        if (!$this->record) {
            return collect();
        }

        $user = \App\Models\User::find($this->record);
        if (!$user) {
            return collect();
        }

        $activities = collect();

        // Add order activities
        foreach ($user->orders()->latest()->limit(10)->get() as $order) {
            $activities->push([
                'type' => 'order',
                'icon' => 'heroicon-o-shopping-cart',
                'color' => 'primary',
                'title' => 'Order #' . $order->order_id,
                'description' => 'Total: Rp ' . number_format($order->total_amount),
                'status' => $order->status,
                'date' => $order->created_at,
            ]);
        }

        // Add design upload activities
        foreach ($user->designUploads()->latest()->limit(10)->get() as $design) {
            $activities->push([
                'type' => 'design',
                'icon' => 'heroicon-o-photo',
                'color' => 'info',
                'title' => 'Design Uploaded',
                'description' => $design->file_name . ' for ' . $design->product->name,
                'date' => $design->created_at,
            ]);
        }

        // Sort by date
        return $activities->sortByDesc('date')->take(20);
    }
}
