<?php

namespace Filament;

use Closure;
use Filament\Exceptions\NoDefaultPanelSetException;
use Illuminate\Support\Arr;

class PanelRegistry
{
    /**
     * @var array<string, Panel>
     */
    public array $panels = [];

    public function register(Panel | Closure $panel): void
    {
        $panel = value($panel);

        $this->panels[$panel->getId()] = $panel;

        $panel->register();

        if (! $panel->isDefault()) {
            return;
        }

        if (app()->resolved('filament')) {
            app('filament')->setCurrentPanel($panel);

            return;
        }

        app()->resolving(
            'filament',
            fn (FilamentManager $manager) => $manager->setCurrentPanel($panel),
        );
    }

    /**
     * @throws NoDefaultPanelSetException
     */
    public function getDefault(): Panel
    {
        return Arr::first(
            $this->panels,
            fn (Panel $panel): bool => $panel->isDefault(),
            fn () => throw NoDefaultPanelSetException::make(),
        );
    }

    public function get(?string $id = null): Panel
    {
        return $this->panels[$id] ?? $this->getDefault();
    }

    /**
     * @return array<string, Panel>
     */
    public function all(): array
    {
        return $this->panels;
    }
}
