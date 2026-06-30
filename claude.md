# Eliashof Theme Development Changelog

## Session Summary: Hero Section & Navigation Integration

This document outlines the recent implementations and structural decisions made for the Eliashof Gutenberg Block Theme to ensure perfect fidelity with the Figma design.

### 1. Global Layout & Background Handling
- **Paper Background Texture:** Set the global `body` background to use `assets/images/paperbg.jpg` with a `linear-gradient` overlay of 70% white (`rgba(255,255,255,0.7)`). This correctly softens the graph paper grid when no content is present.
- **Container Sizing:** Expanded the default WordPress content container. The Hero inner content `.relative-content` now uses `max-width: 1648px` to match the exact Figma grid dimensions.

### 2. Header Positioning
- **Absolute Placement:** The header (`.eliashof-header`) was detached from document flow and absolutely positioned at `top: 77px;` with horizontal padding `clamp(24px, 6vw, 138px)` to ensure the logo and burger menu sit at the exact coordinates specified in the design.

### 3. Hero Section (`patterns/hero.php`)
- **Spacing:** The Hero container (`.eliashof-hero-wrap`) was given `padding-top: 210px;` and `min-height: clamp(900px, 90vh, 1310px);`. This ensures the content pushes down past the absolute header and provides enough vertical space to prevent elements from crashing into each other.
- **Flexbox Alignment:** The right column (`.eliashof-hero-right-col`) was converted to a vertical flex container using `justify-content: space-between`. This cleanly anchors the image to the top-right and the paragraph/CTA button to the bottom-right without requiring absolute positioning.
- **Multiply Blend Mode:** Instead of injecting a dummy "colorbox" `div` into the DOM, the `#eec68e` Hero background tint is handled cleanly via a CSS `::before` pseudo-element on `.bg-graph-yellow`. This overlay is set to `mix-blend-mode: multiply` and `z-index: 0`. The actual content is placed on `z-index: 2`, ensuring the yellow tint beautifully multiplies into the global paper background without affecting the text, photos, or SVG illustrations.
- **Illustration Anchoring:** Extracted `illustration01.svg` from the text column to prevent text wrapping issues. It is now absolutely positioned at `bottom: 0; left: 0;` inside the Hero container. Its size dynamically scales based on the viewport (`width: 48.75%; max-width: 936px;`), matching Figma's exact 1920px canvas specifications while remaining fluidly responsive.

### 4. Interactive Burger Menu Morph & Overlay
- **CSS Morph Animation:** Replaced the static, hard-coded SVG toggle states with a purely CSS-driven HTML hamburger menu (three `.burger-bar` spans). When `.is-active` is toggled:
  - The top bar scales out of existence.
  - The middle bar rotates 45 degrees to form the first line of the "X" and smoothly transitions to orange (`#f39801`).
  - The bottom bar translates upward into the center, rotates -45 degrees, and smoothly transitions to green (`#8cbb13`).
- **Full-Screen Menu Overlay:** Added a fixed `.burger-menu-overlay` underneath the header that fills the viewport with the `#eec68e` background and centers the `Neucha` navigation links.
- **JavaScript Logic:** Created and enqueued `assets/js/navigation.js` to manage the `.is-active` toggle states between the burger button and the overlay, as well as applying `overflow: hidden;` to the `body` to disable background scrolling while the menu is open.

### 5. Alignment & Caching Fixes (Gutenberg Quirks)
- **H1 Vertical Alignment:** Gutenberg blocks natively align to the top. To vertically center the H1 with the adjacent image, `padding-top: clamp(40px, 6vw, 92px) !important;` was applied to the first column. This pushes the H1 down exactly half the height difference between the image and the text.
- **Button Centering:** Applied `justify-content: center !important` to `.eliashof-hero-right-bottom .wp-block-buttons` to horizontally center the "MEHR ERFAHREN" button below the paragraph.
- **WP Admin Bar Gap Fix:** When logged in, WordPress injects `margin-top: 32px` onto `html`. Due to Gutenberg's default block gap, the `<main>` block was inheriting a top margin, pushing the Hero section down and exposing a 32px white strip of the underlying graph paper background. Fixed by aggressively applying `margin-top: 0 !important;` to `main.wp-block-group` and `.eliashof-hero-wrap`.
- **Bypassing Database Cache:** Because Gutenberg saves static HTML patterns into the database when they are inserted into a page (like the Front Page template), modifications to the raw PHP pattern files don't automatically propagate to the front-end. To fix alignments without requiring the user to delete and re-insert the blocks in the Site Editor, robust CSS targeting rules were added to `style.css` to manipulate the raw HTML sitting in the database. The theme version was also bumped to `1.0.2` to break browser CSS caching.

### 6. Version Control
- **Git Tracking:** Initialized a local Git repository in the theme directory and created the first major commit documenting the structural foundation.

## Session Summary: Mobile Responsiveness, Carousel Peek Layout & Button Standardization

### 7. Mobile Header & Overlay Navigation Refinement
- **Header Positioning & Sizing:** Detached header offset from `77px` to `24px` on screen widths under `767px`. Proportionally scaled down the logo to `75px` width and scaled the burger toggle button down using `transform: scale(0.65) !important` to ensure a compact, elegant layout on small mobile screens.
- **Overlay Centering:** Configured the burger menu overlay navigation `.burger-menu-overlay` to use `width: 100vw !important` and `height: 100vh !important`, centering the menu links perfectly with a top padding of `120px` to guarantee zero overlap with logo or toggle buttons. Styled menu links dynamically using `clamp(24px, 7.5vw, 30px)` and line-height `1.2`.
- **Hero Top Padding Adjustment:** Reduced the top padding of the hero container `.eliashof-hero-wrap` to `75px !important` (down from desktop `210px`) to prevent excessive vertical spacing.

### 8. Centered Peek Carousel for Mobile (`patterns/aktuelles.php`)
- **Viewport-Relative Layout (Symmetric Peek):** Set `.eliashof-aktuelles` parent padding to `0 !important` on mobile. Configured the horizontal scroll track (`.wp-block-post-template`) with padding `14vw !important` on the left and right and gap `20px !important`. Individual cards (`li.wp-block-post`) are set to `72vw !important` width.
- *Viewport-Width (vw) Resolution:* Using `vw` units instead of percentages (`%`) ensures that the card size and padding are resolved relative to the absolute viewport width, rather than the track's inner content width. This centers the active card perfectly on the screen while showing preceding/succeeding card boundaries peeking symmetrically on the viewport edges.
- **Dot Navigation Fix:** Correctly resolved `getVisibleCount()` to `1` on mobile inside `assets/js/carousel.js`, rendering exactly 6 navigation dots (one per post) instead of 3.
- **Card Title Scaling:** Scaled card titles to `26px !important` on mobile viewports so that long titles (e.g. "UNSER SOMMERFEST") fit neatly on a single line.

### 9. Global Button Standardization
- **Unified Design System:** Styled all button classes on both desktop and mobile to look identical and share the same styling tokens:
  - Height: `50px !important`
  - Padding: `0 50px !important`
  - Border Radius: `40px !important`
  - Border: `0.7px solid #000000 !important`
  - Background: `#f8ac41 !important` (hover: `#f0a030 !important`)
  - Typography: `Neucha` font (`25px` on desktop, scaled to `20px` on mobile)
  - Centering: `display: inline-flex !important; align-items: center !important; justify-content: center !important;`
  - Hover Animation: Smooth `transform: translateY(-2px) !important` shift.
- **Cleaned Up Duplications:** Removed all section-specific button overrides (for hero, carousel, downloads, and SPB blocks) in `style.css`, reducing stylesheet codebase size by a net of 48 lines.

### 10. Version Control Update (Previous)
- **Git Tracking:** Staged and committed the responsive layout adjustments and button refactoring style rules inside the theme repository.

### 11. Mobile Background Restructuring (`paperbg.jpg`)
- **Red Line Removal:** Shifted the background position to the left using viewport-relative units (`background-position: -15vw 0 !important;`), placing the vertical red notebook line completely off-screen.
- **Horizontal Repeat Prevention:** Set the background repeating to vertical only (`background-repeat: repeat-y !important;`) to prevent the red margin line from reappearing on wider mobile and tablet viewports.
- **Fluid Grid Scaling:** Scaled the checkered pattern dynamically using `background-size: 115vw auto !important`. This makes the grid squares proportionally smaller (~9px on mobile phones, ~18px on tablets) compared to the desktop size (~40px) while ensuring full horizontal viewport coverage.

### 12. Version Control Update (Previous)
- **Git Tracking:** Committed the mobile background restructuring styles inside the theme repository (`style.css` and `claude.md`).

### 13. Mobile Header & Hero Spacing Refinements
- **Standard Logo Sizing Preservation:** Retained the mobile logo at its original size (`width: 75px !important` and `height: 66px !important`).
- **Half-Size Burger Icon & Hitbox:** Reduced the visual size of the burger menu morph container by exactly half relative to the logo (`width: 43px !important` and `height: 33px !important`) to make it look elegant. Wrapped it in a larger `8px` padding hitbox (`width: 59px`, `height: 49px` total button size, shifted up by `margin-top: -8px` to align baselines) to ensure comfortable touch target access for the index finger. Set the individual burger bars to `5px` height (`border-radius: 2.5px`).
- **Burger Morph Active State Translation:** Updated the active state transformations on mobile (`translateY(14px)` for top, `translateY(-14px)` for bottom) to account for the `33px` height container, ensuring the close "X" morph centers perfectly when toggled.
- **Hero Welcome Title Spacing:** Set the first column `padding-top` to `30px !important` inside the mobile media query. This configures a precise `30px` separation gap above the welcome title ("WILLKOMMEN IN...") within the column container while maintaining the `110px` top padding on the outer `.eliashof-hero-wrap` to clear the `66px` header area cleanly.

### 14. Version Control Update (Previous)
- **Git Tracking:** Committed the mobile header layout adjustments and spacing refinements in the theme repository (`style.css` and `claude.md`).

### 15. Dynamic Classic Menu Support
- **Classic Menu Support Activation:** Added `register_nav_menus()` in `functions.php` to register the `primary` menu location. This automatically re-enables the classic **Design > Menüs** page in the WordPress dashboard.
- **[eliashof_menu] Shortcode:** Created a custom theme shortcode that renders the assigned classic primary menu via `wp_nav_menu()` with an inline HTML fallback list representing the default 7 pages and hashlinks.
- **Header Template Part Update:** Replaced the static header overlay links in `parts/header.html` with the Gutenberg Shortcode block rendering the dynamic `[eliashof_menu]` shortcode.
- **Menu CSS Style Extensions:** Added style support for standard WordPress menu markup lists (`.burger-menu-nav ul` and `.burger-menu-nav li a`) to ensure both fallbacks and backend-assigned menus style exactly as the original mockups (maintaining fonts, line-heights, letter spacing, hover opacity, and responsive font sizing).

### 16. Version Control Update
- **Git Tracking:** Staged and committed classic menu support and shortcode implementation in the theme repository (`functions.php`, `parts/header.html`, `style.css`, and `claude.md`).

## Session Summary: Revert Mobile Logo Size Change to 50px Height

### 17. Reverted Mobile Logo size & Smaller Burger Menu
- **Reverted Logo Sizing:** Returned the mobile logo to `50px` height (`56px` width) as scaled down previously.
- **Scaled Burger Menu:** Sized the burger menu morph container to `25px` height (`32px` width), which is exactly half of the logo height.
- **Hitbox/Padding:** Adjusted the burger button padding to `10px !important`, resulting in a `45px` height touch target for comfortable index-finger accessibility. Top aligned both logo and burger container (`margin-top: -10px`).
- **Burger Morph Active State Translation:** Updated translation offsets to `10.5px` to center the "X" correctly.
- **Mobile Morphing Fix:** Overrode the active states `.burger-toggle.is-active .burger-middle` and `.burger-toggle.is-active .burger-bottom` inside the mobile media query, setting `width: 32px !important` and `left: 0 !important`. This overrides the inherited desktop dimensions (`56px` width, `left: 3px`), ensuring the close "X" morph centers and aligns perfectly inside the smaller `32px` mobile container.
- **Hero Top Padding Adjustment:** Changed the top padding of the hero container `.eliashof-hero-wrap` to `90px !important` to match the `50px` header layout cleanly.

## Session Summary: Back to Top Button Implementation

### 18. Back to Top Button
- **HTML Element:** Embedded a `<button id="back-to-top" ...>` with an inline arrow SVG inside `parts/footer.html` and `patterns/footer-section.php`.
- **CSS Styling:** Fixed-positioned at the bottom right (`bottom: 30px; right: 30px;`) with a circular orange background (`#f8ac41`), dark border (`0.7px solid #000000`), custom hover colors, keyboard focus visibility (`focus-visible`), and a fluid scaling/fade-in animation (`opacity` and `transform`). Micro-animation lifts the arrow icon up by `-2px` on hover.
- **Scroll Behavior JS:** Appended to `assets/js/navigation.js` to listen for the scroll event, fade in the button once `scrollY > 300` pixels, and smoothly scroll back to the top of the viewport on click.

## Session Summary: Subpage Header Overlap Protection

### 19. Subpage Header Spacing
- **Automatic Top Spacing:** Added a CSS selector targeting `.wp-block-post-content > :first-child:not(.eliashof-hero-wrap)` and `.entry-content > :first-child:not(.eliashof-hero-wrap)`.
- **Responsive Offsets:** Set `padding-top: 210px !important` on desktop and `padding-top: 90px !important` on mobile under the `767px` media query. This pushes down the first block of any subpage to start cleanly below the absolute header. Using `padding-top` ensures that full-bleed sections with background colors or images still extend cleanly under the transparent header overlay, maintaining design fidelity.

## Session Summary: Color Refactoring with CSS Variables

### 20. Color Refactoring to :root
- **CSS Variables Block:** Declared all brand and layout colors (yellow backgrounds, orange buttons/hover, green highlights, text colors, white, black, blue/green accents) as CSS Custom Properties (variables) in the `:root` pseudo-class at the top of `style.css`.
- **References:** Replaced all hardcoded hex color values throughout `style.css` with references to these variables (`var(--color-...)`), making it simple to change color schemes globally.

### 21. Version Control Update
- **Git Tracking:** Committed the CSS variables refactoring, subpage header spacing rules, Back to Top button files, and changelog updates inside the theme repository.

## Session Summary: Subpage & Blog Post Hero Implementation

### 22. Subpage & Blog Post Hero Section Layout
- **Box-Sizing Reset:** Added `box-sizing: border-box` to `.eliashof-subpage-hero` and all descendants to resolve padding width expansion and completely fix the horizontal overflow/scrollbar issues.
- **Header Spacing Fix:** Reconfigured the hero block top spacing to start below the absolute-positioned transparent header, setting `padding-top: 210px` on desktop and `padding-top: 90px !important` on mobile under the `991px` media query.
- **Figma Background Opacity:** Set the background color overlay opacity on `.bg-graph-blue::before` to `0.4` (40%) to match the Figma mockups.
- **Transparent SVG Illustration:** Replaced the non-transparent `illustration-children-line.png` with `illustration-children-line.svg` (copied from `illustration03.svg`) in the templates, patterns, and mockup layouts, rendering crisp line-art vectors without border boxes.
- **New dynamic `hero-blog` Block Pattern:** Created a new pattern `patterns/hero-blog.php` (slug `eliashof/hero-blog`) that uses `wp:post-title` and `wp:post-featured-image`. Referenced it in `templates/single.html` to automatically render post titles on the right and featured images on the left.

### 23. Version Control Update
- **Git Tracking:** Staged and committed new files and changes to the Git repository.

## Session Summary: Hero Spacing Adjustments & Post Content Layout Upgrades

### 24. Layout Alignment and Spacing Refinements
- **Illustration Anchor Offset:** Moved `.eliashof-hero-blog-schule-illustration` to be a direct child of the container, setting `bottom: -4px` and aligning it with the content column right edge. This anchors the children line drawing flush against the bottom edge of the blue hero, leaving no background gaps underneath.
- **Top Padding Adjustment:** Adjusted the hero desktop `padding-top` to `150px` (down from `210px`) to match the user's updated layout preferences.
- **Empty Featured Image Box Container:** Introduced `.eliashof-hero-blog-schule-featured-img-container` with border, border-radius (`65px` desktop), and shadow. When no featured image is uploaded on a post, the box container remains visible as a blank rounded placeholder, displaying the graph background inside it and maintaining the 45% column layout width.
- **Figma Post Content Block Layout:** Configured `.eliashof-subpage-content-wrapper` to use a flex column with a gap of `45px` on desktop and `30px` on mobile, aligning direct child elements. Styled paragraphs (`p`) using Montserrat Light, 24px (fluid scaling), black color, and `1.67` line-height (~40px) to match Figma specifications.
- **Embedded Media Support:** Added style definitions for embedded images and videos inside the content wrapper, applying matching rounded corners (`border-radius: 20px`) and thin black borders.
- **Resolved First-Paragraph Padding Conflict:** Excluded pages containing `.eliashof-hero-blog-schule` or `.eliashof-hero-wrap` from inheriting the global `210px` header push-down rule, resetting first-child top padding to `0` to keep content aligned right under the hero.
- **Gutenberg Layout Constraints Fix:** Removed `layout: {"type":"constrained"}` parameter settings from the navigation block pattern inside `templates/single.html` to prevent Gutenberg from injecting layout margin overrides.
- **Eliashof Post Navigation Buttons:** Appended Previous Post, Next Post, and a centered Zurück zur Startseite navigation button row inside `templates/single.html` sharing standard brand styles (orange background, Neucha typography). Added `box-sizing: border-box !important` to center buttons side-by-side on desktop without clipping.
- **Automatic Browser Cache Busting:** Enqueued the theme stylesheet in `functions.php` using the file modification timestamp (`filemtime`) as the version number, forcing instant updates on stylesheet changes.
- **Subpage Hero Mobile Order & Spacing:** Re-ordered elements responsively inside the `@media (max-width: 991px)` media query: Title/Heading appears at the top (`order: 1`), Featured Image in the middle (`order: 2`), and Children Illustration centered at the bottom (`order: 3`), with vertical gap spacing reduced to a clean `24px` layout.
- **Restored Homepage Hero Padding:** Fixed padding-top collapse on the homepage hero block by limiting first-child padding-top resets strictly to content wrapper elements on subpages.
- **Aligned Desktop Header Top Offset:** Lifted the desktop absolute header `.eliashof-header` top spacing from `77px` to `50px` for a clean layout balance.
- **Renamed to Hero Blog & Schule:** Renamed CSS classes from `.eliashof-subpage-hero` to `.eliashof-hero-blog-schule` and consolidated the patterns into a single unified dynamic pattern `patterns/hero-blog-schule.php` (slug `eliashof/hero-blog-schule`).
- **Updated Hero Spacing Padding:** Configured `.eliashof-hero-blog-schule-container` with a `66px` top padding on desktop, and set `padding-top: 20px !important` on mobile.
- **Created Modular Section Snippets:** Replaced the master "page-unsere-schule" pattern with six separate modular block patterns: `patterns/section-textbox.php` (transparent textbox below hero), `patterns/section-ueber-uns.php` (solid green grid matching SPB layout), `patterns/section-leitbild.php` (transparent Leitbild block), `patterns/section-parallax.php` (full-width parallax image section), `patterns/section-ausstattung.php` (transparent Ausstattung block), and `patterns/section-lebenskunde-religion.php` (two-column sky blue background section using native Columns block).
- **Added Style Utilities:** Implemented `.bg-graph-green`, `.bg-graph-orange`, and `.bg-graph-yellow` as solid background colors (hiding grid pseudo-elements) to match Figma layouts. Restored the transparent, blended paper grid lines for the blue hero background (`.bg-graph-blue`).
- **Aligned Section Ueber Uns with SPB Styling:** Configured the green "Über uns" section to match the SPB layout structure, custom image borders (`49.3px`), content gaps, and alternating rows (Row 1: Text Left / Image Right; Row 2: Image Left / Text Right) without buttons, and enabled layout locking (`templateLock: contentOnly`).
- **Synchronized Textblock Paddings & Widths:** Configured identical horizontal padding (`clamp(24px, 10.8vw, 208px)`) and maximum container width (`1497px`) for all sections. Migrated both the Downloads and Lebenskunde & Religion sections to native Gutenberg Columns (`wp-block-columns` / `wp-block-column` with `50%` basis) to match SPB layout structures, aligning all left/right column edges perfectly across the entire page layout.
- **Preconfigured Block HTML Anchors:** Added default HTML anchor definitions (`id="..."` and Gutenberg `"anchor"` block attributes) on the parent container blocks of all 15 custom Eliashof block patterns to support direct hash linking in menus (e.g. `#ueber-uns`, `#foerderverein`, `#section-ausstattung`, `#section-lebenskunde-religion`, etc.) even when layout editing is locked.
- **Auto-assigned Database Anchors:** Programmatically updated and auto-assigned HTML anchors (`anchor` block properties and corresponding HTML `id` attributes) to all matching section blocks on existing database-stored pages (e.g., "Unsere Schule", "Willkommen").
- **Parallax Background Integration:** Integrated the new Parallax image section using a native Gutenberg `core/cover` block with a pre-configured height of `902.9px` and a custom photography asset (`unsere-schule-parallax.png`) depicting a child reading a book outdoors. Optimised its mobile view to scale down to `450px`.
- **Lebenskunde & Religion Section:** Repurposed the two-column downloads layout into the `section-lebenskunde-religion` pattern, featuring a custom sky blue (`#9DE4F9`) background color, centered Neucha headers, left-aligned body text paragraphs (with left margin aligned perfectly to the column start), and custom CTA buttons. Downloads section columns text is kept centered.
- **Kooperationen Section Pattern:** Repurposed the two-column highlights (Förderverein) block layout to create the new `section-kooperationen` pattern (slug `eliashof/section-kooperationen`) with a solid light green background (`#D0E5A7`), custom image with `49.3px` rounded borders, and left-aligned text parameters.
- **Media Library Sync:** Programmatically imported and registered 61 local image files from Google Drive into the WordPress Media Library with full thumbnail generation.
- **Footer Gap Fixes:** Removed Gutenberg's default top margins on the FSE `footer` element and hid empty editor paragraphs (`p:empty`) inside page entries to resolve the horizontal gap displaying layout background paper grid lines.
- **Translucent Yellow Hero Background:** Converted `.bg-graph-yellow` back to use a translucent multiply-blend overlay (`background-color: transparent !important`, `mix-blend-mode: multiply`, using color `#eec68e`), allowing the underlying paper grid pattern to shine through as specified in Figma.
- **School/Blog Hero Image Proportions:** Resized the columns of `.eliashof-hero-blog-schule` to match Figma specifications: set the image column to `43.05%`, content column to `51.95%`, and set the image container to the exact aspect ratio `828.67 / 546.75`.
- **Responsive Background Scaling:** Configured `body` background grid pattern to scale dynamically with the screen width on desktop screens (`background-size: 100% auto; background-repeat: repeat-y;` on viewports >= 992px) to keep the vertical red margin line perfectly aligned with the left edge of the header logo at all resolutions.

### 25. Version Control Update
- **Git Tracking:** Staged and committed layout refinements, new block patterns, footer gap fixes, translucent yellow hero styling matching Figma color specifications, school hero image layouts, background scaling rules, and documentation updates inside the theme repository.
