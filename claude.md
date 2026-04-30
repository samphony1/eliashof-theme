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
