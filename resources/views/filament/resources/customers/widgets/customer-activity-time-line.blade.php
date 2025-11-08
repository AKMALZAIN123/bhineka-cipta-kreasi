<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-heroicon-o-clock class="w-5 h-5" />
                Activity Timeline
            </div>
        </x-slot>

        <div class="space-y-4">
            @forelse($this->getActivities() as $activity)
                <div class="flex gap-4">
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full
                            @if($activity['color'] === 'primary') bg-primary-100 dark:bg-primary-900/20
                            @elseif($activity['color'] === 'info') bg-info-100 dark:bg-info-900/20
                            @elseif($activity['color'] === 'success') bg-success-100 dark:bg-success-900/20
                            @elseif($activity['color'] === 'warning') bg-warning-100 dark:bg-warning-900/20
                            @else bg-gray-100 dark:bg-gray-800
                            @endif
                        ">
                            @php
                                $iconClass = 'w-5 h-5 ';
                                $iconClass .= match($activity['color']) {
                                    'primary' => 'text-primary-600 dark:text-primary-400',
                                    'info' => 'text-info-600 dark:text-info-400',
                                    'success' => 'text-success-600 dark:text-success-400',
                                    'warning' => 'text-warning-600 dark:text-warning-400',
                                    default => 'text-gray-600 dark:text-gray-400',
                                };
                            @endphp
                            <x-dynamic-component :component="$activity['icon']" :class="$iconClass" />
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-950 dark:text-white">
                                    {{ $activity['title'] }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $activity['description'] }}
                                </p>
                                
                                @if(isset($activity['status']))
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md
                                            @if($activity['status'] === 'pending') bg-warning-100 text-warning-800 dark:bg-warning-900/20 dark:text-warning-400
                                            @elseif($activity['status'] === 'confirmed') bg-info-100 text-info-800 dark:bg-info-900/20 dark:text-info-400
                                            @elseif($activity['status'] === 'processing') bg-primary-100 text-primary-800 dark:bg-primary-900/20 dark:text-primary-400
                                            @elseif($activity['status'] === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400
                                            @elseif($activity['status'] === 'delivered') bg-success-100 text-success-800 dark:bg-success-900/20 dark:text-success-400
                                            @elseif($activity['status'] === 'cancelled') bg-danger-100 text-danger-800 dark:bg-danger-900/20 dark:text-danger-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400
                                            @endif
                                        ">
                                            {{ ucfirst($activity['status']) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $activity['date']->diffForHumans() }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $activity['date']->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center">
                    <x-heroicon-o-inbox class="w-12 h-12 mx-auto text-gray-400" />
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        No activity recorded yet
                    </p>
                </div>
            @endforelse
        </div>

        @if($this->getActivities()->isNotEmpty() && $this->getActivities()->count() >= 20)
            <x-slot name="footerActions">
                <x-filament::button
                    size="sm"
                    outlined
                >
                    Load More Activities
                    <x-heroicon-o-arrow-down class="w-4 h-4 ml-1" />
                </x-filament::button>
            </x-slot>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>