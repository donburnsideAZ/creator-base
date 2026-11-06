# Creator Base

A clean, simple WordPress theme for content creators, YouTubers, podcasters, and bloggers. Blog-focused with support for video and audio embeds. No plugins required, no custom fields needed. Just write, paste embeds in excerpts, and publish.

**Version:** 2.7.0  
**Requires WordPress:** 5.0+  
**Tested up to:** 6.4  
**Requires PHP:** 7.4+  
**License:** GPL v2 or later

---

## Features

- **Four Hero Modes** — Video (latest/sticky post), Banner (static image), Carousel (up to 4 slides), or Widgets (two customizable areas)
- **Hero Carousel** — Auto-advancing slides with dot navigation, pause on hover, clickable full-slide links
- **Banner Mode** — 1280×400 hero banner with full background image support, cover/contain/tile options
- **Responsive Card Grid** — Clean post cards with featured images, embeds, and category badges
- **Featured Links** — Customizable navigation bar using WordPress menus (Appearance → Menus)
- **Header Social Icons** — Optional social links in the navigation bar
- **Promo Bar** — Horizontal or sidebar layout for promotional widgets
- **Four-Color System** — Accent, background, card background, and text colors with automatic shade calculation
- **Embed Support** — YouTube, Vimeo, Spotify, Apple Podcasts, Captivate, and more
- **Markdown Support** — Built-in Parsedown for markdown content (no plugin needed)
- **Dark Mode Ready** — Fully supports light and dark color schemes
- **Mobile First** — Responsive design that looks great on all devices

---

## Installation

1. Download the theme zip file
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload the zip and activate
4. Go to **Appearance → Customize** to configure

---

## Customizer Options

All theme settings are in **Appearance → Customize → Creator Base Options**.

### Theme Colors

| Setting | Default | Description |
|---------|---------|-------------|
| Accent Color | `#f59e0b` | Links, buttons, category badges, highlights |
| Background Color | `#0a0a0a` | Main page background |
| Card Background | `#1a1a1a` | Hero, cards, and content areas |
| Text Color | `#ffffff` | Primary text (secondary shades auto-calculated) |

### Hero Mode

| Setting | Options | Description |
|---------|---------|-------------|
| Hero Display | Video / Banner / Carousel / Widgets | Choose hero section style |
| Banner Title | Text | Static title for banner mode |
| Banner Description | Textarea | Static description for banner mode |
| Banner Button | Text + URL | Optional CTA button |
| Hero Background Image | Image | Background for hero section (1280×400 recommended for banner) |
| Background Size | Cover / Contain / Auto | How the background image displays |
| Background Position | Various | Image positioning |
| Slide 1-4 Image | Image | Carousel slide images (1280×400 recommended) |
| Slide 1-4 Title | Text | Optional overlay title |
| Slide 1-4 Description | Textarea | Optional overlay description |
| Slide 1-4 Link URL | URL | Makes entire slide clickable |

### Layout Options

| Setting | Default | Description |
|---------|---------|-------------|
| Show Sidebar on Pages | Off | Enable sidebar on static pages |
| Show Promo Bar | Off | Display promotional widget area |
| Promo Bar Layout | Horizontal | Horizontal row or sidebar stack |
| Show Featured Links | On | Display Featured Links menu on front page |

### Social Links

| Setting | Default | Description |
|---------|---------|-------------|
| Show Social Icons in Header | Off | Display social icons in navigation bar |
| Platform URLs | Empty | YouTube, Twitter, Instagram, TikTok, Facebook, LinkedIn, Bluesky, Threads, Patreon, Spotify, Apple Podcasts |

### Footer

Custom footer title, description, and copyright text.

---

## Image Sizes

| Image Type | Recommended Size | Notes |
|------------|------------------|-------|
| Featured Images | 1280 × 720px | 16:9 ratio, matches YouTube |
| Hero Banner | 1280 × 400px | For banner mode |
| Hero Background | 1920 × 600px+ | For photo backgrounds |
| Pattern/Tile | 200–400px square | For repeating patterns |
| Promo Images | 400 × 300px | Flexible for both layouts |
| Site Logo | 400 × 100px max | Horizontal, PNG/SVG |
| Site Icon | 512 × 512px | Square favicon |

---

## Widget Areas

| Widget Area | Location |
|-------------|----------|
| Hero Sidebar | Right side of hero section (video mode) |
| Hero Left | Left widget in widgets hero mode |
| Hero Right | Right widget in widgets hero mode |
| Promo Area | Horizontal bar or sidebar promo |
| Footer | Footer content area |
| Sidebar | Page sidebar (when enabled) |

---

## Template Files

```
creator-base/
├── front-page.php      # Homepage with hero + card grid
├── single.php          # Single post template
├── page.php            # Static page template
├── index.php           # Archive/fallback template
├── search.php          # Search results
├── header.php          # Site header
├── footer.php          # Site footer
├── comments.php        # Comment template
├── functions.php       # Theme setup and functions
├── style.css           # Main stylesheet
├── inc/
│   ├── customizer.php  # Customizer settings
│   ├── template-tags.php # Template helper functions
│   └── markdown.php    # Parsedown markdown support
├── template-parts/
│   ├── content-card.php # Post card template
│   └── content-none.php # No content template
└── assets/
    └── js/
        ├── main.js              # Frontend scripts
        ├── customizer.js        # Customizer controls
        └── customizer-preview.js # Live preview
```

---

## CSS Custom Properties

The theme uses CSS custom properties for consistent styling:

```css
/* Colors */
--cb-color-accent
--cb-color-accent-hover
--cb-color-bg
--cb-color-bg-secondary
--cb-color-bg-tertiary
--cb-color-text-primary
--cb-color-text-secondary
--cb-color-text-muted
--cb-color-border

/* Typography */
--cb-font-size-xs through --cb-font-size-4xl
--cb-font-weight-normal / medium / semibold / bold

/* Spacing */
--cb-spacing-xs through --cb-spacing-3xl

/* Border Radius */
--cb-radius-sm (4px)
--cb-radius-md (8px)
--cb-radius-lg (12px)
--cb-radius-full (9999px)

/* Layout */
--cb-max-width (1400px)
--cb-content-width (800px)
```

---

## Helper Functions

```php
// Get categories for front page nav
creator_base_get_categories_list()

// Display category badge
creator_base_category_badge($post_id)

// Get hashtag-style tags
creator_base_get_hashtags($post_id)

// Check if promo bar should show
creator_base_show_promo_bar()

// Get promo bar layout
creator_base_promo_layout()

// Render promo bar
creator_base_promo_bar($context)
```

---

## Changelog

### 2.5.9
- Added category navigation show/hide toggle
- Added multi-select category picker in Customizer

### 2.5.8
- Added Captivate player styling for post content
- Reduced corner radius on single post content area

### 2.5.7
- Fixed single post content background color (now uses card background)

### 2.5.6
- Changed banner dimensions to 1280×400 (32:10 aspect ratio)

### 2.5.5
- Banner mode now displays with background image only (no title required)
- Added banner-specific CSS with proper aspect ratio container
- Text overlay with gradient for readability when content present

### 2.5.4
- Initial public release

---

## Credits

- Built on [Underscores](https://underscores.me/) starter theme
- [Parsedown](https://parsedown.org/) for Markdown support
- Created by [Don Burnside](https://donburnside.com)

---

## License

Creator Base is licensed under the GNU General Public License v2 or later.

---

*Creator Base • Own Your Content*
