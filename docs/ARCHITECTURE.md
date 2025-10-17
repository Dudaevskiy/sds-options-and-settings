# Архітектура плагіна SDStudio Options and Settings

## Огляд

Плагін побудований на основі об'єктно-орієнтованого підходу з використанням паттерну MVC (Model-View-Controller) та централізованою системою управління хуками WordPress.

## Основні компоненти

### 1. Класи ядра (Core Classes)

#### Sds_Options_And_Settings
**Розташування:** `includes/class-sds-options-and-settings.php`

**Призначення:** Головний клас-оркестратор, який координує всю роботу плагіна.

**Властивості:**
```php
protected $loader;        // Екземпляр Loader класу
protected $plugin_name;   // 'sds-options-and-settings'
protected $version;       // Версія плагіна
```

**Методи:**

| Метод | Тип доступу | Призначення |
|-------|------------|-------------|
| `__construct()` | public | Ініціалізація плагіна, завантаження залежностей |
| `load_dependencies()` | private | Підключення необхідних класів |
| `set_locale()` | private | Налаштування інтернаціоналізації |
| `define_admin_hooks()` | private | Реєстрація хуків адміністративної панелі |
| `define_public_hooks()` | private | Реєстрація публічних хуків |
| `run()` | public | Запуск виконання всіх зареєстрованих хуків |
| `get_plugin_name()` | public | Отримання назви плагіна |
| `get_loader()` | public | Отримання екземпляра Loader |
| `get_version()` | public | Отримання версії плагіна |

**Потік виконання:**
```
__construct()
    ├── load_dependencies()
    │   ├── require Loader
    │   ├── require i18n
    │   ├── require Admin
    │   ├── require Public
    │   └── new Loader()
    ├── set_locale()
    │   └── loader->add_action('plugins_loaded', i18n, 'load_plugin_textdomain')
    ├── define_admin_hooks()
    │   ├── new Admin(plugin_name, version)
    │   ├── loader->add_action('admin_enqueue_scripts', admin, 'enqueue_styles')
    │   └── loader->add_action('admin_enqueue_scripts', admin, 'enqueue_scripts')
    └── define_public_hooks()
        ├── new Public(plugin_name, version)
        ├── loader->add_action('wp_enqueue_scripts', public, 'enqueue_styles')
        └── loader->add_action('wp_enqueue_scripts', public, 'enqueue_scripts')

run()
    └── loader->run()
```

---

#### Sds_Options_And_Settings_Loader
**Розташування:** `includes/class-sds-options-and-settings-loader.php`

**Призначення:** Централізоване управління WordPress хуками (actions та filters).

**Властивості:**
```php
protected $actions;  // Масив зареєстрованих дій
protected $filters;  // Масив зареєстрованих фільтрів
```

**Структура елемента хука:**
```php
[
    'hook'          => 'wp_enqueue_scripts',  // Назва хука WordPress
    'component'     => $object_instance,      // Об'єкт класу
    'callback'      => 'method_name',         // Назва методу
    'priority'      => 10,                    // Пріоритет виконання
    'accepted_args' => 1                      // Кількість аргументів
]
```

**Методи:**

| Метод | Призначення | Параметри |
|-------|-------------|-----------|
| `__construct()` | Ініціалізація порожніх масивів actions/filters | - |
| `add_action()` | Додати дію до черги | $hook, $component, $callback, $priority=10, $accepted_args=1 |
| `add_filter()` | Додати фільтр до черги | $hook, $component, $callback, $priority=10, $accepted_args=1 |
| `add()` | Внутрішній метод додавання хука | $hooks, $hook, $component, $callback, $priority, $accepted_args |
| `run()` | Виконати всі зареєстровані хуки | - |

**Алгоритм роботи:**
```php
// 1. Реєстрація хуків
$loader->add_action('init', $object, 'method_name', 10, 1);

// 2. Зберігання в масиві
$this->actions[] = [/* hook data */];

// 3. Виконання при виклику run()
foreach ($this->actions as $hook) {
    add_action($hook['hook'], [$hook['component'], $hook['callback']], ...);
}
```

**Переваги підходу:**
- Централізоване управління хуками
- Легко відстежити всі зареєстровані хуки
- Відокремлення логіки реєстрації від бізнес-логіки
- Можливість легкого тестування

---

#### Sds_Options_And_Settings_i18n
**Розташування:** `includes/class-sds-options-and-settings-i18n.php`

**Призначення:** Управління інтернаціоналізацією та локалізацією.

**Методи:**
```php
public function load_plugin_textdomain() {
    load_plugin_textdomain(
        'sds-options-and-settings',  // Text domain
        false,
        dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
    );
}
```

**Використання перекладів:**
```php
__('Text to translate', 'sds-options-and-settings')
_e('Echo translated text', 'sds-options-and-settings')
_n('Singular', 'Plural', $count, 'sds-options-and-settings')
```

**Структура файлів перекладів:**
```
languages/
├── sds-options-and-settings-uk.po      # Українська (source)
├── sds-options-and-settings-uk.mo      # Українська (compiled)
├── sds-options-and-settings-en_US.po   # Англійська
└── sds-options-and-settings-en_US.mo
```

---

#### Sds_Options_And_Settings_Activator
**Розташування:** `includes/class-sds-options-and-settings-activator.php`

**Призначення:** Виконання коду при активації плагіна.

**Методи:**
```php
public static function activate() {
    // TODO: Додати код активації
    // Наприклад:
    // - Створення таблиць БД
    // - Встановлення default налаштувань
    // - Flush rewrite rules
}
```

**Підключення:**
```php
register_activation_hook(__FILE__, 'activate_sds_options_and_settings');
```

---

#### Sds_Options_And_Settings_Deactivator
**Розташування:** `includes/class-sds-options-and-settings-deactivator.php`

**Призначення:** Виконання коду при деактивації плагіна.

**Методи:**
```php
public static function deactivate() {
    // TODO: Додати код деактивації
    // Наприклад:
    // - Очистка кешу
    // - Flush rewrite rules
    // - Видалення тимчасових даних
}
```

**Підключення:**
```php
register_deactivation_hook(__FILE__, 'deactivate_sds_options_and_settings');
```

---

### 2. Класи адміністративної панелі

#### Sds_Options_And_Settings_Admin
**Розташування:** `admin/class-sds-options-and-settings-admin.php`

**Властивості:**
```php
private $plugin_name;  // Назва плагіна
private $version;      // Версія плагіна
```

**Методи:**

| Метод | Hook | Призначення |
|-------|------|-------------|
| `__construct()` | - | Ініціалізація з назвою та версією |
| `enqueue_styles()` | admin_enqueue_scripts | Підключення CSS |
| `enqueue_scripts()` | admin_enqueue_scripts | Підключення JavaScript |

**Підключення стилів:**
```php
wp_enqueue_style(
    $this->plugin_name,
    plugin_dir_url(__FILE__) . 'css/sds-options-and-settings-admin.css',
    [],
    $this->version,
    'all'
);
```

**Підключення скриптів:**
```php
wp_enqueue_script(
    $this->plugin_name,
    plugin_dir_url(__FILE__) . 'js/sds-options-and-settings-admin.js',
    ['jquery'],
    $this->version,
    false
);
```

---

### 3. Класи публічної частини

#### Sds_Options_And_Settings_Public
**Розташування:** `public/class-sds-options-and-settings-public.php`

**Структура аналогічна Admin класу.**

**Методи:**

| Метод | Hook | Призначення |
|-------|------|-------------|
| `__construct()` | - | Ініціалізація |
| `enqueue_styles()` | wp_enqueue_scripts | Підключення CSS |
| `enqueue_scripts()` | wp_enqueue_scripts | Підключення JavaScript |

---

## Модульна система

### Структура модулів

Плагін використовує модульну архітектуру - кожна функція в окремому файлі:

```
root/
├── _Redux_Framework_Parser_POST_data.php      # Парсинг форм
├── _SDStudio__PAGE_SPEED_FIXEs.php           # Оптимізація швидкості
├── _SDStudio___PUBLISH_POSTS.php             # Контроль публікації
├── _SDStudio_login_page.php                  # Кастомізація логіну
├── _SDStudio_SweetAlert2.php                 # Інтеграція SweetAlert2
├── _SDStudio___Yandex.php                    # Yandex Metrika
├── _SDStudio___Google_ADS.php                # Google Ads
└── [25+ інших модулів]
```

### Підключення модулів

**Розташування:** `sds-options-and-settings.php` → функція `run_sds_options_and_settings()`

```php
function run_sds_options_and_settings() {
    $plugin = new Sds_Options_And_Settings();
    $plugin->run();

    // Підключення модулів
    require_once plugin_dir_path(__FILE__) . '_WORKER.php';
    require_once plugin_dir_path(__FILE__) . '_SDStudio_login_page.php';
    // ... інші модулі
}
```

### Структура типового модуля

```php
<?php
/**
 * Назва модуля
 *
 * @package    Sds_Options_And_Settings
 * @subpackage Features
 */

// Запобігання прямого доступу
if (!defined('ABSPATH')) {
    exit;
}

// Отримання налаштувань Redux
$redux = get_option('redux_sds_options_and_settings');

// Перевірка чи ввімкнений модуль
if (isset($redux['enable_feature_name']) && $redux['enable_feature_name']) {

    // Реєстрація хуків
    add_action('init', 'sdstudio_feature_init');
    add_filter('the_content', 'sdstudio_feature_content');

    // Функції модуля
    function sdstudio_feature_init() {
        // Ініціалізація
    }

    function sdstudio_feature_content($content) {
        // Модифікація контенту
        return $content;
    }
}
```

---

## Система налаштувань

### Redux Framework

**Версія:** 4.4+
**Composer:** `redux-framework/redux-framework`

**Ключ опцій:**
```php
$redux = get_option('redux_sds_options_and_settings');
```

### Структура налаштувань

```php
[
    // Загальні налаштування
    'enable_sweetalert2' => true,

    // Логін
    'logo-login-page-posts-sds-options-and-settings' => 'https://...',
    'background-page-posts-sds-options-and-settings' => '#ffffff',

    // Редактор
    'enable_publish_posts_sds-options-and-settings' => true,
    'enable_editposts_relfollow_posts_sds-options-and-settings' => true,

    // Аналітика
    'yandex_metrika_id' => '12345678',
    'google_tag_manager_id' => 'GTM-XXXXXX',

    // ... сотні інших опцій
]
```

### Доступ до налаштувань

```php
// В модулях
$redux = get_option('redux_sds_options_and_settings');

// Перевірка окремої опції
if (isset($redux['option_name']) && $redux['option_name']) {
    // Опція ввімкнена
}

// Отримання значення
$value = isset($redux['option_name']) ? $redux['option_name'] : 'default';
```

---

## Потік виконання

### 1. Активація плагіна

```
WordPress
    └── register_activation_hook(__FILE__)
        └── activate_sds_options_and_settings()
            └── Sds_Options_And_Settings_Activator::activate()
                └── [порожньо - TODO]
```

### 2. Завантаження плагіна

```
WordPress loads plugin
    └── require sds-options-and-settings.php
        └── run_sds_options_and_settings()
            ├── new Sds_Options_And_Settings()
            │   ├── load_dependencies()
            │   ├── set_locale()
            │   ├── define_admin_hooks()
            │   └── define_public_hooks()
            ├── $plugin->run()
            │   └── $loader->run()
            │       ├── register all actions
            │       └── register all filters
            └── require 30+ feature modules
                └── each module registers own hooks
```

### 3. WordPress lifecycle

```
WordPress Init
    ├── plugins_loaded
    │   └── load_plugin_textdomain()
    ├── init
    │   └── [модулі реєструють свої хуки]
    ├── admin_init (якщо admin)
    │   ├── SDStudioPluginName_sds_options_and_settings()
    │   └── SDStudioPluginVersion_sds_options_and_settings()
    ├── admin_enqueue_scripts (якщо admin)
    │   ├── admin->enqueue_styles()
    │   └── admin->enqueue_scripts()
    ├── wp_enqueue_scripts (frontend)
    │   ├── public->enqueue_styles()
    │   ├── public->enqueue_scripts()
    │   └── sdstudio_myajax_data()
    └── wp_head / wp_footer
        └── [модулі виводять свій код]
```

### 4. Деактивація

```
WordPress
    └── register_deactivation_hook(__FILE__)
        └── deactivate_sds_options_and_settings()
            └── Sds_Options_And_Settings_Deactivator::deactivate()
                └── [порожньо - TODO]
```

---

## Система хуків

### Реєстрація через Loader

```php
// В класі Sds_Options_And_Settings
$this->loader->add_action('hook_name', $object, 'method', $priority, $args);
$this->loader->add_filter('filter_name', $object, 'method', $priority, $args);
```

### Пряма реєстрація в модулях

```php
// В feature файлах
add_action('init', 'function_name', 10);
add_filter('the_content', 'filter_function', 10, 1);
```

### Основні використовувані хуки

**Actions:**
- `plugins_loaded` - Завантаження перекладів
- `init` - Ініціалізація модулів
- `admin_init` - Ініціалізація адмін-панелі
- `admin_enqueue_scripts` - Підключення адмін скриптів
- `wp_enqueue_scripts` - Підключення публічних скриптів
- `login_head` - Кастомізація сторінки входу
- `save_post` - Валідація при збереженні
- `wp_head` - Вивід в <head>
- `wp_footer` - Вивід перед </body>

**Filters:**
- `wp_nav_menu_objects` - Модифікація меню
- `the_content` - Модифікація контенту
- `rank_math/frontend/show_keywords` - Rank Math інтеграція

---

## Безпека

### Захист від прямого доступу

```php
// В кожному файлі
if (!defined('WPINC')) {
    die;
}

// Або
if (!defined('ABSPATH')) {
    exit;
}
```

### Перевірка прав доступу

```php
// Перевірка адміністратора
if (!is_admin()) {
    return;
}

// Перевірка можливостей
if (!current_user_can('manage_options')) {
    return;
}
```

### Санітизація даних

Redux Framework автоматично санітизує всі дані налаштувань.

Для custom даних:
```php
$value = sanitize_text_field($_POST['field']);
$email = sanitize_email($_POST['email']);
$url = esc_url($_POST['url']);
```

### Nonce перевірка

Redux Framework використовує власну nonce перевірку.

Для custom форм:
```php
wp_nonce_field('action_name', 'nonce_name');

if (!wp_verify_nonce($_POST['nonce_name'], 'action_name')) {
    die('Security check failed');
}
```

---

## Стандарти кодування

### WordPress Coding Standards

Плагін дотримується WordPress Coding Standards:
- Іменування класів: `Class_Name_With_Underscores`
- Іменування функцій: `function_name_with_underscores`
- Іменування змінних: `$variable_name_with_underscores`
- Префікси: `sdstudio_`, `sds_options_and_settings_`

### PHPDoc

```php
/**
 * Short description
 *
 * Long description
 *
 * @since    1.0.0
 * @access   private/public/protected
 * @param    string  $param  Description
 * @return   string          Description
 */
```

### Відступи

- Таби для відступів
- Пробіли для вирівнювання

---

## Розширення плагіна

### Додавання нового модуля

1. **Створити файл модуля:**
```php
// _SDStudio_My_New_Feature.php
<?php
if (!defined('ABSPATH')) exit;

$redux = get_option('redux_sds_options_and_settings');

if (isset($redux['enable_my_feature']) && $redux['enable_my_feature']) {
    add_action('init', 'sdstudio_my_feature_init');

    function sdstudio_my_feature_init() {
        // Ваш код
    }
}
```

2. **Підключити в головному файлі:**
```php
// sds-options-and-settings.php
function run_sds_options_and_settings() {
    // ...
    require_once plugin_dir_path(__FILE__) . '_SDStudio_My_New_Feature.php';
}
```

3. **Додати налаштування в Redux** (опціонально)

### Додавання хука в core

```php
// includes/class-sds-options-and-settings.php
private function define_admin_hooks() {
    $plugin_admin = new Sds_Options_And_Settings_Admin(...);

    $this->loader->add_action('admin_menu', $plugin_admin, 'add_menu_page');
}
```

---

## Оптимізація продуктивності

### Умовне завантаження

```php
// Завантажувати тільки в адмін-панелі
if (is_admin()) {
    require_once 'admin-feature.php';
}

// Завантажувати тільки на фронтенді
if (!is_admin()) {
    require_once 'public-feature.php';
}
```

### Кешування

```php
// Використання transients
$data = get_transient('sdstudio_cache_key');
if (false === $data) {
    $data = expensive_operation();
    set_transient('sdstudio_cache_key', $data, HOUR_IN_SECONDS);
}
```

### Lazy Loading

```php
// Підключення скриптів тільки коли потрібно
add_action('wp_enqueue_scripts', function() {
    if (is_singular('post')) {
        wp_enqueue_script('feature-script');
    }
});
```

---

## Тестування

### Unit тести (TODO)

```php
// tests/test-main-class.php
class Test_Main_Class extends WP_UnitTestCase {
    public function test_plugin_initialization() {
        $plugin = new Sds_Options_And_Settings();
        $this->assertNotNull($plugin->get_loader());
    }
}
```

### Мануальне тестування

1. Активація/деактивація
2. Перевірка налаштувань Redux
3. Тестування кожного модуля
4. Перевірка продуктивності
5. Тестування на різних версіях PHP

---

## Висновок

Архітектура плагіна побудована на:
- **Модульності** - легко додавати/видаляти функції
- **Централізації** - всі хуки через Loader
- **Розділенні відповідальності** - кожен клас має свою роль
- **Розширюваності** - легко додавати нову функціональність
- **Безпеці** - захист від прямого доступу, санітизація даних

Ця архітектура дозволяє легко підтримувати та розширювати плагін.
