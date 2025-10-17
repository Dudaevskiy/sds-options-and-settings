# Модулі плагіна SDStudio Options and Settings

## Опис

Плагін використовує модульну архітектуру - кожна функція реалізована в окремому файлі. Це дозволяє легко вмикати/вимикати функціональність через Redux налаштування та підтримувати код.

## Структура модулів

Всі модулі розташовані в кореневій директорії плагіна та мають префікс `_SDStudio_` або `_Redux_`.

---

## Основні модулі

### 1. _WORKER.php
**Призначення:** Глобальні константи та базова ініціалізація

**Функціональність:**
- Визначення констант шляху до плагіна
- Визначення URL плагіна
- Встановлення text domain для перекладів
- Базова конфігурація плагіна

**Константи:**
```php
SDS_OPTIONS_AND_SETTINGS__PLUGIN_DIR  // Шлях до директорії
SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL  // URL плагіна
SDS_OPTIONS_AND_SETTINGS_TD           // Text domain
```

**Залежності:** Немає

**Redux опція:** Немає (завжди активний)

---

## Модулі оптимізації продуктивності

### 2. _SDStudio__PAGE_SPEED_FIXEs.php
**Призначення:** Оптимізація швидкості завантаження сторінки

**Функціональність:**
- Видалення/заміна jQuery стандартного WordPress
- Інлайн-підключення jQuery
- Відкладене завантаження скриптів
- Оптимізація черги завантаження ресурсів

**Redux опція:** `enable_page_speed_fixes`

**Хуки:**
- `wp_print_scripts` (priority 100) - Відключення jQuery
- `init` (priority 10) - Дереєстрація jQuery
- `wp_head` (priority 1) - Інлайн jQuery скрипт

**Налаштування:**
```php
$redux['jquery_mode'] = 'disable' | 'inline' | 'default';
```

---

### 3. _SDStudio____SCROLL_LAZY_LOADER.php
**Призначення:** Lazy loading для зображень при скролі

**Функціональність:**
- Відкладене завантаження зображень
- Покращення швидкості початкового завантаження
- Економія трафіку користувачів

**Redux опція:** `enable_lazy_loading`

**Підтримувані формати:**
- IMG теги
- Background images
- Picture елементи

---

## Модулі роботи з зображеннями

### 4. _SDStudio_add_images_sizes.php
**Призначення:** Додавання кастомних розмірів зображень

**Функціональність:**
- Реєстрація додаткових розмірів зображень
- Автоматична генерація thumbnails
- Підтримка ретина дисплеїв

**Хук:**
- `after_setup_theme` - Реєстрація розмірів

**Приклад розмірів:**
```php
add_image_size('sdstudio_large', 1920, 1080, true);
add_image_size('sdstudio_medium', 800, 600, false);
```

---

### 5. _SDStudio_image_settings.php
**Призначення:** Налаштування якості та параметрів зображень

**Функціональність:**
- Управління якістю JPEG компресії
- Налаштування WebP конвертації
- Оптимізація розмірів завантажених файлів

**Redux опції:**
```php
$redux['jpeg_quality'] = 85;  // 0-100
$redux['enable_webp'] = true;
```

---

### 6. _SDStudio_gallery_settings.php
**Призначення:** Налаштування WordPress галерей

**Функціональність:**
- Кастомізація виводу галерей
- Lightbox інтеграція
- Адаптивні сітки галерей

**Redux опція:** `enable_custom_gallery`

---

## Модулі редактора та публікації

### 7. _SDStudio___PUBLISH_POSTS.php
**Призначення:** Контроль публікації записів та розширення редактора

**Функціональність:**
- **Обов'язкове featured image** для публікації
- **Rel-атрибути** для посилань (nofollow, sponsored, ugc)
- **Відключення повноекранного режиму** Gutenberg
- **Показ Rank Math ключових слів** у редакторі
- **Контроль публікації** за email автора

**Redux опції:**
```php
$redux['enable_publish_posts_sds-options-and-settings'] = true;
$redux['enable_editposts_relfollow_posts_sds-options-and-settings'] = true;
$redux['enable_editposts_rankmatch_keywords_posts_sds-options-and-settings'] = true;
$redux['enable_disable_full_width_guthenberg_sds-options-and-settings'] = true;
```

**Хуки:**
- `after_wp_tiny_mce` - Додавання UI rel-атрибутів
- `save_post` - Валідація featured image
- `enqueue_block_editor_assets` - Gutenberg налаштування
- `rank_math/frontend/show_keywords` - Rank Math інтеграція

**JavaScript функції:**
```javascript
// Rel-атрибути
wpLink.getAttrs() // Розширено для підтримки custom rel
```

**CSS класи:**
```css
.sdstudio-rel-wrapper    /* Grid контейнер */
.sdstudio-rel-item       /* Окремий чекбокс */
```

---

### 8. _SDStudio_code_edit_addons.php
**Призначення:** Покращення редактора коду

**Функціональність:**
- Підсвічування синтаксису
- Автодоповнення коду
- Валідація коду

**Redux опція:** `enable_code_editor_enhancements`

---

## Модулі входу та безпеки

### 9. _SDStudio_login_page.php
**Призначення:** Кастомізація сторінки входу WordPress

**Функціональність:**
- Заміна логотипу WordPress на кастомний
- Зміна фонового зображення
- Зміна кольорової схеми
- Кастомні CSS стилі

**Redux опції:**
```php
$redux['logo-login-page-posts-sds-options-and-settings'] = 'https://...';
$redux['background-page-posts-sds-options-and-settings'] = '#ffffff';
$redux['login_custom_css'] = '...';
```

**Хук:**
- `login_head` - Вивід кастомних стилів

**Inline стилі:**
```css
#login h1 a {
    background-image: url(...);
    width: 320px;
    height: 100px;
}
body.login {
    background: url(...);
}
```

---

### 10. _SDStudio_hot_key_login.php
**Призначення:** Гарячі клавіші для швидкого доступу

**Функціональність:**
- `Ctrl+Shift+1` - Відкрити головну сторінку сайту
- `Ctrl+Shift+2` - Перейти в адмін-панель
- `Ctrl+Shift+3` - Google Analytics
- `Ctrl+Shift+4` - Google Search Console
- `Ctrl+5` - PageSpeed Insights
- `Ctrl+6` - GTmetrix
- `Ctrl+7` - WebPageTest

**Redux опція:** `enable_hot_key_login-page-posts-sds-options-and-settings`

**JavaScript:**
```javascript
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.key === '1') {
        // Перехід на головну
    }
});
```

---

### 11. _SDStudio_login_exit_links.php
**Призначення:** Додавання посилань входу/виходу

**Функціональність:**
- Додавання посилань в меню
- Автоматичний редирект після logout
- Кастомні URL для входу

**Redux опція:** `enable_login_exit_links`

---

## Модулі аналітики та трекінгу

### 12. _SDStudio___Yandex.php
**Призначення:** Інтеграція Yandex Metrika

**Функціональність:**
- Вивід коду лічильника Yandex Metrika
- Підтримка WebVisor
- Цілі та події

**Redux опція:**
```php
$redux['yandex_metrika_id'] = '12345678';
$redux['yandex_metrika_webvisor'] = true;
```

**Розташування коду:** `wp_head` або `wp_footer`

---

### 13. _SDStudio___Google_ADS.php
**Призначення:** Google Ads конверсійний трекінг

**Функціональність:**
- Код конверсії Google Ads
- Ремаркетинг теги
- Трекінг покупок

**Redux опція:**
```php
$redux['google_ads_id'] = 'AW-XXXXXXXXX';
$redux['google_ads_conversion_label'] = '...';
```

---

### 14. _SDStudio___Google_Tag.php
**Призначення:** Google Tag Manager інтеграція

**Функціональність:**
- Контейнер GTM в head
- Noscript fallback в body
- DataLayer підтримка

**Redux опція:**
```php
$redux['google_tag_manager_id'] = 'GTM-XXXXXX';
```

**Код:**
```html
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){...})(window,document,'script','dataLayer','GTM-XXXXXX');</script>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXX"...></iframe></noscript>
```

---

### 15. _SDStudio___MailRU.php
**Призначення:** Mail.ru Top-100 трекінг

**Функціональність:**
- Лічильник Mail.ru
- Статистика відвідувань

**Redux опція:**
```php
$redux['mailru_top_id'] = '12345';
```

---

### 16. _SDStudio___Admitad.php
**Призначення:** Admitad партнерський трекінг

**Функціональність:**
- Трекінг партнерських посилань
- Конверсійні пікселі
- Звіти по продажах

**Redux опція:**
```php
$redux['admitad_campaign_code'] = 'xxxxx';
```

---

## Модулі повідомлень та UI

### 17. _SDStudio_SweetAlert2.php
**Призначення:** Інтеграція SweetAlert2 для красивих алертів

**Функціональність:**
- Підключення SweetAlert2 бібліотеки
- Базова конфігурація
- Анімації

**Redux опція:** `enable_sweetalert2`

**Підключені файли:**
```
sweetalert2/sweetalert2.min.js
sweetalert2/sweetalert2.min.css
sweetalert2/animate.min.css
sweetalert2/__SweetAlert2_CUSTOM.css
```

---

### 18. _SDStudio_SweetAlert2_CF7_messages.php
**Призначення:** SweetAlert2 для Contact Form 7

**Функціональність:**
- Заміна стандартних повідомлень CF7
- Красиві алерти успіху/помилки
- Анімовані сповіщення

**Залежності:**
- Contact Form 7 плагін
- SweetAlert2 модуль

**Redux опція:** `enable_sweetalert_cf7`

**Events:**
```javascript
document.addEventListener('wpcf7mailsent', function(event) {
    Swal.fire({
        icon: 'success',
        title: 'Дякуємо!',
        text: 'Ваше повідомлення надіслано'
    });
});
```

---

### 19. _SDStudio_SweetAlert2_AddToAny_messages.php
**Призначення:** SweetAlert2 для AddToAny

**Функціональність:**
- Сповіщення про шаринг
- Підтвердження публікації в соцмережах

**Залежності:**
- AddToAny плагін
- SweetAlert2 модуль

**Redux опція:** `enable_sweetalert_addtoany`

---

## Модулі адміністративної панелі

### 20. _SDStudio_ADMIN_BAR.php
**Призначення:** Кастомізація WordPress Admin Bar

**Функціональність:**
- Додавання/видалення пунктів меню
- Швидкі посилання на інструменти
- Pretty Links інтеграція
- Кастомні іконки

**Redux опція:** `enable_admin_bar_customization`

**Додані пункти:**
- Google Analytics
- Google Search Console
- PageSpeed Insights
- GTmetrix
- Pretty Links

**Приклад:**
```php
$wp_admin_bar->add_node([
    'id'    => 'sdstudio-analytics',
    'title' => 'Analytics',
    'href'  => 'https://analytics.google.com/...',
    'meta'  => ['target' => '_blank']
]);
```

---

### 21. _SDStudio_ADMIN_disable_aggressive_update.php
**Призначення:** Відключення агресивних оновлень WordPress

**Функціональність:**
- Вимкнення автоматичних оновлень плагінів
- Контроль оновлень тем
- Відключення сповіщень про оновлення

**Redux опція:** `disable_aggressive_updates`

**Хуки:**
```php
remove_action('wp_maybe_auto_update', 'wp_maybe_auto_update');
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');
```

---

### 22. _SDStudio_ADMIN_active_sorted_data_publish.php
**Призначення:** Сортування записів за статусом публікації

**Функціональність:**
- Групування записів по статусам
- Покращена навігація
- Швидкий доступ до чернеток

**Redux опція:** `enable_sorted_admin_posts`

---

### 23. _SDStudio_ADMIN_DISABLE_PLUGINS.php
**Призначення:** Вимкнення специфічних плагінів в залежності від умов

**Функціональність:**
- Умовне завантаження плагінів
- Вимкнення плагінів на фронтенді
- Оптимізація навантаження

**Redux опція:**
```php
$redux['disabled_plugins'] = [
    'plugin-1/plugin-1.php',
    'plugin-2/plugin-2.php'
];
```

---

## Модулі інтеграції

### 24. _SDStudio_FRONTEND_ELEMENTOR.php
**Призначення:** Розширення Elementor

**Функціональність:**
- Кастомні віджети
- Додаткові контроли
- Навігація між постами
- Like/Unlike функціонал для постів

**Redux опція:** `enable_elementor_extensions`

**Функції:**
```php
pt_like_it()           // AJAX обробник лайків
get_page()             // Отримання сторінки (DEPRECATED - use get_post())
```

**AJAX endpoints:**
- `wp_ajax_pt_like_it`
- `wp_ajax_nopriv_pt_like_it`

---

### 25. _SDStudio___JivoSite.php
**Призначення:** Інтеграція JivoSite Live Chat

**Функціональність:**
- Вивід віджету JivoSite
- Налаштування позиції чату
- Умовне відображення

**Redux опція:**
```php
$redux['jivosite_widget_id'] = 'xxxxx';
$redux['jivosite_position'] = 'right';
```

---

## Модулі контенту

### 26. _SDStudio___SHORTCODES_AUTOGEN_PAGES.php
**Призначення:** Автоматична генерація сторінок з шорткодів

**Функціональність:**
- Автоматичне створення сторінок
- Парсинг markdown контенту
- WPML підтримка мультимовності
- SEO оптимізація згенерованих сторінок
- Унікальний контент для кожної мови

**Redux опція:** `enable_autogen_pages`

**Шорткод:**
```php
[sdstudio_autogen_page template="template-name"]
```

**Функції:**
```php
SDStudio_PAGE_AUTOGEN_title_updater($title, $id = null)
// Оновлення title згенерованих сторінок

SDStudio_MARKDOWN_Parser($text)
// Парсинг Markdown в HTML
```

**Залежності:**
- `cebe/markdown` composer пакет
- WPML (опціонально)

**Підтримувані мови WPML:**
- Українська (uk)
- Англійська (en)
- Російська (ru)
- Польська (pl)
- Норвезька (no)
- Німецька (de)

---

## Модулі стилізації

### 27. _SDStudio_CSS_Styles.php
**Призначення:** Додавання кастомних CSS стилів

**Функціональність:**
- Інжект CSS в head
- Динамічна генерація стилів
- Підтримка SCSS/LESS (через бібліотеки)

**Redux опція:**
```php
$redux['custom_css'] = '
.my-class {
    color: red;
}
';
```

**Хук:**
- `wp_head` (priority 999)

---

### 28. _SDStudio_arrows.php
**Призначення:** Навігаційні стрілки між постами

**Функціональність:**
- Попередній/наступний пост
- Thumbnails превью
- WPML сумісність

**Redux опція:** `enable_post_arrows`

**Функції:**
```php
sdstudio_prev_next_post_nav()
// Виводить навігацію між постами
```

**CSS класи:**
```css
.sdstudio-post-nav
.sdstudio-prev-post
.sdstudio-next-post
```

---

## Модулі форм

### 29. _Redux_Framework_Parser_POST_data.php
**Призначення:** Парсинг POST даних без обмеження max_input_vars

**Функціональність:**
- Обхід обмеження max_input_vars PHP
- Парсинг великих форм Redux
- Рекурсивне об'єднання масивів

**Проблема яку вирішує:**
PHP має обмеження `max_input_vars` (зазвичай 1000), що обмежує кількість полів у формі. Redux має сотні опцій, тому стандартні форми не працюють.

**Рішення:**
```php
function sdstudio_parse_raw_http_request(array &$data) {
    // Парсинг raw POST даних
    // Обхід max_input_vars
}
```

**Хук:**
- Виконується автоматично при збереженні Redux налаштувань

---

## Умовна активація модулів

### Шаблон перевірки Redux опції

Кожен модуль перевіряє свою Redux опцію перед активацією:

```php
<?php
if (!defined('ABSPATH')) exit;

$redux = get_option('redux_sds_options_and_settings');

if (isset($redux['enable_module_name']) && $redux['enable_module_name']) {
    // Код модуля тут

    add_action('init', 'module_init_function');

    function module_init_function() {
        // Ініціалізація модуля
    }
}
```

### Глобальні модулі (без перевірки)

Деякі модулі завжди активні:
- `_WORKER.php` - базова конфігурація
- `_Redux_Framework_Parser_POST_data.php` - необхідний для Redux

---

## Взаємозалежності модулів

### SweetAlert2 модулі
```
_SDStudio_SweetAlert2.php (базовий)
    └── _SDStudio_SweetAlert2_CF7_messages.php (Contact Form 7)
    └── _SDStudio_SweetAlert2_AddToAny_messages.php (AddToAny)
```

### Модулі зображень
```
_SDStudio_add_images_sizes.php (розміри)
_SDStudio_image_settings.php (якість, оптимізація)
_SDStudio_gallery_settings.php (галереї)
```

### Модулі аналітики
```
Незалежні модулі (можна вмикати окремо):
    - _SDStudio___Yandex.php
    - _SDStudio___Google_ADS.php
    - _SDStudio___Google_Tag.php
    - _SDStudio___MailRU.php
    - _SDStudio___Admitad.php
```

---

## Створення нового модуля

### Крок 1: Створити файл модуля

```php
<?php
/**
 * Module Name: My Custom Feature
 *
 * @package    Sds_Options_And_Settings
 * @subpackage Features
 * @since      2.3.0
 */

// Запобігання прямому доступу
if (!defined('ABSPATH')) {
    exit;
}

// Отримання налаштувань
$redux = get_option('redux_sds_options_and_settings');

// Перевірка активації модуля
if (isset($redux['enable_my_feature']) && $redux['enable_my_feature']) {

    // Реєстрація хуків
    add_action('init', 'sdstudio_my_feature_init', 10);
    add_filter('the_content', 'sdstudio_my_feature_content', 10, 1);

    /**
     * Ініціалізація модуля
     */
    function sdstudio_my_feature_init() {
        // Ініціалізаційний код
    }

    /**
     * Модифікація контенту
     *
     * @param string $content Контент посту
     * @return string Модифікований контент
     */
    function sdstudio_my_feature_content($content) {
        // Обробка контенту
        return $content;
    }
}
```

### Крок 2: Підключити модуль

Додати в `sds-options-and-settings.php`:

```php
function run_sds_options_and_settings() {
    $plugin = new Sds_Options_And_Settings();
    $plugin->run();

    // ... інші модулі
    require_once plugin_dir_path(__FILE__) . '_SDStudio_My_Feature.php';
}
```

### Крок 3: Додати Redux опцію (опціонально)

Створити конфігурацію в Redux Framework для увімкнення/вимкнення модуля.

---

## Оптимізація модулів

### Умовне завантаження

```php
// Завантажувати тільки в адмінці
if (is_admin() && isset($redux['enable_admin_feature'])) {
    require_once 'admin-feature.php';
}

// Завантажувати тільки на фронтенді
if (!is_admin() && isset($redux['enable_frontend_feature'])) {
    require_once 'frontend-feature.php';
}
```

### Lazy loading скриптів

```php
add_action('wp_enqueue_scripts', function() use ($redux) {
    if (is_singular('post') && $redux['enable_feature']) {
        wp_enqueue_script('feature-script', PLUGIN_URL . 'js/feature.js', ['jquery'], '1.0.0', true);
    }
});
```

---

## Відлагодження модулів

### Debug режим

```php
if (defined('WP_DEBUG') && WP_DEBUG) {
    error_log('SDStudio Module: Feature initialized');
    error_log('Redux option: ' . print_r($redux['enable_feature'], true));
}
```

### Перевірка активних модулів

Додати в `functions.php` теми:

```php
add_action('admin_notices', function() {
    $redux = get_option('redux_sds_options_and_settings');

    echo '<div class="notice notice-info">';
    echo '<p>Активні модулі SDStudio:</p>';
    echo '<ul>';

    foreach ($redux as $key => $value) {
        if (strpos($key, 'enable_') === 0 && $value) {
            echo '<li>' . esc_html($key) . '</li>';
        }
    }

    echo '</ul>';
    echo '</div>';
});
```

---

## Підсумок

**Всього модулів:** 29+
**Категорії:**
- Продуктивність: 3
- Зображення: 3
- Редактор: 2
- Безпека/Вхід: 3
- Аналітика: 5
- UI/Повідомлення: 3
- Адмін-панель: 4
- Інтеграції: 2
- Контент: 1
- Стилі: 2
- Форми: 1

Модульна архітектура дозволяє:
- ✅ Легко додавати нову функціональність
- ✅ Вимикати непотрібні модулі
- ✅ Незалежно розвивати кожен модуль
- ✅ Швидко знаходити та виправляти баги
- ✅ Підтримувати чистоту коду
