TODO list
=================

Velmi jednoduchý TODO list vytvořený na [Nette Web Project](https://github.com/nette/web-project).

Requirements
------------

This Web Project is compatible with Nette 3.2 and requires PHP 8.1.


Installation
------------

To install the Web Project, Composer is the recommended tool. If you're new to Composer,
follow [these instructions](https://doc.nette.org/composer). Then, run:

	composer create-project nette/web-project path/to/install
	cd path/to/install

Ensure the `temp/` and `log/` directories are writable.


Web Server Setup
----------------

To quickly dive in, use PHP's built-in server:

	php -S localhost:8000 -t www

Then, open `http://localhost:8000` in your browser to view the welcome page.

For Apache or Nginx users, configure a virtual host pointing to your project's `www/` directory.

**Important Note:** Ensure `app/`, `config/`, `log/`, and `temp/` directories are not web-accessible.
Refer to [security warning](https://nette.org/security-warning) for more details.


Upřesnění
----------------

Do projektu přidány knihovny
- [dibi/dibi](https://dibiphp.com/) pro práci s databází
- [tharos/leanmapper](https://leanmapper.com/) pro základní ORM

SQL dump pro vytvoření databáze (použitá MariaDB) je v souboru `db/database.sql`

Dále by bylo prima tam v základu doplnit
- Uhezkat vzhled + udělat AJAXy
- Doplnit k úkolu datum a čas
- Možnost kalendářového zobrazení / upozornění na aktuální / propadlé úkoly ...
- Autenetifikaci uživatele
- Přidání uživatelů s možností přiřazení úkolů
- ...
