# Tinylytics Plugin — Improvement Plan

This document tracks the recommended code improvements identified during the initial review.
Items are grouped by category and ordered by priority. Check off each item as it is completed.

---

## Security

- [ ] **S1 — Replace session-based admin detection**
  Remove native PHP `session_start()` / `$_SESSION` logic and replace with a direct
  `is_user_logged_in()` + `current_user_can('manage_options')` check inside the `wp_footer`
  hook. This eliminates session conflicts with other plugins and hosting environments.
  _Files:_ `jmitch-tinylytics.php`

- [ ] **S2 — Replace `esc_url_raw()` with `esc_url()` in HTML context**
  In `jmitch_tinylytics_output_script()`, the script `src` attribute is built using
  `esc_url_raw()`. Since this is an HTML attribute context, `esc_url()` is the correct
  escaping function.
  _Files:_ `jmitch-tinylytics.php`

- [ ] **S3 — Validate `$_GET['tab']` against an allowlist**
  The admin tab switcher reads `$_GET['tab']` without checking that the value is one of the
  expected tab names. Add a simple allowlist check before using the value.
  _Files:_ `jmitch-tinylytics.php`

- [ ] **S4 — Complete uninstall cleanup**
  `uninstall.php` only deletes `jmitch_tinylytics_settings`. Audit for any transients or
  additional options and remove them too.
  _Files:_ `uninstall.php`

---

## WordPress Standards & Best Practices

- [ ] **W1 — Move admin style enqueue to `admin_enqueue_scripts`**
  Replace the `admin_print_styles` hook with `admin_enqueue_scripts` and use the `$hook`
  parameter to load the stylesheet only on the plugin's own settings page.
  _Files:_ `jmitch-tinylytics.php`

- [ ] **W2 — Guard `wp_enqueue_script` when Site ID is empty**
  Add an early return in `jmitch_tinylytics_output_script()` when the Site ID setting is
  empty so no script tag is emitted.
  _Files:_ `jmitch-tinylytics.php`

- [ ] **W3 — Simplify `jmitch_tinylytics_load_i18n()`**
  Remove the four-path manual filesystem lookup and replace with a single standard
  `load_plugin_textdomain()` call, which already handles all standard locations.
  _Files:_ `jmitch-tinylytics.php`

---

## Code Quality & Maintainability

- [ ] **Q1 — Define a constant for the option key**
  Replace the repeated raw string `'jmitch_tinylytics_settings'` with a named constant
  (e.g., `TINYLYTICS_OPTION_KEY`) defined once at the top of the main plugin file.
  _Files:_ `jmitch-tinylytics.php`, `uninstall.php`

- [ ] **Q2 — Cache the settings array**
  Introduce a small helper function (e.g., `jmitch_tinylytics_get_settings()`) that calls
  `get_option()` once and returns the result, so repeated hooks share one database read.
  _Files:_ `jmitch-tinylytics.php`, `inc/user-shortcodes.php`

- [ ] **Q3 — Update minimum PHP version declaration**
  The plugin uses `??` (null coalescing operator, PHP 7.0+) but declares `Requires PHP: 5.6.20`.
  Update the header and `readme.txt` to reflect PHP 7.2 as the true minimum.
  _Files:_ `jmitch-tinylytics.php`, `readme.txt`

- [ ] **Q4 — Use `sprintf()` for HTML in shortcodes**
  Refactor the string-concatenated HTML in `user-shortcodes.php` to use `sprintf()` with
  clearly labeled placeholders, improving readability and reducing escaping mistakes.
  _Files:_ `inc/user-shortcodes.php`

- [ ] **Q5 — Fix `wp_make_link_relative()` usage**
  `wp_make_link_relative()` is designed for internal URLs. Replace its use in shortcodes with
  a properly sanitized `$_SERVER['REQUEST_URI']` or `esc_url( get_permalink() )`.
  _Files:_ `inc/user-shortcodes.php`

- [ ] **Q6 — Add PHPDoc blocks to all functions**
  Add `@param`, `@return`, and description PHPDoc comments to every function across the
  plugin to improve IDE support and long-term maintainability.
  _Files:_ `jmitch-tinylytics.php`, `inc/user-shortcodes.php`

---

## Minor / Low Priority

- [ ] **M1 — Remove `index.php` stub files**
  The empty `index.php` files in each directory are unnecessary on modern WordPress hosting.
  Remove them to reduce clutter.
  _Files:_ `index.php`, `inc/index.php`, `css/index.php`, `languages/index.php`

---

## Progress Summary

| # | Item | Status |
|---|------|--------|
| S1 | Replace session-based admin detection | pending |
| S2 | `esc_url()` in HTML context | pending |
| S3 | Validate `$_GET['tab']` | pending |
| S4 | Complete uninstall cleanup | pending |
| W1 | `admin_enqueue_scripts` hook | pending |
| W2 | Guard empty Site ID | pending |
| W3 | Simplify `load_i18n` | pending |
| Q1 | Option key constant | pending |
| Q2 | Cache settings array | pending |
| Q3 | Update PHP minimum version | pending |
| Q4 | `sprintf()` in shortcodes | pending |
| Q5 | Fix `wp_make_link_relative()` | pending |
| Q6 | PHPDoc blocks | pending |
| M1 | Remove `index.php` stubs | pending |
