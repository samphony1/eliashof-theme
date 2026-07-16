<?php
/**
 * Title: SPB Angebote
 * Slug: eliashof/section-spb-angebote
 * Categories: eliashof-spb-hort
 * Description: Angebotsübersicht SPB – drei Tages-Spalten mit AG/IG-Filter und Overlay-Anbindung. Hintergrundfarbe wird durch die Editor-Sektion bestimmt.
 * Keywords: SPB, Angebote, AG, IG, Hort
 */

/**
 * Angebotsdaten.
 * Jeder Eintrag: type (ag|ig), title, person, room.
 * Optionales Feld post_id verknüpft das Kästchen mit dem Intern-Drawer.
 *
 * @var array<string, list<array{type:string,title:string,person:string,room:string,post_id?:int}>> $spb_offers
 */
$spb_offers = [
	'dienstag'   => [
		[ 'type' => 'ag', 'title' => 'Yoga',           'person' => 'Delalat',    'room' => 'Raum 011'      ],
		[ 'type' => 'ag', 'title' => 'Modellbau',       'person' => 'Doernbach',  'room' => 'Raum 109'      ],
		[ 'type' => 'ag', 'title' => 'Theater',         'person' => 'Knoka',      'room' => 'Aula'          ],
		[ 'type' => 'ag', 'title' => 'Fu&szlig;ball',   'person' => 'Koch',       'room' => 'Tanzhalle'     ],
		[ 'type' => 'ig', 'title' => 'Freies Malen',    'person' => 'Schuchardt', 'room' => 'Werkstatt'     ],
	],
	'mittwoch'   => [
		[ 'type' => 'ag', 'title' => 'Musterkunst',     'person' => 'Smolny',     'room' => 'Raum 110'      ],
		[ 'type' => 'ag', 'title' => 'Werken',           'person' => 'Minkwitz',   'room' => 'Werkstatt'     ],
		[ 'type' => 'ag', 'title' => 'Improtheater',     'person' => 'Knoka',      'room' => 'Aula'          ],
		[ 'type' => 'ig', 'title' => 'Sportspiele',      'person' => 'Doernbach',  'room' => 'Tanzhalle'     ],
		[ 'type' => 'ig', 'title' => 'Brettspiele',      'person' => 'Straube',    'room' => 'SPB'           ],
	],
	'donnerstag' => [
		[ 'type' => 'ag', 'title' => 'Basteln',          'person' => 'Schuchardt', 'room' => 'Werkstatt'     ],
		[ 'type' => 'ag', 'title' => 'Buchclub',          'person' => 'Koch',       'room' => 'Raum 306/307'  ],
		[ 'type' => 'ig', 'title' => 'Schmuckwerkstatt', 'person' => 'Delalat',    'room' => 'Raum 111'      ],
		[ 'type' => 'ig', 'title' => 'Perlenzauber',     'person' => 'Smolny',     'room' => 'Raum 110'      ],
		[ 'type' => 'ig', 'title' => 'Kochen &amp; Backen', 'person' => 'Minkwitz','room' => 'K&uuml;che'   ],
	],
];

$spb_day_labels = [
	'dienstag'   => 'Dienstag',
	'mittwoch'   => 'Mittwoch',
	'donnerstag' => 'Donnerstag',
];

/* Inline SVG arrow – reused in the card loop. */
$arrow_svg = '<svg class="spb-card-arrow" aria-hidden="true" focusable="false" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">'
	. '<path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'
	. '</svg>';
?>
<!-- wp:group {"align":"full","anchor":"spb-angebote","templateLock":"contentOnly","className":"eliashof-section section-spb-angebote","layout":{"type":"constrained"}} -->
<div id="spb-angebote" class="wp-block-group alignfull eliashof-section section-spb-angebote">

	<!-- wp:group {"className":"spb-header","layout":{"type":"constrained","contentSize":"680px"}} -->
	<div class="wp-block-group spb-header">

		<!-- wp:heading {"level":2,"textAlign":"center"} -->
		<h2 class="wp-block-heading has-text-align-center">ANGEBOTE IM SPB</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">Unsere Arbeits- und Interessengemeinschaften auf einen Blick &#8212; w&auml;hle ein Angebot f&uuml;r mehr Informationen.</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="spb-angebote-interactive">

		<!-- Filter -->
		<div class="spb-filter" role="group" aria-label="Angebote filtern">
			<button class="spb-filter-btn" type="button" data-filter="all" aria-pressed="true">Alle</button>
			<button class="spb-filter-btn" type="button" data-filter="ag"  aria-pressed="false">AG</button>
			<button class="spb-filter-btn" type="button" data-filter="ig"  aria-pressed="false">IG</button>
		</div>

		<!-- Mobile day tabs -->
		<div class="spb-mobile-tabs" role="tablist" aria-label="Wochentag w&auml;hlen">
			<?php $first_tab = true; foreach ( $spb_day_labels as $day_key => $day_label ) : ?>
			<button
				class="spb-tab-btn"
				role="tab"
				id="spb-tab-<?php echo esc_attr( $day_key ); ?>"
				aria-selected="<?php echo $first_tab ? 'true' : 'false'; ?>"
				aria-controls="spb-day-<?php echo esc_attr( $day_key ); ?>"
				tabindex="<?php echo $first_tab ? '0' : '-1'; ?>"
			><?php echo esc_html( $day_label ); ?></button>
			<?php $first_tab = false; endforeach; ?>
		</div>

		<!-- Day columns -->
		<div class="spb-days">
			<?php $first_day = true; foreach ( $spb_offers as $day_key => $cards ) : ?>
			<div
				class="spb-day<?php echo $first_day ? ' is-active-tab' : ''; ?>"
				id="spb-day-<?php echo esc_attr( $day_key ); ?>"
				role="region"
				aria-labelledby="spb-tab-<?php echo esc_attr( $day_key ); ?>"
			>
				<h3 class="spb-day-heading" aria-hidden="true">
					<?php echo esc_html( $spb_day_labels[ $day_key ] ); ?>
				</h3>

				<div class="spb-cards" role="list">
					<?php foreach ( $cards as $offer ) :
						$type    = sanitize_html_class( $offer['type'] );
						$title   = $offer['title']; // already HTML-safe (entities used above)
						$person  = esc_html( $offer['person'] );
						$room    = $offer['room'];   // already HTML-safe (entities used above)
						$post_id = isset( $offer['post_id'] ) ? (int) $offer['post_id'] : 0;
						/* Build plain-text version of title for aria-label */
						$title_plain = html_entity_decode( strip_tags( $title ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
						$room_plain  = html_entity_decode( strip_tags( $room ),  ENT_QUOTES | ENT_HTML5, 'UTF-8' );
						$aria_label  = esc_attr(
							strtoupper( $type ) . ' ' . $title_plain
							. ' – ' . $person
							. ', ' . $room_plain
							. '. Overlay öffnen.'
						);
					?>
					<button
						class="spb-card"
						type="button"
						data-type="<?php echo esc_attr( $type ); ?>"
						<?php if ( $post_id ) : ?>data-post-id="<?php echo $post_id; ?>"<?php endif; ?>
						role="listitem"
						aria-label="<?php echo $aria_label; ?>"
					>
						<span class="spb-badge <?php echo esc_attr( $type ); ?>" aria-hidden="true">
							<?php echo esc_html( strtoupper( $type ) ); ?>
						</span>
						<div class="spb-card-content">
							<div class="spb-card-title"><?php echo $title; ?></div>
							<div class="spb-card-meta"><?php echo $person; ?> &middot; <?php echo $room; ?></div>
						</div>
						<?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG ?>
					</button>
					<?php endforeach; ?>

					<p class="spb-day-empty" aria-live="polite"></p>
				</div>
			</div>
			<?php $first_day = false; endforeach; ?>
		</div><!-- /spb-days -->

	</div><!-- /spb-angebote-interactive -->
	<!-- /wp:html -->

</div>
<!-- /wp:group -->
