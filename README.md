# Navigation/Menu manager for Laravel Nova

## Installation

`composer require dewsign/nova-navigation`

`php artisan migrate`

## Usage

To get started, you will need to create your first Navigation area. E.g. Header or Footer navigation. You are free to structure the files as you wish or you can use the conventions from the examples if you prefer.

We simply use the default Nova folder to register our new navigation as it will load automatically.

```php
// app/Nova/HeaderNavigation.php

namespace App\Nova;

use Dewsign\NovaNavigation\Nova\Navigation;

class HeaderNavigation extends Navigation
{
    public static $zone = 'header';

    public static function label()
    {
        return __('Header Links');
    }
}
```

The `$zone` is used to differentiate the various navigation areas in the database and code and avoids requiring new tables for each new navigation area.

Your new navigation zone should now be available within Nova, with the default custom link item as the only option.

## Outputting the navigation (Blade)

We don't currently make any assumptions about how you wish to render teh navigation. Some helpers surrounding common usage are planned for the future though. For now please access the `Dewsign\NovaNavigation\Models\Navigation` model as you sould any other Eloquent model to retrieve the navigation items you require.

Here is a basic inline blade example.

```php
@foreach(Navigation::active()->whereZone('header')->get() as $navigationItem)
    {!! $navigationItem->view !!}
    {!! or !!}
    <a href="{{ $navigationItem->action }}">{{ $navigationItem->label }}</a>
@endforeach
```

You can access any sub-items through the `navigations` relationship.

```php
@foreach($navigationItem->navigations as $item)
    {!! $item->view !!}
@endforeach
```

## Extending

You can create your own navigation item types by creating a couple of new files and loading them in. In short, you will need:

* An Eloquent Model, complete with migration / database
* A Nova resource to manage the content
* A blade view to render the item

```php
// app/Navigation/Models/Section.php

use Dewsign\NovaNavigation\Models\NavigationItem;

class Section extends NavigationItem
{
    public static $viewTemplate = 'navigation.section';

    public function resolveAction()
    {
        return $this->link_url;
    }

    public function resolveLabel($model = null)
    {
        return $model->title ?? $this->heading;
    }
}
```

```php
// database/migrations/your_migration.php

Schema::create('nav_sections', function (Blueprint $table) {
    $table->increments('id');
    $table->string('heading')->nullable();
    $table->text('content')->nullable();
    $table->string('link_url')->nullable();
    $table->string('link_title')->nullable();
    $table->timestamps();
});
```

```php
// app/Navigation/Nova/Section.php

...
use Dewsign\NovaNavigation\Nova\Items\NavigationItem;

class Section extends NavigationItem
{
    public static $model = App\Navigation\Models\Section::class;

    public static $title = 'heading';

    public static $search = [
        'heading',
        'content',
        'link_url',
    ];

    public static function label()
    {
        return __('Section');
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Heading'),
            Markdown::make('Content'),
            Text::make('Link Url'),
            Text::make('Link Title'),
        ];
    }
}
```

Finally, load the new navigation item through the `novanavigation` config

```php
return [
    "repeaters" => [
        \App\Navigation\Nova\Section::class,
    ],
    "replaceRepeaters" => false,
];
```
