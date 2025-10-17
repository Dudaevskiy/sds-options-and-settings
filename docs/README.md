# SDStudio Options and Settings Plugin

## Загальна інформація

**Назва плагіна:** SDStudio addons, options and settings
**Версія:** 2.2.60
**Автор:** Serhii Dudchenko
**URI:** https://sdstudio.top
**Ліцензія:** GPL-2.0+
**Вимоги PHP:** 8.2+
**Протестовано до PHP:** 8.3
**GitHub:** https://github.com/Dudaevskiy/sds-options-and-settings

## Опис

Комплексний набір корисних доповнень, налаштувань та покращень для WordPress сайтів. Плагін надає розширені можливості для:
- Налаштування адміністративної панелі
- Оптимізації продуктивності
- Покращення редактора постів
- Інтеграції з аналітикою та трекінгом
- Кастомізації зовнішнього вигляду

## Основні можливості

### 🎨 Налаштування інтерфейсу
- Кастомізація сторінки входу (логотип, фон)
- Налаштування адмін-бару
- Гарячі клавіші для входу в систему
- Покращений редактор коду

### ⚡ Оптимізація продуктивності
- Керування jQuery (відключення/інлайнінг)
- Lazy loading для зображень
- Оптимізація розмірів зображень
- Парсинг форм без обмеження max_input_vars

### 📝 Покращення редактора
- Додавання rel-атрибутів до посилань (nofollow, sponsored, ugc)
- Обов'язкове зображення для публікації
- Відключення повноекранного режиму Gutenberg
- Підтримка Rank Math ключових слів

### 📊 Інтеграція аналітики
- Yandex Metrika
- Google Tag Manager
- Google Ads
- Mail.ru tracking
- Admitad partner tracking

### 🔔 Повідомлення та алерти
- SweetAlert2 інтеграція
- Підтримка Contact Form 7
- AddToAny sharing сповіщення

### 🖼️ Робота з медіа
- Кастомні розміри зображень
- Налаштування якості зображень
- Оптимізація галерей

## Структура плагіна

```
sds-options-and-settings/
├── admin/                          # Адміністративна частина
│   ├── class-sds-options-and-settings-admin.php
│   ├── js/
│   ├── css/
│   └── partials/
├── public/                         # Публічна частина
│   ├── class-sds-options-and-settings-public.php
│   ├── js/
│   ├── css/
│   └── partials/
├── includes/                       # Основні класи
│   ├── class-sds-options-and-settings.php
│   ├── class-sds-options-and-settings-loader.php
│   ├── class-sds-options-and-settings-i18n.php
│   ├── class-sds-options-and-settings-activator.php
│   └── class-sds-options-and-settings-deactivator.php
├── vendor/                         # Composer залежності
│   ├── redux-framework/
│   └── cebe/markdown/
├── sweetalert2/                    # SweetAlert2 бібліотека
├── AddToAny/                       # AddToAny інтеграція
├── docs/                           # Документація
└── [30+ feature files]             # Модулі функціональності
```

## Архітектура

### Основні класи

#### 1. Sds_Options_And_Settings
**Файл:** `includes/class-sds-options-and-settings.php`
**Призначення:** Головний клас-оркестратор плагіна

**Методи:**
- `load_dependencies()` - Завантаження залежностей
- `set_locale()` - Налаштування інтернаціоналізації
- `define_admin_hooks()` - Реєстрація хуків адмін-панелі
- `define_public_hooks()` - Реєстрація публічних хуків
- `run()` - Запуск плагіна

#### 2. Sds_Options_And_Settings_Loader
**Файл:** `includes/class-sds-options-and-settings-loader.php`
**Призначення:** Управління WordPress хуками

**Методи:**
- `add_action($hook, $component, $callback, $priority, $accepted_args)`
- `add_filter($hook, $component, $callback, $priority, $accepted_args)`
- `run()` - Виконання всіх зареєстрованих хуків

#### 3. Sds_Options_And_Settings_Admin
**Файл:** `admin/class-sds-options-and-settings-admin.php`
**Призначення:** Функціональність адмін-панелі

**Методи:**
- `enqueue_styles()` - Підключення CSS
- `enqueue_scripts()` - Підключення JavaScript

#### 4. Sds_Options_And_Settings_Public
**Файл:** `public/class-sds-options-and-settings-public.php`
**Призначення:** Публічна функціональність

**Методи:**
- `enqueue_styles()` - Підключення публічних CSS
- `enqueue_scripts()` - Підключення публічних JavaScript

## Залежності

### Composer
```json
{
  "redux-framework/redux-framework": "^4.4",
  "cebe/markdown": "^1.2",
  "composer/installers": "^2.2"
}
```

### JavaScript бібліотеки
- SweetAlert2 - Красиві алерти та повідомлення
- Tipso - Tooltip бібліотека
- AddToAny - Соціальний шеринг
- wpapi - WordPress REST API wrapper

## Шорткоди

### [bloginfo]
Виводить інформацію про блог

**Атрибути:**
- `info` - Тип інформації (name, description, url, тощо)
- `filter` - Фільтр (raw, display)

**Приклади:**
```php
[bloginfo info='name']              // Назва сайту
[bloginfo info='description']       // Опис сайту
[bloginfo info='url_not_https']     // URL без https://
[bloginfo info='link_site']         // Посилання на сайт
```

### [current_year]
Виводить поточний рік

**Приклад:**
```php
Copyright © [current_year]
```

## Хуки WordPress

### Actions (дії)
- `admin_init` - Ініціалізація адмін-панелі
- `plugins_loaded` - Завантаження перекладів
- `admin_enqueue_scripts` - Підключення адмін скриптів
- `wp_enqueue_scripts` - Підключення публічних скриптів
- `login_head` - Кастомізація сторінки входу
- `after_wp_tiny_mce` - Розширення TinyMCE
- `save_post` - Валідація при збереженні посту
- `enqueue_block_editor_assets` - Gutenberg налаштування

### Filters (фільтри)
- `wp_nav_menu_objects` - Модифікація меню (WPML підтримка)
- `rank_math/frontend/show_keywords` - Показ ключових слів Rank Math

## Налаштування

Всі налаштування плагіна зберігаються в Redux Framework під ключем:
```php
get_option('redux_sds_options_and_settings')
```

### Основні опції
- `enable_sweetalert2` - Увімкнути SweetAlert2
- `enable_hot_key_login-page-posts-sds-options-and-settings` - Гарячі клавіші
- `logo-login-page-posts-sds-options-and-settings` - Логотип входу
- `background-page-posts-sds-options-and-settings` - Фон сторінки входу
- `enable_publish_posts_sds-options-and-settings` - Контроль публікації
- `enable_editposts_relfollow_posts_sds-options-and-settings` - Rel атрибути

## AJAX

Плагін надає глобальний об'єкт AJAX:
```javascript
myajax.sdstudio_wp_ajax_url  // URL для AJAX запитів
```

## Константи

```php
SDS_OPTIONS_AND_SETTINGS_VERSION           // Версія плагіна
SDS_OPTIONS_AND_SETTINGS__PLUGIN_DIR       // Шлях до плагіна
SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL       // URL плагіна
SDS_OPTIONS_AND_SETTINGS_TD                // Text domain
```

## Життєвий цикл

### Активація
```
register_activation_hook()
→ activate_sds_options_and_settings()
→ Sds_Options_And_Settings_Activator::activate()
```

### Виконання
```
run_sds_options_and_settings()
→ new Sds_Options_And_Settings()
→ load_dependencies()
→ set_locale()
→ define_admin_hooks()
→ define_public_hooks()
→ run()
→ Завантаження 30+ модулів функціональності
```

### Деактивація
```
register_deactivation_hook()
→ deactivate_sds_options_and_settings()
→ Sds_Options_And_Settings_Deactivator::deactivate()
```

## Розширення функціональності

### Додавання нової функції

1. Створіть новий файл в кореневій директорії:
```php
// _SDStudio_My_Feature.php
<?php
if (!defined('ABSPATH')) exit;

$redux = get_option('redux_sds_options_and_settings');

if (isset($redux['enable_my_feature']) && $redux['enable_my_feature']) {
    // Ваш код
}
```

2. Підключіть файл в `sds-options-and-settings.php`:
```php
function run_sds_options_and_settings() {
    $plugin = new Sds_Options_And_Settings();
    $plugin->run();

    // ... інші підключення
    require_once plugin_dir_path(__FILE__) . '_SDStudio_My_Feature.php';
}
```

3. Додайте налаштування в Redux Framework

## Безпека

- Перевірка `is_admin()` для адміністративних функцій
- Використання nonce через Redux Framework
- Санітизація даних через Redux
- Перевірка `WPINC` для запобігання прямого доступу

## Підтримка

- **Документація:** https://techblog.sdstudio.top/blog
- **GitHub Issues:** https://github.com/Dudaevskiy/sds-options-and-settings/issues
- **Автор:** https://sdstudio.top

## Ліцензія

GPL-2.0+ - http://www.gnu.org/licenses/gpl-2.0.txt
