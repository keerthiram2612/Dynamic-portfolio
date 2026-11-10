<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin')</title>
  <style>
    /* ---- original styles ---- */
    body { font-family: system-ui, sans-serif; background: #eef0f2; color: #14213d; margin: 0; }
    header { background: #14213d; color: #eef0f2; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
    header form { margin: 0; }
    main { max-width: 680px; margin: 2rem auto; padding: 0 1rem; }
    label { display: block; font-weight: 600; margin-top: 1rem; }
    input[type=text], input[type=email], input[type=password], input[type=url], input[type=file], textarea {
      width: 100%; padding: .6rem; border: 1px solid #9aa3b2; border-radius: 6px;
      font: inherit; box-sizing: border-box; margin-top: .25rem; background: #fff;
    }
    textarea { min-height: 6rem; }
    .hint { color: #5b6472; font-size: .9rem; font-weight: 400; }
    .error { color: #b42318; font-size: .9rem; margin-top: .25rem; }
    .success { background: #d1fadf; padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
    button { background: #ff5c39; color: #14213d; border: 0; padding: .7rem 1.4rem; border-radius: 6px; cursor: pointer; margin-top: 1.5rem; font: inherit; font-weight: 600; }
    button.link { background: none; color: #eef0f2; margin: 0; padding: 0; text-decoration: underline; }
    .check { display: flex; gap: .5rem; align-items: center; }

    /* ---- new styles for menus and tables ---- */
    header a { color: #eef0f2; text-decoration: none; }
    header a:hover { text-decoration: underline; }
    main { max-width: 900px; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 6px; overflow: hidden; }
    th, td { text-align: left; padding: .6rem .8rem; border-bottom: 1px solid #e1e4ea; vertical-align: middle; }
    .actions { display: flex; gap: .5rem; align-items: center; }
    .actions form { margin: 0; }
    .btn, button.small { display: inline-block; background: #ff5c39; color: #14213d; padding: .4rem .9rem; border-radius: 6px; text-decoration: none; font-weight: 600; border: 0; cursor: pointer; margin: 0; font-size: .9rem; }
    .btn.secondary { background: #c9cfdb; }
    button.danger { background: #b42318; color: #fff; }
    .top { display: flex; justify-content: space-between; align-items: center; }
  </style>
</head>
<body>
  @auth
    <header>
      <nav style="display:flex; gap:1.25rem; align-items:center;">
        <strong>Admin</strong>
        <a href="{{ route('admin.profiles.index') }}">Profile</a>
        <a href="{{ route('admin.menus.index') }}">Menus</a>
      </nav>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="link">Log out</button>
      </form>
    </header>
  @endauth
  <main>@yield('content')</main>
</body>
</html>