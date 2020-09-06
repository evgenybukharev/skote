<?php

namespace EvgenyBukharev\Skote\Components\Menu;

/**
 * Class MenuRenderer
 *
 * @package EvgenyBukharev\Skote\Components\Menu
 */
class MenuRenderer implements MenuRendererInterface
{
    /**
     * @return array
     */
    public function getMenu(): array
    {
        return [
            ['title' => 'Сайт', 'type' => 'section'],
            [
                'title' => 'Категории',
                'type' => 'link-block',
                'icon' => 'bx bx-file',
                'links' => [
                    ['title' => 'Список', 'href' => ''],
                    ['title' => 'Список', 'href' => ''],
                ],
            ],
            ['title' => 'Файловый менеджер', 'icon' => 'bx bxs-folder-open', 'type' => 'link', 'href' => 'admin/elfinder'],
            ['title' => 'Настройки', 'icon' => 'bx bx-file', 'type' => 'link', 'href' => route(config('skote.url.settings', 'settings'))],
        ];
    }
}
