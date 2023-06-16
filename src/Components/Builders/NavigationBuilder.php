<?php

namespace App\Support\Builders;

use App\Support\Interfaces\NavigationItemInterface;
use Filament\Navigation\NavigationBuilder as FilamentNavigationBuilder;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

abstract class NavigationBuilder
{
    protected array $items = [];

    private array $faIcons5To6 = [
        '' => 'heroicon-o-document',
    ];

    public function __construct()
    {
    }

    public static function create(): static
    {
        return (new static())->createMenuItems();
    }

    public static function createForFilament(): \Closure
    {
        return fn (FilamentNavigationBuilder $builder): FilamentNavigationBuilder => (new static())->createFilamentMenuItems($builder);
    }

    abstract protected function getRawItems(): Collection;

    public function getItems(): Collection
    {

        $user = auth('filament')->user();
        return $this->getRawItems()
            ->filter(fn (array $item) => ! data_get($item, 'permission') || $user->hasPermissionTo($item['permission']) || $user->can($item['permission']))
            ->map(function (array $item) use ($user) {
                $item = new Fluent($item);
                $item->title = $item->linktitle;
                $item->children = collect($item->children)
                    ->filter(fn (array|\Filament\Navigation\NavigationItem $item) => $item instanceof \Filament\Navigation\NavigationItem
                        || ! data_get($item, 'permission') || $user->can($item['permission']) || $user->hasPermissionTo($item['permission']))
                    ->map(function (array|\Filament\Navigation\NavigationItem $child) {
                        if ($child instanceof \Filament\Navigation\NavigationItem) {
                            return $child;
                        }
                        $child = new Fluent($child);
                        $child->title = $child->linktitle;

                        return $child;
                    });

                return $item;
            });
    }

    protected function createMenuItems(): static
    {
        $this->getItems()->map(function (Fluent $item) {
            $navItem = NavigationItem::create()
                ->setTitle($item->linktitle)
                ->when($item->link, fn (NavigationItem $nav) => $nav->setLink($this->getRelativeLink($item->link)))
                ->when($item->route, fn (NavigationItem $nav) => $nav->setRoute($item->route))
                ->setIcon($item->symbol);

            if ($item->has('children')) {
                $children = collect($item->children)->map(function ($childItem) {
                    if ($childItem instanceof \Filament\Navigation\NavigationItem) {
                        return NavigationItem::create()
                            ->setTitle($childItem->getLabel())
                            ->setLink($childItem->getUrl());
                    }

                    return NavigationItem::create()
                        ->setTitle($childItem->linktitle)
                        ->when($childItem->link, fn (NavigationItem $nav) => $nav->setLink($this->getRelativeLink($childItem->link)))
                        ->when($childItem->route, fn (NavigationItem $nav) => $nav->setRoute($childItem->route))
                        ->setIcon($this->bootstrapClasses->execute($childItem->symbol));
                });

                $navItem->setChildren($children->toArray());
            }

            return $this->addNavigationItem($navItem);
        });

        return $this;
    }

    private function createFilamentMenuItems(FilamentNavigationBuilder $builder): FilamentNavigationBuilder
    {
        $this->getItems()->map(function ($menu) use ($builder) {
            if ($menu->children->isNotEmpty()) {
                return $builder->group(
                    \Filament\Navigation\NavigationGroup::make()
                        ->label($menu->linktitle)
                        ->icon($this->faIcon5To6($menu->symbol))
                        ->collapsible()
                        ->collapsed()
                        ->items($menu->children
                            ->map(function ($item) {
                                $return = $item instanceof \Filament\Navigation\NavigationItem
                                ? $item
                                : \Filament\Navigation\NavigationItem::make()
                                ->label($item->title ?? $item->linktitle ?? 'Not Set')
                                ->icon($this->faIcon5To6($item->symbol))
                                ->isActiveWhen(fn () => request()->is(
                                    str($item->route ? route($item->route) : url($item->link))
                                        ->replace(request()->root() . '/', '')
                                ))
                                ->url($item->route ? route($item->route) : url($item->link));
                                return $return;
                            })
                            ->all())
                );
            }

            return $builder->item(
                \Filament\Navigation\NavigationItem::make()
                    ->label($menu->linktitle)
                    ->icon($this->faIcon5To6($menu->symbol))
                    ->url($menu->route ? route($menu->route) : url($menu->link))
            );
        });

        return $builder;
    }

    private function getRelativeLink($link)
    {
        if (Str::contains($link, '://') || Str::startsWith($link, '/')) {
            return $link;
        }

        return '/' . $link;
    }

    private function faIcon5To6(?string $icon): string
    {
        $icon = trim($icon);
        if (array_key_exists($icon, $this->faIcons5To6)) {
            return $this->faIcons5To6[$icon];
        }

        return $icon ? str($icon)->replace('fa-', 'fas-') : $this->faIcons5To6[''];
    }

    public function addNavigationItems(array $navigationItems): self
    {
        collect($navigationItems)->each(function (NavigationItemInterface $item): void {
            $this->addNavigationItem($item);
        });

        return $this;
    }

    public function addNavigationItem(NavigationItemInterface $navigationItem): self
    {
        $this->items[] = $navigationItem;

        return $this;
    }

    public function getNavigationItems(): Collection
    {
        return collect($this->items)->map(function ($item) {
            return $item->toArray();
        });
    }
}
