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
- **Proportional Logo & Burger Sizing:** Scaled down the header logo on mobile directly to `width: 56px !important` and `height: 50px !important`, and sized the mobile burger menu to match (`width: 65px !important`, `height: 50px !important`). This provides a much more proportional look on narrow viewports. Configured `.eliashof-header` to use `align-items: flex-start !important` so both items align perfectly at the top baseline.
- **Burger Menu Scale Refactoring:** Removed the `transform: scale(0.65)` rule on mobile and styled dimensions directly, preventing visual translation shift or transform-origin offset issues that pushed the burger toggle downwards. Set `.burger-bar` height to `7px !important` (`border-radius: 3.5px !important`).
- **Burger Morph Active State Translation:** Updated the active state transformations on mobile (`translateY(21.5px)` for top, `translateY(-21.5px)` for bottom) to account for the `50px` height container, ensuring the close "X" morph centers perfectly when toggled.
- **Hero Welcome Title Spacing:** Set the first column `padding-top` to `30px !important` inside the mobile media query. This configures a precise `30px` separation gap above the welcome title ("WILLKOMMEN IN...") within the column container while maintaining the `90px` top padding on the outer `.eliashof-hero-wrap` to clear the `50px` header cleanly.

### 14. Version Control Update (Previous)
- **Git Tracking:** Committed the mobile header layout adjustments and spacing refinements in the theme repository (`style.css` and `claude.md`).

### 15. Dynamic Classic Menu Support
- **Classic Menu Support Activation:** Added `register_nav_menus()` in `functions.php` to register the `primary` menu location. This automatically re-enables the classic **Design > Menüs** page in the WordPress dashboard.
- **[eliashof_menu] Shortcode:** Created a custom theme shortcode that renders the assigned classic primary menu via `wp_nav_menu()` with an inline HTML fallback list representing the default 7 pages and hashlinks.
- **Header Template Part Update:** Replaced the static header overlay links in `parts/header.html` with the Gutenberg Shortcode block rendering the dynamic `[eliashof_menu]` shortcode.
- **Menu CSS Style Extensions:** Added style support for standard WordPress menu markup lists (`.burger-menu-nav ul` and `.burger-menu-nav li a`) to ensure both fallbacks and backend-assigned menus style exactly as the original mockups (maintaining fonts, line-heights, letter spacing, hover opacity, and responsive font sizing).

### 16. Version Control Update
- **Git Tracking:** Staged and committed classic menu support and shortcode implementation in the theme repository (`functions.php`, `parts/header.html`, `style.css`, and `claude.md`).



