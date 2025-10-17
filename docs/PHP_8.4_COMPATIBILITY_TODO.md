# PHP 8.4 Compatibility - Critical Fixes TODO

## Статус: НЕ ГОТОВИЙ ДО PHP 8.4

**Поточна версія:** 2.2.60
**Вимоги:** PHP 8.2+
**Протестовано до:** PHP 8.3
**Цільова версія:** PHP 8.4

---

## ПРІОРИТЕТ 1 - КРИТИЧНІ ВИПРАВЛЕННЯ (Зробити негайно!)

### ❌ 1. Виправити доступ до невизначених ключів масиву

**Файл:** `_SDStudio___SHORTCODES_AUTOGEN_PAGES.php`
**Рядки:** 245, 598

**Проблема:**
```php
$sdstudio_current_post_lang = apply_filters('wpml_post_language_details', NULL, get_the_id())["language_code"];
```

**Виправлення:**
```php
$language_details = apply_filters('wpml_post_language_details', NULL, get_the_id());
$sdstudio_current_post_lang = is_array($language_details) && isset($language_details['language_code'])
    ? $language_details['language_code']
    : '';
```

**Локації для виправлення:**
- [ ] Рядок 245
- [ ] Рядок 598

---

### ❌ 2. Виправити прямий доступ до масиву з функцій

**Файл:** `_SDStudio_arrows.php`
**Рядок:** 334

**Проблема:**
```php
$prev_thumbnail_url = wp_get_attachment_image_src($prev_thumbnail_id)[0];
```

**Виправлення:**
```php
$thumbnail_array = wp_get_attachment_image_src($prev_thumbnail_id);
$prev_thumbnail_url = ($thumbnail_array && is_array($thumbnail_array)) ? $thumbnail_array[0] : '';
```

**Локації для виправлення:**
- [ ] Рядок 334 - prev_thumbnail_url
- [ ] Перевірити аналогічні конструкції в усьому файлі

---

**Файл:** `_SDStudio_arrows.php`
**Рядок:** 376

**Проблема:**
```php
// Аналогічна проблема з next_thumbnail
```

**Виправлення:**
```php
$thumbnail_array = wp_get_attachment_image_src($next_thumbnail_id);
$next_thumbnail_url = ($thumbnail_array && is_array($thumbnail_array)) ? $thumbnail_array[0] : '';
```

**Локації для виправлення:**
- [ ] Рядок 376

---

### ❌ 3. Замінити застарілу функцію get_page()

**Файл:** `_SDStudio_FRONTEND_ELEMENTOR.php`
**Рядок:** 444

**Проблема:**
```php
$posts_page = get_page($posts_page_id);
```

**Виправлення:**
```php
$posts_page = get_post($posts_page_id);
if (!($posts_page instanceof WP_Post)) {
    $posts_page_title = '';
} else {
    $posts_page_title = $posts_page->post_title;
}
```

**Локації для виправлення:**
- [ ] Рядок 444
- [ ] Перевірити весь файл на наявність get_page()

---

### ❌ 4. Додати перевірки для $_SERVER

**Файл:** `_SDStudio___SHORTCODES_AUTOGEN_PAGES.php`
**Рядки:** 89, 97, 593, 636, 641

**Проблема:**
```php
$_SERVER['HTTP_HOST']  // Без перевірки
```

**Виправлення:**
```php
$host = isset($_SERVER['HTTP_HOST'])
    ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST']))
    : 'localhost';
$email = 'info@' . $host;
```

**Локації для виправлення:**
- [ ] Рядок 89
- [ ] Рядок 97
- [ ] Рядок 593
- [ ] Рядок 636
- [ ] Рядок 641

---

**Файл:** `_SDStudio_ADMIN_disable_aggressive_update.php`
**Рядок:** 48

**Проблема:**
```php
md5($_SERVER['HTTP_USER_AGENT'])
```

**Виправлення:**
```php
$user_agent = isset($_SERVER['HTTP_USER_AGENT'])
    ? md5(sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])))
    : '';
```

**Локації для виправлення:**
- [ ] Рядок 48

---

## ПРІОРИТЕТ 2 - ВИСОКИЙ ПРІОРИТЕТ (Зробити найближчим часом)

### ⚠️ 5. Виправити list() з потенційно некоректним масивом

**Файл:** `_SDStudio___SHORTCODES_AUTOGEN_PAGES.php`
**Рядок:** 532

**Проблема:**
```php
list($key, $value) = explode('=', $pair, 2);
```

**Виправлення:**
```php
$parts = explode('=', $pair, 2);
if (count($parts) === 2) {
    [$key, $value] = $parts;
    $key = trim($key);
    $value = trim($value, '"\'');
} else {
    continue; // Пропустити невалідний елемент
}
```

**Локації для виправлення:**
- [ ] Рядок 532

---

### ⚠️ 6. Додати типізацію параметрів функцій

**Файл:** `_SDStudio___SHORTCODES_AUTOGEN_PAGES.php`
**Рядок:** 301

**Проблема:**
```php
function SDStudio_PAGE_AUTOGEN_title_updater($title, $id = null) {
```

**Виправлення:**
```php
function SDStudio_PAGE_AUTOGEN_title_updater(string $title, ?int $id = null): mixed {
    // Тіло функції
}
```

**Локації для виправлення:**
- [ ] Рядок 301 - SDStudio_PAGE_AUTOGEN_title_updater()
- [ ] Перевірити всі функції в файлі на відсутність типів

---

### ⚠️ 7. Додати типи повернення в основні класи

**Файл:** `includes/class-sds-options-and-settings-loader.php`
**Рядки:** 66, 80, 98, 117

**Проблема:**
```php
public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
    // Немає return type
}
```

**Виправлення:**
```php
public function add_action(string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1): void {
    $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
}

public function add_filter(string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1): void {
    $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
}

private function add(array $hooks, string $hook, object $component, string $callback, int $priority, int $accepted_args): array {
    // ...
}

public function run(): void {
    // ...
}
```

**Локації для виправлення:**
- [ ] Рядок 66 - add_action()
- [ ] Рядок 80 - add_filter()
- [ ] Рядок 98 - add()
- [ ] Рядок 117 - run()

---

**Файл:** `admin/class-sds-options-and-settings-admin.php`
**Рядки:** 62, 85

**Проблема:**
```php
public function enqueue_styles() {
    // Немає return type
}
```

**Виправлення:**
```php
public function enqueue_styles(): void {
    // ...
}

public function enqueue_scripts(): void {
    // ...
}
```

**Локації для виправлення:**
- [ ] Рядок 62 - enqueue_styles()
- [ ] Рядок 85 - enqueue_scripts()

---

**Файл:** `public/class-sds-options-and-settings-public.php`
**Рядки:** ~60-80 (аналогічно admin класу)

**Виправлення:**
```php
public function enqueue_styles(): void {
    // ...
}

public function enqueue_scripts(): void {
    // ...
}
```

**Локації для виправлення:**
- [ ] enqueue_styles()
- [ ] enqueue_scripts()

---

**Файл:** `includes/class-sds-options-and-settings.php`
**Рядки:** 100, 138, 153, 169, 183, 194, 204, 214

**Виправлення:**
```php
private function load_dependencies(): void {
    // ...
}

private function set_locale(): void {
    // ...
}

private function define_admin_hooks(): void {
    // ...
}

private function define_public_hooks(): void {
    // ...
}

public function run(): void {
    $this->loader->run();
}

public function get_plugin_name(): string {
    return $this->plugin_name;
}

public function get_loader(): Sds_Options_And_Settings_Loader {
    return $this->loader;
}

public function get_version(): string {
    return $this->version;
}
```

**Локації для виправлення:**
- [ ] Рядок 100 - load_dependencies()
- [ ] Рядок 138 - set_locale()
- [ ] Рядок 153 - define_admin_hooks()
- [ ] Рядок 169 - define_public_hooks()
- [ ] Рядок 183 - run()
- [ ] Рядок 194 - get_plugin_name()
- [ ] Рядок 204 - get_loader()
- [ ] Рядок 214 - get_version()

---

### ⚠️ 8. Замінити нестрогі порівняння

**Файл:** `_SDStudio_FRONTEND_ELEMENTOR.php`
**Рядок:** 39

**Проблема:**
```php
if($count==''){  // Loose comparison
```

**Виправлення:**
```php
if ($count === '') {  // Strict comparison
```

**Локації для виправлення:**
- [ ] Рядок 39
- [ ] Пошукати всі випадки `==` та замінити на `===`
- [ ] Пошукати всі випадки `!=` та замінити на `!==`

---

## ПРІОРИТЕТ 3 - СЕРЕДНІЙ ПРІОРИТЕТ

### 🔧 9. Покращити перевірку типів об'єктів

**Всі файли з глобальними змінними**

**Проблема:**
```php
global $sitepress;
if ($sitepress) {
    // Використання без перевірки типу
}
```

**Виправлення:**
```php
global $sitepress;
if ($sitepress instanceof SitePress) {
    // Безпечне використання
}
```

**Файли для перевірки:**
- [ ] `_SDStudio___SHORTCODES_AUTOGEN_PAGES.php`
- [ ] `sds-options-and-settings.php` (рядок 231)
- [ ] Всі файли, що використовують WPML

---

### 🔧 10. Виправити змішані типи змінних

**Файл:** `_SDStudio_FRONTEND_ELEMENTOR.php`
**Рядки:** 453-455

**Проблема:**
```php
$next_thumbnail_array = $next_thumbnail_id ? wp_get_attachment_image_src($next_thumbnail_id) : false;
$next_thumbnail_url = $next_thumbnail_array ? $next_thumbnail_array[0] : '';
```

**Виправлення:**
```php
$next_thumbnail_array = ($next_thumbnail_id)
    ? wp_get_attachment_image_src($next_thumbnail_id)
    : array();
$next_thumbnail_url = (is_array($next_thumbnail_array) && isset($next_thumbnail_array[0]))
    ? $next_thumbnail_array[0]
    : '';
```

**Локації для виправлення:**
- [ ] Рядки 453-455
- [ ] Аналогічні конструкції з prev_thumbnail

---

## ПРІОРИТЕТ 4 - НИЗЬКИЙ ПРІОРИТЕТ (Покращення)

### 💡 11. Покращити безпеку nonce перевірки

**Файл:** `_SDStudio_FRONTEND_ELEMENTOR.php`
**Рядок:** 120

**Проблема:**
```php
if (!wp_verify_nonce($_REQUEST['nonce'], 'pt_like_it_nonce') || !isset($_REQUEST['nonce'])) {
```

**Виправлення:**
```php
if (!isset($_REQUEST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['nonce'])), 'pt_like_it_nonce')) {
```

**Локації для виправлення:**
- [ ] Рядок 120

---

### 💡 12. Замінити header() на wp_redirect()

**Файл:** `_SDStudio_login_exit_links.php`
**Рядок:** 184

**Проблема:**
```php
header("Location: $location");
```

**Виправлення:**
```php
wp_redirect(esc_url($location));
exit;
```

**Локації для виправлення:**
- [ ] Рядок 184

---

### 💡 13. Додати санітизацію для вводу користувача

**Множинні файли**

**Проблема:**
```php
$post_id = $_REQUEST['post_id'];  // Без санітизації
```

**Виправлення:**
```php
$post_id = isset($_REQUEST['post_id'])
    ? absint($_REQUEST['post_id'])
    : 0;
```

**Файли для перевірки:**
- [ ] `_SDStudio_FRONTEND_ELEMENTOR.php`
- [ ] Всі файли з `$_REQUEST`, `$_GET`, `$_POST`

---

### 💡 14. Перевірити залежності Composer

**composer.json**

**Перевірити сумісність:**
- [ ] `redux-framework/redux-framework` ^4.4 - перевірити PHP 8.4
- [ ] `cebe/markdown` ^1.2 - перевірити PHP 8.4
- [ ] `composer/installers` ^2.2 - перевірити PHP 8.4

**Команда:**
```bash
composer update --dry-run
composer outdated
```

---

## ТЕСТУВАННЯ

### Налаштування для тестування

1. **Увімкнути debug режим** в `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);

// Додатково для PHP 8.4
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

2. **Тестове середовище:**
- [ ] Встановити PHP 8.4-beta або RC
- [ ] Активувати плагін
- [ ] Перевірити всі модулі Redux
- [ ] Тестувати всі shortcodes
- [ ] Перевірити логи помилок

### Чеклист тестування

**Основна функціональність:**
- [ ] Активація/деактивація плагіна
- [ ] Збереження налаштувань Redux
- [ ] SweetAlert2 алерти
- [ ] Кастомна сторінка логіну
- [ ] Rel-атрибути в редакторі
- [ ] Обов'язкові featured images
- [ ] Інтеграція з Elementor

**Інтеграції:**
- [ ] WPML підтримка
- [ ] Yandex Metrika
- [ ] Google Ads
- [ ] Google Tag Manager
- [ ] Contact Form 7
- [ ] AddToAny

**Продуктивність:**
- [ ] jQuery оптимізація
- [ ] Lazy loading
- [ ] Розміри зображень

---

## АВТОМАТИЗАЦІЯ

### PHPStan конфігурація

Створити `phpstan.neon`:
```neon
parameters:
    level: 8
    paths:
        - includes
        - admin
        - public
    excludePaths:
        - vendor
    phpVersion: 80400
```

Команда:
```bash
composer require --dev phpstan/phpstan
vendor/bin/phpstan analyze
```

### Rector конфігурація

Створити `rector.php`:
```php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/includes',
        __DIR__ . '/admin',
        __DIR__ . '/public',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84
    ]);
};
```

---

## ПРОГРЕС

**Загальний прогрес:** 0% (0/14 завдань виконано)

### За пріоритетами:

- **Пріоритет 1 (Критичний):** 0/4 ☐☐☐☐
- **Пріоритет 2 (Високий):** 0/4 ☐☐☐☐
- **Пріоритет 3 (Середній):** 0/2 ☐☐
- **Пріоритет 4 (Низький):** 0/4 ☐☐☐☐

---

## ЧАСОВА ОЦІНКА

- **Пріоритет 1:** ~2-3 години
- **Пріоритет 2:** ~3-4 години
- **Пріоритет 3:** ~1-2 години
- **Пріоритет 4:** ~1-2 години
- **Тестування:** ~2-3 години

**Загальний час:** 9-14 годин

---

## ВЕРСІЯ ПІСЛЯ ВИПРАВЛЕНЬ

Після всіх виправлень оновити:
- [ ] Version в `sds-options-and-settings.php`: `2.3.0`
- [ ] "Tested up to PHP": `8.4`
- [ ] Додати в CHANGELOG
- [ ] Оновити README.md

---

## ПРИМІТКИ

1. Перш ніж починати виправлення, створити backup
2. Тестувати кожне виправлення окремо
3. Комітити часто з описовими повідомленнями
4. Після всіх виправлень провести повне регресійне тестування
5. Перевірити на production-подібному середовищі перед релізом

---

**Остання оновлення:** 2025-10-17
**Статус:** TODO - Потребує виправлень
