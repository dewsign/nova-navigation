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

Your new navigation zone will now be available within Nova, with the default custom link item as the only option.

## Outputting the navigation (Blade)

### Navigation Blade Directive

A blade directive is included to render navigation zones primarily through views. A default unordered list view is included and can be published from the package.

Inside your blade view template or layout ...

```php
@novaNavigation('my-zone')
```

This will render all navigation items recursively using the default view. To create a custom view you can make a new blade view in `resources/views/vendor/nova-navigation/zone//my-zone.blade.php`.

You can use the default view as a template.

```php
<ul>
    @foreach ($items as $item)
        <li>
            {!! $item->view !!}
            @if ($item->navigations->count())
                @novaNavigation($zone, $item->navigations)
            @endif
        </li>
    @endforeach
</ul>
```

You will notice that it renders the same view for each level of navigation nested within the parent item. If you don't want this you will need to manually loop through the child items. You can access any sub-items through the `navigations` relationship.

```php
@foreach($navigationItem->navigations as $item)
    {!! $item->view !!}
@endforeach
```

The `view` property renders the assigned blade view for the navigation item type. The default custom item view can be published and modified through the vendor views `resources/views/vendor/nova-navigation/custom.blade.php`

If you don't want to render the navigation item's default view, you can manually build an inline view and use the `label` and `action` properties.

```php
<a href="{{ $navigationItem->action }}">{{ $navigationItem->label }}</a>
```

## Extending

You can create your own navigation item types by creating a couple of new files and loading them in. This is useful for making your content types available as selectable navigation items instead of manually typing in custom URLs. As an example, if you have a Blog and want the user to be able to select an article or category to link to.

You will need:

* An Eloquent Model, complete with migration
* A Nova resource to manage the content
* A blade view to render the item

```php
// app/Navigation/Models/Category.php

use Dewsign\NovaNavigation\Models\NavigationItem;

class Section extends NavigationItem
{
    public static $viewTemplate = 'nova-navigation::category';

    public function category()
    {
        // BlogCategoryModel is used as an example. Include your actual blog category model.
        return $this->belongsTo(BlogCategoryModel::class);
    }

    // Return the url for this navigation item
    public function resolveAction()
    {
        return route('blog.category', $this->category);
    }

    // Return the label to display in the navigation
    public function resolveLabel($category = null)
    {
        // Automatically use the category title as navigation label
        return $category->title;
    }
}
```

```php
// database/migrations/your_migration.php

Schema::create('nav_categories', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('category_id')->nullable();
    $table->timestamps();
});
```

```php
// app/Navigation/Nova/Category.php

...
use Dewsign\NovaNavigation\Nova\Items\NavigationItem;

class Section extends NavigationItem
{
    // The model we just created
    public static $model = App\Navigation\Models\Category::class;

    public static function label()
    {
        return __('Category');
    }

    public function fields(Request $request)
    {
        return [
            // BlogCategoryResource is used as an example. Include your actual blog category nova resource.
            BelongsTo::make('Category', 'category', BlogCategoryResource::class)->searchable(),
        ];
    }
}
```

Next you need to tell the system how you want to render the category navigation item. Create a new view at the location specified in the Model (in this example `resources/views/vendor/nova-navigation/category.blade.php`). Or you can set the view in the model to the default `nova-navigation::custom` if you simply want to render the same layout for all navigation items.

```php
<a href="{{ $model->action }}" class="category-navigation-item">{{ $model->label }}</a>
```

`$model` references the Category Model we created. To access the actual blog category you can refer to the relationship `$model->category` if you wanted to include additional details in your view. E.g.

```php
<a href="{{ $model->action }}" class="category-navigation-item">
    {{ $model->label }} ({{ $model->category->articles()->count() }})
</a>
```

Finally, load the new navigation item through the `novanavigation` config

```php
return [
    "repeaters" => [
        \App\Navigation\Nova\Category::class,
    ],
    "replaceRepeaters" => false,
];
```

User can now add a `Category` navigation item and select an existing category to link to. The benefit is that when the category changes, the navigation item also reflects these.

## Hyperlinks Repeater Blocks

If you are using [Nova Repeater Blocks](https://github.com/dewsign/nova-repeater-blocks) to build out your content, you may want to include a repeater block which acts like a navigation zone to add inline links. Add the included `NrbHyperlinks` for your repeater blocks.

```php
    // config/repeater-blocks
    ...
    "repeaters" => [
        ...
        Dewsign\NovaNavigation\Nova\NrbHyperlinks::class,
    ],
```

This will render each navigation item using their respective views. The wrapper for each item can be customised by creating new templates in the `views/vendor/nova-navigation/hyperlinks` directory. You can publish and modify the default if required.
