<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Order created successfully!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['order_date'])) {
            $data['order_date'] = now();
        }

        return $data;
    }

    public function getTitle(): string
    {
        return 'Create New Order';
    }
}
