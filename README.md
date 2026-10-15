# Webmarka Articles Portfolio

**English** · [Русский](README.ru.md) · [Қазақша](README.kk.md)

![version](https://img.shields.io/badge/version-1.1.0-1e5b54) ![Joomla](https://img.shields.io/badge/Joomla-5%20%7C%206-1e5b54) ![PHP](https://img.shields.io/badge/PHP-8.1%2B-1e5b54) ![UIkit](https://img.shields.io/badge/UIkit-3-1e5b54) ![license](https://img.shields.io/badge/license-GPL--2.0--or--later-1e5b54)

A Joomla 5 and 6 module that turns articles into a portfolio: cards in a grid or a slider, each project opening in a UIkit 3 modal.

The portfolio shows projects as cards and opens each one in a UIkit modal on click: a large image, the full intro text and a button to the article page. Visitors browse the work without leaving the page and go to the details only when a project catches their eye. It suits studios, architecture and engineering firms, manufacturers — anyone who shows finished work.

## Features

### Article selection

- **Categories** — one or several, with subcategories down to the depth you set.
- **Dynamic mode:** the module takes the category of the current page — on a category page it shows that category, on an article page the articles of the same category (the latter can be switched off).
- **Featured articles:** show them with the rest, hide them or show only them.
- **Tags and authors:** only articles with the chosen tags; include or exclude the chosen authors, or show only the current user's articles.
- **Dates:** a range or the last N days — by creation, modification or publishing date.
- **Ordering** by nine keys: article order, featured order, title, ID, creation, modification and publishing dates, hits, random; ascending or descending.
- **Grouping** by year, month, author, category or tags, in either direction: each group is a separate block with a sub-heading; untagged articles go into an “Untagged” group.
- Articles are selected by Joomla's own article model, so access levels, the language filter, publishing dates and featured dates are respected.

### Output

- **Two views:** grid (or masonry) and slider.
- **Two data layouts:** cards with images or titles only — both open the modal.
- **The whole card is a button:** a click on the image, title or text opens the modal.
- **Project modal:** three sizes (default, large, full screen); image above the text or to its left; the modal shows the article's full image with “Close” and “Open page” buttons.
- **Four card structures**, with “View project” in the footer.
- **Grid:** columns (one or two on phones, up to four on tablets, up to five on desktops), gutters, equal height, masonry. **Slider:** outside arrows (the module leaves room for them; hidden on phones), dots, autoplay.
- Modal ids stay unique even when one project appears in several tag groups.

## On-page filter

- A UIkit filter (`uk-filter`) above the grid: by category, tag, author, year or month. Buttons are built from the articles on display, so there are never empty buttons.
- Four menu styles: divider, pills, tabs, button group; left, centre or right alignment.
- Animation: slide, fade, delayed fade or none.
- The “All” button text is set in the options; by default it is translated.
- When grouping is on the filter is not shown: each group is already a separate block. Works in the grid view: a slider cannot hide items on the fly.

## Images

- **Preview source** — the article's intro or full image, with or without a fallback. Intro by default, full when there is no intro image; the project modal always shows the full image.
- **Processing:** JUImage thumbnails (centre crop to the exact size, 800 × 500 by default, WebP) or the original as it is — without a single new thumbnail.
- **srcset and sizes** by the grid columns; phones get their own thumbnail (400 × 300 and a double one) through `<picture>`.
- The cover keeps its ratio on any screen (`<canvas>` in `uk-cover-container`).
- **Blend modes:** multiply, screen, overlay — with mask colour and opacity.

## Design

- **Heading tag paired with a UIkit class:** the tag (h1–h6 or div) is chosen for page structure and search engines, the visual size for design: `uk-h1`–`uk-h6`, `uk-heading-small`, `uk-heading-medium`, `uk-heading-large`, `uk-text-lead`, `uk-text-large`. So `<h3 class="uk-h2">` looks like h2 and stays h3 in the structure. When a size is chosen, `uk-card-title` is dropped from the extra classes by itself: it comes later in the UIkit CSS and would override the size.
- Module heading: your own title, tag, size and UIkit style — line, bullet or divider.
- Your own classes for the card title and text (`uk-card-title uk-link-heading` and `uk-text-muted uk-text-small` by default).
- Module class suffix, alternative layouts, module caching: global setting or off, cache time.

## Intro text

- **Format:** plain text — no tags or images, one paragraph that UIkit classes style evenly; or the article HTML with its markup kept.
- **Trim by characters or by words.** Joomla's core module trims by characters only; here you can keep, say, twenty words, and a word is never cut in half. An ellipsis ends the text.
- **UIkit styling:** size (`uk-text-meta`, `uk-text-small`, `uk-text-large`, `uk-text-lead`), colour (`uk-text-muted`, `uk-text-emphasis`, `uk-text-primary`, `uk-text-secondary`), style (italic, light, bold), alignment (left, centre, right, justify) and your own extra classes.
- **At most N lines:** the text ends with an ellipsis on the given line, so cards line up. UIkit has no class for this — the CSS `line-clamp` property does it.

## SEO and social networks

- **JSON-LD structured data** (default): one `ItemList` block in the page code — links, titles and images of the articles. Google recommends JSON-LD: it does not mix with the markup and survives layout overrides.
- **schema.org microdata** — optional: attributes right in the markup (`CreativeWork` on every card). Or nothing, when the template builds the structured data.
- **Social image (`og:image`).** When a page link is shared in Telegram, Facebook or WhatsApp, the preview comes from `og:image`. The module adds the full image of the first article (or of several, up to ten) with `og:image:width`, `og:image:height` and `og:image:alt`. In Auto mode only when the page has no `og:image` of its own and it is not an article page: an article has its own picture, and the module does not override it. There are Always and Off modes too.

## Advantages

1. **Joomla core under the hood.** Articles are selected by the same `com_content` model as the core “Articles” module (`mod_articles`). The module writes no SQL of its own, so it never bypasses access levels, languages or publishing dates and does not break with Joomla updates.
2. **Pure UIkit.** The markup is built from standard UIkit components — card, grid, cover, slider, filter, modal, lightbox. The module speaks the language of your UIkit template at once: its colours, fonts, spacing, dark sections. It has a few lines of its own CSS, only where there is no way around them.
3. **Light pages.** Exact-size WebP thumbnails, `srcset` for screen width and pixel density, separate phone thumbnails, lazy-loaded images. JUImage makes a file once and then serves it from the `img/` folder. And when thumbnails are not wanted, the module shows the originals and creates no new files.
4. **Works anywhere.** No JUImage — the original images are shown. No UIkit in the template — UIkit is loaded from a CDN with an integrity check. No dependencies besides UIkit: no jQuery, no libraries of its own.
5. **Search engines and social networks.** JSON-LD or schema.org microdata and `og:image` for link previews — with a careful Auto mode that never overrides the article's own picture.
6. **Careful output.** Everything that comes from the options and the articles is escaped; heading tags are checked against a whitelist; with PHP error reporting at “maximum” the test page shows not a single warning.
7. **Override piece by piece.** Each sublayout can be overridden in the site template on its own, and the helper's static methods are available to your layouts.
8. **Three languages.** Admin interface, site texts and installer messages in Kazakh, Russian and English; all strings live in language files.
9. **Tested:** Joomla 6.1.4, PHP 8.3, UIkit 3.25.26, JUImage 5.21 — no PHP warnings, no browser console errors, no horizontal scroll on phones, tablets or desktops.

## Requirements

- Joomla 5.0 or later, Joomla 6 (tested on 6.1.4);
- PHP 8.1 or later (tested on 8.3);
- UIkit 3 — from the site template; when there is none, the module loads UIkit itself (see “UIkit”);
- JUImage — optional; the package installs it when the site has none.

## Installation

The **Releases** section has two archives:

| archive | contents | when to use |
|---|---|---|
| `pkg_wmarka_articles_portfolio_v1.1.0.zip` | the module and the JUImage 5.21 library | usually this one |
| `mod_wmarka_articles_portfolio_v1.1.0.zip` | the module only | JUImage is already installed or not needed |
| `mod_wmarka_articles_portfolio_v1.1.0_files.zip` | module files from the site root: `modules/`, `language/` | update the files over an installed module by unpacking, without the installer |

Install it in “System → Install → Extensions”. Then “Content → Site Modules → New”, choose “Webmarka: Portfolio (UIkit 3)”, a position and pages.

What the package does on install:

1. checks the PHP (8.1+) and Joomla (5.0+) versions and stops if they are lower;
2. installs the module;
3. looks for `libraries/juimage/vendor/autoload.php`, the file the module loads JUImage through. If it is there, the library is left alone, whatever its version. If not, JUImage 5.21 is installed from the official release, unchanged;
4. tells you where the module will take UIkit from;
5. registers the update server.

JUImage is installed as a **standalone library, not as a child of the package**. When a Joomla package is uninstalled it removes everything listed in its manifest, and the library may be used by the template and other modules — so uninstalling the package removes only the module and JUImage stays. You can remove it by hand in “System → Manage → Extensions”.

A manual update works the same way: install the new package over the old one; module settings are kept.

## Updates

Since version 1.1.0 the module announces new versions by itself. On install it registers an update server in Joomla — the `updates.xml` file (for the package) or `updates_module.xml` (for the standalone module) in this repository. Joomla reads that file from time to time and, when a new version is out:

- shows a notice in the control panel and in “System → Update → Extensions”;
- installs the update in one click, downloading the archive straight from the Releases section;
- checks the downloaded archive against the SHA-256 hash from the update file and refuses a tampered file;
- shows what is new with the “Changelog” button (the `changelog.xml` file).

Module settings are kept on update. If the module was installed as a package, the package gets the update; if as a standalone archive, the module itself does; there are never two notices. Version 1.0.0 had no update server yet: from it, install 1.1.0 by hand once, and updates will come by themselves afterwards.

For a manual file update there is `mod_wmarka_articles_portfolio_v1.1.0_files.zip`: unpack it into the site root over the installed module, then press “Refresh Cache” in “System → Manage → Extensions” so Joomla shows the new version.

## UIkit

The module is built from UIkit 3 components and is meant for UIkit templates such as [wmarka](https://github.com/bsakhanov/wmarka). The “UIkit Loading” option on the Advanced tab decides how it gets UIkit:

- **Auto** (default). First the server looks for UIkit among the page assets — in Joomla's WebAssetManager and in the attached scripts and styles: if an asset name or address contains “uikit”, the module adds nothing. If nothing is found (the template may have written UIkit straight into `index.php`), the module adds a tiny script: once the page has loaded it checks `window.UIkit` and loads UIkit from the CDN only when it is missing. However many modules are on the page, there is one script.
- **Always from CDN:** UIkit styles and scripts are added to the page head through the WebAssetManager, scripts with `defer`.
- **Do not load:** the template is fully responsible for UIkit.

A CDN (content delivery network) serves files from the server nearest to the visitor. By default it is jsDelivr with UIkit 3.25.26: `uikit.min.css`, `uikit.min.js`, `uikit-icons.min.js`. Every file comes with Subresource Integrity (SRI): the browser checks its sha384 hash and refuses a tampered file. The “UIkit CDN Address” field takes another version, another CDN or a local copy — the UIkit `dist` folder; the integrity check applies to the default address only.

Worth knowing:

- UIkit is a full framework with its own base styles. Loaded into a template without UIkit (Cassiopeia, for one), it also changes that template's typography: headings, links, spacing. Auto-loading is a safety net; the module's natural home is a UIkit template.
- In Auto mode with loading from the browser, styles arrive after the first paint, so for a split second the module is unstyled. If the module is the only source of UIkit on the site, choose “Always from CDN”.
- If the site has a Content Security Policy (CSP), allow `cdn.jsdelivr.net` or point to a local copy of UIkit.

## Images and JUImage

[JUImage](https://github.com/Joomla-Ukraine/JUImage) is a library by Denys Nosov (Joomla! Ukraine) built on phpThumb: it makes thumbnails and keeps them in the `img/` folder at the site root. The module asks it for:

- a centre crop to the exact size (the `zc` option);
- the WebP format — noticeably lighter than JPEG at the same quality — with the quality from the options (70 by default);
- a width set for `srcset` (400, 800 and 1200 pixels by default, plus the main width); no thumbnail is made wider than the original — JUImage can enlarge, but that is extra weight with no gain;
- for phones, a separate thumbnail (and a double one for dense screens) the browser picks through `<picture>` on screens up to 640 pixels;
- the source is the article image chosen in the options (intro, then full by default); the `#joomlaImage://…` suffix Joomla adds to paths is stripped.

The “Original, no thumbnails” mode does not touch JUImage at all: the article file is shown as it is, with real `width` and `height` — from Joomla's data or from the file itself.

A thumbnail is made on first display and served as a ready file afterwards. Its name reflects size and quality: change the options and new files appear; old ones can be deleted together with the `img/` folder. JUImage recognises a thumbnail by the source file name, so upload a replaced image under a new name.

Without JUImage the module shows the original images — nothing breaks.

## Layout overrides

Copy the files you need from `modules/mod_wmarka_articles_portfolio/tmpl/` to `templates/<your template>/html/mod_wmarka_articles_portfolio/` and edit the copies:

| file | renders |
|---|---|
| `default.php` | wrapper: module heading, filter, grid or slider per group |
| `default_items.php` | cards with images |
| `default_titles.php` | cards without images |
| `default_modal.php` | project modal (shared by both layouts) |

If an alternative layout has no sublayout of its own, the default one is used. Layouts get `$module`, `$params`, `$list` (articles, or a “group → articles” array when grouped), `$grouped`, `$items` (articles of the current group, in sublayouts), `$moduleClass`, `$juImg`, `$blendMode`, `$overlayRgba`, `$modalSeq`, and the static methods of `ArticlesPortfolioHelper`: `picture()` and `pictureTag()` (previews with `srcset`), `fullImage()`, `formatIntro()`, `introAttributes()`, `titleClass()`, `sizes()`, `filterClasses()`, `filterOptions()`, `rgba()`, `seo()`, `getJuImage()`, `loadUikit()`.

## How it works

The module follows the Joomla 4+ structure. `services/provider.php` registers the dispatcher and the helper. The `Dispatcher` prepares the layout data: the article list through Joomla's module cache, the JUImage instance, the mask colour; adds UIkit, JSON-LD and `og:image`; an empty list renders nothing. The `ArticlesPortfolioHelper` helper selects articles through the `Articles` model of `com_content`. Namespace: `Webmarka\Module\ArticlesPortfolio\Site`.

Repository:

```
module/                 module sources
package/                package manifest, installer script, package language files
third_party/juimage/    the official JUImage 5.21 archive, unchanged, and its license
build.sh                builds the archives into dist/ and updates.xml
updates.xml             update server for the package
updates_module.xml      update server for the standalone module
changelog.xml           changelog for Joomla
```

Build: `./build.sh` — needs bash and zip; if php is available the script also checks the syntax. `dist/` gets three archives and a `SHA256SUMS` file, and `updates.xml` and `updates_module.xml` in the root get the new version, links and hashes.

Release order: raise the version in the module and package manifests, add to `changelog.xml` and `CHANGELOG.md`, run `./build.sh`, create the GitHub release `vX.Y.Z` with the three archives and `SHA256SUMS` — and only then push the new update files to `main`. Otherwise sites learn about the version before its archives are in Releases.

## License

The module is distributed under the GNU GPL version 2 or later (`LICENSE`). The article selection logic is derived from the core module `mod_articles` (© Open Source Matters, Inc., GNU GPL).

Third-party components:

- **JUImage** — © Denys Nosov, Joomla! Ukraine; GNU GPL version 2 or later, see `third_party/juimage/LICENSE.md`. Included in the package unchanged.
- **UIkit** — © YOOtheme, MIT license. Not part of the repository or the archives: it comes from the template or a CDN.

## Author

Beibit Sakhanov — [webmarka.kz](https://webmarka.kz)
