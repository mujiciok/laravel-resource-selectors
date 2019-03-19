# Laravel resource selectors

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mujiciok/resource-selectors.svg?style=flat-square)](https://packagist.org/packages/mujiciok/laravel-resource-selectors)
[![Build Status](https://img.shields.io/travis/mujiciok/resource-selectors/master.svg?style=flat-square)](https://travis-ci.org/mujiciok/laravel-resource-selectors)
[![Quality Score](https://img.shields.io/scrutinizer/g/mujiciok/resource-selectors.svg?style=flat-square)](https://scrutinizer-ci.com/g/mujiciok/laravel-resource-selectors)
[![Total Downloads](https://img.shields.io/packagist/dt/mujiciok/resource-selectors.svg?style=flat-square)](https://packagist.org/packages/mujiciok/laravel-resource-selectors)
[![License](https://img.shields.io/packagist/l/mujiciok/resource-selectors.svg?style=flat-square)](https://packagist.org/packages/mujiciok/laravel-resource-selectors)

Laravel Package for resource classes (collections and single resources) with selectors (only, except, filters).

## Installation

You can install the package via composer:

```bash
composer require mujiciok/laravel-resource-selectors
```

## Usage
### Artisan commands
```bash
// create UserResource
php artisan make:resource-selectors User

// create UserCollection
php artisan make:resource-selectors -c User 
```

### Resources created
``` php
class UserCollection extends ResourceCollectionExtended
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // initially created as default Laravel resource
        // return parent::toArray($request);

        return [
            'data' => UserResource::collection($this->collection),
        ];
    }
}

class UserResource extends ResourceExtended
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // initially attributes array is empty
        // return $this->getResource([
        //     //
        // ]);
        
        return $this->getResource([
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ]);
    }
}
```

### Controller usage
``` php
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // standart Laravel Resource
        return new UserCollection($users);

        // ONLY usage
        return (new UserCollection($users))->only('id,name');
        // or
        return (new UserCollection($users))->only(['id', 'name']);

        // EXCEPT usage
        return (new UserCollection($users))->except('id');
        // or
        return (new UserCollection($users))->except(['id']);

        // FILTERS usage
        return (new UserCollection($users))->filters(['only' => 'id,email']);
        return (new UserCollection($users))->filters(['except' => 'email']);
        
        // redundant, but available :)
        return (new UserCollection($users))->only(['id', 'name'])->except('name');
        return (new UserCollection($users))->filters(['except' => ['email'], 'only' => 'id,email,name']);
    }
    
    public function show()
    {
        $user = User::find(1);

        // standart Laravel Resource
        return new UserResource($user);

        // same usage as presented above
        return (new UserResource($user))->only('id,name');
        return (new UserResource($user))->except(['id', 'name']);
        return (new UserResource($user))->filters(['except' => 'email', 'only' => ['id', 'email', 'name']]);
        // etc.
    }
}
```

### Security

If you discover any security related issues, please email mirceacojocaru90@gmail.com instead of using the issue tracker.

## Credits

- [Mircea Cojocaru](https://github.com/mujiciok)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).