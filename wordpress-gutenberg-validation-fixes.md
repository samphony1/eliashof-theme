---
name: wordpress-gutenberg-validation-fixes
description: Guide for diagnosing and resolving Gutenberg block validation errors in WordPress patterns and database content.
---

# WordPress Gutenberg Block Validation Fixes

## Overview
This skill outlines how to identify, analyze, and resolve Gutenberg block validation errors ("Wiederherstellung versuchen" / unexpected block content) in both theme block patterns and WordPress database page contents.

## Workflow

### 1. Diagnosis (Browser Console)
- Log in to the WordPress admin panel using the provided credentials.
- Navigate to the page editor (e.g. `wp-admin/post.php?post=X&action=edit`) or the Site Editor.
- Open the browser developer console.
- Locate the block validation warnings (e.g. `Block validation: Block validation failed for 'core/image' (...)`).
- Extract the **Expected HTML** (what Gutenberg generates from the block attributes) and the **Actual HTML** (what is currently saved).

### 2. Discrepancy Analysis
Analyze the difference between Expected and Actual HTML:
- **Empty Image Blocks**:
  - Gutenberg requires empty `wp:image` blocks to match the expected tag structure based on their attributes (e.g., `sizeSlug`, `linkDestination`, `align`, `style`).
  - Completely empty comments (`<!-- wp:image -->\n<!-- /wp:image -->`) or self-closing comments (`<!-- wp:image /-->`) will fail validation because they lack the expected tags.
  - Standard Formats:
    - Default: `<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->\n<figure class="wp-block-image size-full"><img alt=""/></figure>\n<!-- /wp:image -->`
    - Centered with Custom Link: `<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom"} -->\n<figure class="wp-block-image aligncenter size-full"><a href="#"><img alt=""/></a></figure>\n<!-- /wp:image -->`
- **Dynamic Blocks (like Post Template)**:
  - Dynamic blocks generate their wrappers (e.g. `<li>` inside `core/post-template`) dynamically on the fly. Hardcoding them in the file causes validation errors. Remove them entirely.
- **Nested Paragraphs**:
  - Check for nested `<p>` tags caused by incorrect regexes (e.g. `<p ...><p>...</p></p>`). Flatten them using regex to the outer tag.
- **Heading/Button Styling**:
  - Ensure custom inline styles and classes match Gutenberg's compiler output format (e.g. correct spacing in font families, hook-ordered properties, and editor classes like `has-text-color`).

### 3. Apply Fixes
- **Theme Patterns**: Edit the PHP pattern files in `patterns/` to match the exact expected Gutenberg HTML format.
- **Database Content**: Update or add regex/replace logic to the `init` database migration hook in `functions.php` to clean up the existing page content (`post_content` in `wp_posts`).
- **Newlines**: Ensure that generated database content includes standard newlines (`\n`) after the block opening comments and before the block closing comments.

### 4. Verification
- Run a curl request on the homepage (to trigger the `init` database migration hook).
- Reload the Gutenberg editor page.
- Run JavaScript `sessionStorage.clear(); localStorage.clear();` in the browser console to clear any client-side cached autosaves, then reload the editor again.
- Confirm the developer console is completely free of block validation warnings.
