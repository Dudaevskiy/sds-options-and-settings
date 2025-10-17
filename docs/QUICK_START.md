# Швидкий старт - SDStudio Options and Settings

## Встановлення

### Вимоги

- WordPress 5.0+
- PHP 8.2+ (Рекомендовано 8.3)
- MySQL 5.7+ або MariaDB 10.2+
- 64 MB+ PHP memory limit

### Кроки встановлення

#### 1. Завантаження плагіна

**Метод 1: Git**
```bash
cd wp-content/plugins/
git clone https://github.com/Dudaevskiy/sds-options-and-settings.git
```

**Метод 2: Завантаження ZIP**
1. Завантажити ZIP архів з GitHub
2. WordPress Admin → Плагіни → Додати новий → Завантажити плагін
3. Вибрати ZIP файл і натиснути "Встановити"

#### 2. Встановлення залежностей

```bash
cd sds-options-and-settings/
composer install --no-dev
```

Якщо Composer не встановлений:
```bash
# Linux/Mac
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev

# Windows - завантажити з https://getcomposer.org/download/
```

#### 3. Активація плагіна

**WordPress Admin:**
1. Перейти до: Плагіни → Встановлені плагіни
2. Знайти "SDStudio addons, options and settings"
3. Натиснути "Активувати"

**WP-CLI:**
```bash
wp plugin activate sds-options-and-settings
```

#### 4. Перевірка активації

Перевірити чи з'явився новий пункт меню в адмін-панелі:
```
WordPress Admin → SDStudio options and settings
```

---

## Базова конфігурація

### Перший запуск

1. **Відкрити панель налаштувань:**
   ```
   WordPress Admin → SDStudio options and settings
   ```

2. **Redux Framework:**
   - Плагін використовує Redux Framework для налаштувань
   - Всі опції зберігаються в одному місці
   - Зміни застосовуються миттєво після збереження

3. **Структура налаштувань:**
   ```
   ├── Загальні налаштування
   ├── Продуктивність
   ├── Редактор
   ├── Зображення
   ├── Логін та безпека
   ├── Аналітика
   ├── Інтеграції
   └── Розширені
   ```

---

## Швидке налаштування (5 хвилин)

### 1. Кастомізація сторінки входу

**Крок 1:** Перейти до розділу "Логін"

**Крок 2:** Завантажити логотип
```
Логотип входу → Завантажити → Вибрати файл (PNG/JPG, рекомендовано 320x100px)
```

**Крок 3:** Встановити фон
```
Фон сторінки входу → Колір (#ffffff) або Зображення
```

**Крок 4:** Зберегти зміни

**Результат:** Кастомна сторінка входу з вашим брендингом

---

### 2. Увімкнення SweetAlert2 повідомлень

**Крок 1:** Розділ "UI та повідомлення"

**Крок 2:** Увімкнути SweetAlert2
```
☑ Увімкнути SweetAlert2
☑ Використовувати для Contact Form 7
☑ Використовувати для AddToAny
```

**Крок 3:** Зберегти

**Результат:** Красиві анімовані алерти замість стандартних

---

### 3. Додавання аналітики

**Google Tag Manager:**
```
Розділ: Аналітика → Google Tag Manager
GTM Container ID: GTM-XXXXXX
Зберегти
```

**Yandex Metrika:**
```
Розділ: Аналітика → Yandex Metrika
ID лічильника: 12345678
☑ Увімкнути WebVisor
Зберегти
```

**Результат:** Автоматичне підключення коду аналітики на всіх сторінках

---

### 4. Оптимізація продуктивності

**Швидке налаштування:**
```
Розділ: Продуктивність

☑ Оптимізувати jQuery (вибрати режим: inline/disable)
☑ Lazy loading зображень
☑ Оптимізувати розміри зображень
Якість JPEG: 85

Зберегти
```

**Результат:** Швидше завантаження сайту

---

### 5. Покращення редактора

```
Розділ: Редактор постів

☑ Обов'язкове featured image для публікації
☑ Додати rel-атрибути (nofollow, sponsored, ugc)
☑ Відключити fullscreen Gutenberg
☑ Показувати Rank Math ключові слова

Зберегти
```

**Результат:** Зручніший редактор з додатковими можливостями

---

## Основні функції

### Шорткоди

#### [bloginfo]
Вивести інформацію про сайт

**Приклади:**
```php
[bloginfo info='name']          // Назва сайту
[bloginfo info='description']   // Опис сайту
[bloginfo info='url']           // https://example.com
[bloginfo info='url_not_https'] // example.com
[bloginfo info='link_site']     // <a href="...">example.com</a>
```

**Використання в темі:**
```php
<?php echo do_shortcode('[bloginfo info="name"]'); ?>
```

#### [current_year]
Вивести поточний рік

**Приклад:**
```html
<footer>
    Copyright © [current_year] Всі права захищені
</footer>
```

**Результат:** `Copyright © 2025 Всі права захищені`

---

### Гарячі клавіші

**Після увімкнення модуля "Гарячі клавіші":**

| Комбінація | Дія |
|------------|-----|
| `Ctrl+Shift+1` | Відкрити головну сторінку сайту |
| `Ctrl+Shift+2` | Перейти в адмін-панель |
| `Ctrl+Shift+3` | Google Analytics |
| `Ctrl+Shift+4` | Google Search Console |
| `Ctrl+5` | PageSpeed Insights |
| `Ctrl+6` | GTmetrix |
| `Ctrl+7` | WebPageTest |

**Увімкнення:**
```
Розділ: Логін → Гарячі клавіші
☑ Увімкнути гарячі клавіші
Зберегти
```

---

### Rel-атрибути для посилань

**Після увімкнення в розділі "Редактор постів":**

1. Виділити текст у редакторі
2. Натиснути кнопку "Додати посилання" (або `Ctrl+K`)
3. Вставити URL
4. З'являться чекбокси для rel-атрибутів:
   - `☑ nofollow` - не передавати вагу посилання
   - `☑ sponsored` - рекламне посилання
   - `☑ ugc` - контент від користувачів
5. Вибрати потрібні та натиснути "Застосувати"

**Результат:**
```html
<a href="https://example.com" rel="nofollow sponsored">Посилання</a>
```

---

### AJAX в темах

**Використання AJAX URL:**

```javascript
// URL вже доступний в myajax об'єкті
var ajaxUrl = myajax.sdstudio_wp_ajax_url;

jQuery.ajax({
    url: ajaxUrl,
    type: 'POST',
    data: {
        action: 'my_custom_action',
        nonce: '<?php echo wp_create_nonce("my_nonce"); ?>',
        post_id: 123
    },
    success: function(response) {
        console.log(response);
    }
});
```

**PHP обробник:**
```php
add_action('wp_ajax_my_custom_action', 'my_custom_action_handler');
add_action('wp_ajax_nopriv_my_custom_action', 'my_custom_action_handler');

function my_custom_action_handler() {
    check_ajax_referer('my_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);

    // Ваша логіка

    wp_send_json_success(['message' => 'Success']);
}
```

---

## Інтеграції

### Contact Form 7

**Автоматична інтеграція:**
1. Встановити Contact Form 7
2. Увімкнути "SweetAlert2 для CF7" в налаштуваннях плагіна
3. Зберегти

**Результат:** Красиві алерти для CF7 форм

---

### Elementor

**Додаткові функції:**
- Навігація між постами (prev/next)
- Like/Unlike для постів
- Кастомні віджети

**Увімкнення:**
```
Розділ: Інтеграції → Elementor
☑ Увімкнути розширення Elementor
```

---

### WPML

**Автоматична підтримка:**
- Автогенерація сторінок для всіх мов
- Правильні посилання в меню
- Мультимовні shortcodes

**Підтримувані мови:**
- Українська (uk)
- Англійська (en)
- Російська (ru)
- Польська (pl)
- Норвезька (no)
- Німецька (de)

**Використання в меню:**
```
URL: #wpml_main_page
```
Автоматично замінюється на головну сторінку поточної мови.

---

## Troubleshooting

### Проблема: Плагін не активується

**Рішення:**
1. Перевірити версію PHP: `php -v` (має бути 8.2+)
2. Перевірити чи встановлені Composer залежності:
   ```bash
   cd wp-content/plugins/sds-options-and-settings/
   ls vendor/
   ```
3. Якщо папки `vendor/` немає:
   ```bash
   composer install --no-dev
   ```

---

### Проблема: Налаштування не зберігаються

**Причина:** Обмеження `max_input_vars` PHP

**Рішення:**

**PHP.ini:**
```ini
max_input_vars = 5000
```

**wp-config.php:**
```php
@ini_set('max_input_vars', 5000);
```

**Перевірка:**
```php
<?php phpinfo(); ?>
```
Шукати `max_input_vars`

---

### Проблема: SweetAlert2 не працює

**Рішення:**
1. Перевірити чи увімкнений модуль:
   ```
   Налаштування → SweetAlert2 → ☑ Увімкнути
   ```

2. Перевірити консоль браузера (F12):
   - Якщо помилки `Swal is not defined` - очистити кеш
   - Якщо помилки завантаження скриптів - перевірити шлях до файлів

3. Конфлікт з іншими плагінами:
   ```
   Відключити всі плагіни крім SDStudio
   Перевірити чи працює
   Поступово вмикати інші плагіни
   ```

---

### Проблема: Гарячі клавіші не працюють

**Рішення:**
1. Перевірити чи увімкнений модуль
2. Перевірити чи немає конфліктів з іншими скриптами:
   ```javascript
   // Консоль браузера
   document.addEventListener('keydown', function(e) {
       console.log('Key:', e.key, 'Ctrl:', e.ctrlKey, 'Shift:', e.shiftKey);
   });
   ```
3. Деякі браузери можуть блокувати `window.open()` - перевірити налаштування popup blocker

---

### Проблема: Кастомний логотип не відображається

**Рішення:**
1. Перевірити формат файлу (PNG, JPG, SVG)
2. Перевірити розмір (рекомендовано до 2MB)
3. Перевірити URL зображення в Redux:
   ```
   Налаштування → Логін → Логотип входу
   ```
4. Перевірити консоль браузера на помилки 404
5. Очистити кеш браузера (`Ctrl+Shift+R`)

---

## Корисні команди

### WP-CLI

```bash
# Активувати плагін
wp plugin activate sds-options-and-settings

# Деактивувати плагін
wp plugin deactivate sds-options-and-settings

# Оновити плагін
wp plugin update sds-options-and-settings

# Перевірити статус
wp plugin status sds-options-and-settings

# Отримати налаштування Redux
wp option get redux_sds_options_and_settings

# Видалити налаштування
wp option delete redux_sds_options_and_settings
```

### Composer

```bash
# Встановити залежності
composer install --no-dev

# Оновити залежності
composer update

# Перевірити застарілі пакети
composer outdated

# Валідація composer.json
composer validate
```

### Git

```bash
# Оновити плагін
cd wp-content/plugins/sds-options-and-settings/
git pull origin master

# Перевірити версію
git describe --tags

# Відкатитися до попередньої версії
git checkout v2.2.60
```

---

## Оптимізація

### Після встановлення рекомендується:

1. **Увімкнути оптимізацію продуктивності:**
   - jQuery оптимізація (inline або disable)
   - Lazy loading зображень
   - Оптимізація розмірів зображень

2. **Налаштувати аналітику:**
   - Google Tag Manager або Google Analytics
   - Yandex Metrika (для регіону СНД)

3. **Покращити редактор:**
   - Rel-атрибути для SEO
   - Обов'язкові featured images

4. **Кастомізувати вигляд:**
   - Логотип входу
   - Admin Bar меню
   - Кастомні CSS стилі

5. **Очистити після активації:**
   ```bash
   # Очистити кеш плагінів
   wp cache flush

   # Регенерувати thumbnails (якщо увімкнені нові розміри)
   wp media regenerate --yes
   ```

---

## Наступні кроки

1. **Прочитати документацію:**
   - [README.md](README.md) - Загальна інформація
   - [ARCHITECTURE.md](ARCHITECTURE.md) - Архітектура плагіна
   - [MODULES.md](MODULES.md) - Детальний опис модулів

2. **Переглянути приклади:**
   - Подивитись на використання шорткодів
   - Ознайомитись з AJAX прикладами

3. **Створити backup:**
   ```bash
   # Створити backup налаштувань
   wp option get redux_sds_options_and_settings > redux-backup.json
   ```

4. **Приєднатися до спільноти:**
   - GitHub Issues: https://github.com/Dudaevskiy/sds-options-and-settings/issues
   - Сайт автора: https://sdstudio.top

---

## Підтримка

**Знайшли баг?**
- Створити Issue на GitHub
- Описати кроки для відтворення
- Вказати версію WordPress та PHP

**Потрібна допомога?**
- Перевірити документацію
- Шукати в Issues на GitHub
- Звернутися до автора: https://sdstudio.top

**Хочете внести вклад?**
- Fork репозиторій
- Створити feature branch
- Зробити Pull Request

---

**Успішного використання плагіна! 🚀**
