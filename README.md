# Jaws Game

## Local Development

Set up the default database
```console
php artisan migrate
```

Compiling assets for development

```console
npm install
npm run dev
```

Next, assuming you're using [Valet](https://laravel.com/docs/6.x/valet), link the site and update it with a local SSL certificate

```console
valet link jaws
valet secure
```

## Contributing

Hot fixes and site-breaking bug fixes can be made directly to the Master branch.
**All other enhancement or feature changes should be made on a separate branch.**
When the change is ready, open a Pull Request and ask the site owner for review and they will merge the change into the site if it passes review.

## Built With

- [Laravel Mix](https://github.com/JeffreyWay/laravel-mix)
- [Laravel Websockets](https://beyondco.de/docs/laravel-websockets)
- [Tailwind CSS](https://tailwindcss.com/docs)

## Author(s)

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/DaltonMcCleery">
        <img src="https://avatars2.githubusercontent.com/u/37309201?v=4" width="100px;" alt=""/><br/>
        <sub><b>Dalton McCleery</b></sub><br/>
      </a>
    </td>
  </tr>
</table>
