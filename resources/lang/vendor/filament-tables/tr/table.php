<?php

return [

    'column_toggle' => [

        'heading' => 'Sütunlar',

    ],

    'columns' => [

        'text' => [
            'more_list_items' => 've :count daha fazla',
        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'Toplu işlemler için tüm öğeleri seç/iptal et.',
        ],

        'bulk_select_record' => [
            'label' => 'Toplu işlemler için öğe :key\'i seç/iptal et.',
        ],

        'search' => [
            'label' => 'Ara',
            'placeholder' => 'Ara',
            'indicator' => 'Ara',
        ],

    ],

    'summary' => [

        'heading' => 'Özet',

        'subheadings' => [
            'all' => 'Tüm :label',
            'group' => ':group özeti',
            'page' => 'Bu sayfa',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'Ortalama',
            ],

            'count' => [
                'label' => 'Sayım',
            ],

            'sum' => [
                'label' => 'Toplam',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'Yeniden sıralama işlemini bitir',
        ],

        'enable_reordering' => [
            'label' => 'Kayıtları yeniden sırala',
        ],

        'filter' => [
            'label' => 'Filtre',
        ],

        'group' => [
            'label' => 'Grupla',
        ],

        'open_bulk_actions' => [
            'label' => 'Toplu işlemler',
        ],

        'toggle_columns' => [
            'label' => 'Sütunları aç/kapa',
        ],

    ],

    'empty' => [

        'heading' => ':model Yok',

        'description' => ':model oluşturmak için başlayın.',

    ],

    'filters' => [

        'actions' => [

            'remove' => [
                'label' => 'Filtreyi kaldır',
            ],

            'remove_all' => [
                'label' => 'Tüm filtreleri kaldır',
                'tooltip' => 'Tüm filtreleri kaldır',
            ],

            'reset' => [
                'label' => 'Sıfırla',
            ],

        ],

        'heading' => 'Filtreler',

        'indicator' => 'Aktif filtreler',

        'multi_select' => [
            'placeholder' => 'Tümü',
        ],

        'select' => [
            'placeholder' => 'Tümü',
        ],

        'trashed' => [

            'label' => 'Silinmiş kayıtlar',

            'only_trashed' => 'Sadece silinmiş kayıtlar',

            'with_trashed' => 'Silinmiş kayıtlarla birlikte',

            'without_trashed' => 'Silinmiş kayıtlar olmadan',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'Grupla',
                'placeholder' => 'Grupla',
            ],

            'direction' => [

                'label' => 'Grup sıralama yöntemi',

                'options' => [
                    'asc' => 'Artan',
                    'desc' => 'Azalan',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'Kayıtları sürükleyip düzene sokun.',

    'selection_indicator' => [

        'selected_count' => '1 kayıt seçildi|:count kayıt seçildi',

        'actions' => [

            'select_all' => [
                'label' => 'Tümünü Seç :count',
            ],

            'deselect_all' => [
                'label' => 'Tümünü Kaldır',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Sırala',
            ],

            'direction' => [

                'label' => 'Sıralama Yönü',

                'options' => [
                    'asc' => 'Artan',
                    'desc' => 'Azalan',
                ],

            ],

        ],

    ],

];
