( function( wp ) {
	const { addFilter } = wp.hooks;
	const { createHigherOrderComponent } = wp.compose;
	const { Fragment } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const { PanelBody, Button } = wp.components;
	const { __ } = wp.i18n;

	const THEME_BACKGROUNDS = [
		{ slug: 'blue', label: __( 'Blau', 'eliashof' ), color: '#8cc8d1' },
		{ slug: 'green', label: __( 'Gruen', 'eliashof' ), color: '#c5d799' },
		{ slug: 'beige', label: __( 'Beige', 'eliashof' ), color: '#eec58d' },
		{ slug: 'orange', label: __( 'Orange', 'eliashof' ), color: '#f8ac41' },
		{ slug: 'transparent', label: __( 'Transparent', 'eliashof' ), color: 'transparent' },
	];

	function addThemeBackgroundAttribute( settings ) {
		if ( typeof settings.attributes !== 'object' ) {
			return settings;
		}

		return {
			...settings,
			attributes: {
				...settings.attributes,
				eliashofThemeBg: {
					type: 'string',
					default: '',
				},
			},
		};
	}

	function getThemeBackgroundColor( slug ) {
		const match = THEME_BACKGROUNDS.find( function( option ) {
			return option.slug === slug;
		} );

		return match ? match.color : '';
	}

	function withThemeBackgroundControls( BlockEdit ) {
		return function( props ) {
			const currentThemeBg = props.attributes?.eliashofThemeBg || '';

			return wp.element.createElement(
				Fragment,
				null,
				wp.element.createElement( BlockEdit, props ),
				wp.element.createElement(
					InspectorControls,
					null,
					wp.element.createElement(
						PanelBody,
						{
							title: __( 'Theme Farbe', 'eliashof' ),
							initialOpen: true,
						},
						wp.element.createElement(
							'p',
							null,
							__( 'Waehle eine der vordefinierten Theme-Farben fuer diesen Block.', 'eliashof' )
						),
						wp.element.createElement(
							'div',
							{
								style: {
									display: 'flex',
									gap: '12px',
									flexWrap: 'wrap',
									marginBottom: '12px',
								},
							},
							THEME_BACKGROUNDS.map( function( option ) {
								const isActive = currentThemeBg === option.slug;

								return wp.element.createElement( Button, {
									key: option.slug,
									label: option.label,
									onClick: function() {
										props.setAttributes( { eliashofThemeBg: option.slug } );
									},
									style: {
										width: '36px',
										height: '36px',
										minWidth: '36px',
										padding: 0,
										borderRadius: '999px',
										border: isActive ? '3px solid #241f21' : '1px solid #9b8d7a',
										background: option.color === 'transparent'
											? 'linear-gradient(45deg, #f1f1f1 25%, #ffffff 25%, #ffffff 50%, #f1f1f1 50%, #f1f1f1 75%, #ffffff 75%, #ffffff 100%)'
											: option.color,
										backgroundSize: option.color === 'transparent' ? '12px 12px' : undefined,
									},
								} );
							} )
						),
						wp.element.createElement(
							Button,
							{
								variant: 'tertiary',
								onClick: function() {
									props.setAttributes( { eliashofThemeBg: '' } );
								},
							},
							__( 'Standard verwenden', 'eliashof' )
						)
					)
				)
			);
		};
	}

	const withThemeBackgroundPreview = createHigherOrderComponent( function( BlockListBlock ) {
		return function( props ) {
			const themeBg = props.attributes?.eliashofThemeBg || '';
			const previewColor = getThemeBackgroundColor( themeBg );
			const wrapperProps = {
				...( props.wrapperProps || {} ),
				className: [ props.wrapperProps?.className, themeBg ? 'has-eliashof-theme-bg' : '' ].filter( Boolean ).join( ' ' ),
				style: {
					...( props.wrapperProps?.style || {} ),
					...( previewColor ? { '--eliashof-theme-bg': previewColor } : {} ),
				},
			};

			return wp.element.createElement( BlockListBlock, {
				...props,
				wrapperProps,
			} );
		};
	}, 'withThemeBackgroundPreview' );

	function addThemeBackgroundSaveProps( extraProps, blockType, attributes ) {
		if ( ! blockType?.attributes?.eliashofThemeBg ) {
			return extraProps;
		}

		const themeBg = attributes?.eliashofThemeBg || '';
		const color = getThemeBackgroundColor( themeBg );
		if ( ! color ) {
			return extraProps;
		}

		return {
			...extraProps,
			className: [
				extraProps.className,
				'has-eliashof-theme-bg',
				'has-eliashof-theme-bg-' + themeBg,
			].filter( Boolean ).join( ' ' ),
			style: {
				...( extraProps.style || {} ),
				'--eliashof-theme-bg': color,
			},
		};
	}

	addFilter(
		'blocks.registerBlockType',
		'eliashof/theme-background-attribute',
		addThemeBackgroundAttribute
	);

	addFilter(
		'editor.BlockEdit',
		'eliashof/theme-background-controls',
		withThemeBackgroundControls
	);

	addFilter(
		'editor.BlockListBlock',
		'eliashof/theme-background-preview',
		withThemeBackgroundPreview
	);

	addFilter(
		'blocks.getSaveContent.extraProps',
		'eliashof/theme-background-save-props',
		addThemeBackgroundSaveProps
	);
} )( window.wp );
