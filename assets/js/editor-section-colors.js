( function( wp ) {
	const { addFilter } = wp.hooks;
	const { createHigherOrderComponent } = wp.compose;
	const { Fragment } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const { PanelBody, Button, ButtonGroup, RangeControl } = wp.components;
	const { useSelect } = wp.data;
	const { __ } = wp.i18n;

	const THEME_BACKGROUNDS = [
		{ slug: 'blue', label: __( 'Blau – Fläche', 'eliashof' ), color: '#9de4f9' },
		{ slug: 'spb-ag-text', label: __( 'SPB AG – Blau', 'eliashof' ), color: '#23bbea' },
		{ slug: 'green', label: __( 'Grün', 'eliashof' ), color: '#c5d799' },
		{ slug: 'orange', label: __( 'Orange – Fläche', 'eliashof' ), color: '#eec58d' },
		{ slug: 'yellow', label: __( 'SPB IG – Orange', 'eliashof' ), color: '#f8ac41' },
		{ slug: 'brown', label: __( 'Braun', 'eliashof' ), color: '#57463a' },
		{ slug: 'dark', label: __( 'Dunkel', 'eliashof' ), color: '#241f21' },
		{ slug: 'cream', label: __( 'Creme', 'eliashof' ), color: '#eae7dd' },
		{ slug: 'white', label: __( 'Weiß', 'eliashof' ), color: '#ffffff' },
		{ slug: 'black', label: __( 'Schwarz', 'eliashof' ), color: '#000000' },
		{ slug: 'transparent', label: __( 'Transparent', 'eliashof' ), color: 'transparent' },
	];

	function isValuesShape( props ) {
		return ( props.attributes?.className || '' ).split( /\s+/ ).includes( 'eliashof-spb-werte__item' );
	}

	function addThemeBackgroundAttribute( settings, blockName ) {
		if ( typeof settings.attributes !== 'object' ) {
			return settings;
		}

		const attributes = {
			...settings.attributes,
			eliashofThemeBg: {
				type: 'string',
				default: '',
			},
		};

		if ( blockName === 'core/paragraph' ) {
			attributes.eliashofTextWidth = {
				type: 'number',
			};
			attributes.eliashofTextPosition = {
				type: 'string',
			};
		}

		return {
			...settings,
			attributes,
		};
	}

	function getThemeBackgroundColor( slug ) {
		const aliases = {
			'blue-bright': 'spb-ag-text',
			beige: 'orange',
		};
		slug = aliases[ slug ] || slug;
		const match = THEME_BACKGROUNDS.find( function( option ) {
			return option.slug === slug;
		} );

		return match ? match.color : '';
	}

	function withThemeBackgroundControls( BlockEdit ) {
		return function( props ) {
			const currentThemeBg = props.attributes?.eliashofThemeBg || '';
			const valuesShape = isValuesShape( props );
			const isSpbHeaderParagraph = useSelect( function( select ) {
				if ( props.name !== 'core/paragraph' || ! props.clientId ) {
					return false;
				}

				const blockEditor = select( 'core/block-editor' );
				return blockEditor.getBlockParents( props.clientId ).some( function( parentId ) {
					const parent = blockEditor.getBlock( parentId );
					return ( parent?.attributes?.className || '' ).split( /\s+/ ).includes( 'spb-header' );
				} );
			}, [ props.clientId, props.name ] );

			return wp.element.createElement(
				Fragment,
				null,
				wp.element.createElement( BlockEdit, props ),
				wp.element.createElement(
					InspectorControls,
					null,
					isSpbHeaderParagraph && wp.element.createElement(
						PanelBody,
						{
							title: __( 'Textlayout', 'eliashof' ),
							initialOpen: true,
						},
						wp.element.createElement( RangeControl, {
							label: __( 'Textbreite', 'eliashof' ),
							value: props.attributes.eliashofTextWidth || 1100,
							min: 320,
							max: 1400,
							step: 20,
							onChange: function( value ) {
								props.setAttributes( { eliashofTextWidth: value || 1100 } );
							},
						} ),
						wp.element.createElement( 'p', null, __( 'Ausrichtung', 'eliashof' ) ),
						wp.element.createElement(
							ButtonGroup,
							null,
							[ 'center', 'left' ].map( function( position ) {
								const active = ( props.attributes.eliashofTextPosition || 'center' ) === position;
								return wp.element.createElement(
									Button,
									{
										key: position,
										variant: active ? 'primary' : 'secondary',
										onClick: function() {
											props.setAttributes( { eliashofTextPosition: position } );
										},
									},
									position === 'center' ? __( 'Zentriert', 'eliashof' ) : __( 'Links', 'eliashof' )
								);
							} )
						)
					),
					wp.element.createElement(
						PanelBody,
						{
							title: valuesShape ? __( 'Formfarbe', 'eliashof' ) : __( 'Theme Farbe', 'eliashof' ),
							initialOpen: true,
						},
						wp.element.createElement(
							'p',
							null,
							valuesShape
								? __( 'Wähle die Farbe für diese Form.', 'eliashof' )
								: __( 'Wähle eine der vordefinierten Theme-Farben für diesen Block.', 'eliashof' )
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
			const spbSectionClass = useSelect( function( select ) {
				if ( props.name !== 'core/group' || ! props.clientId ) {
					return '';
				}

				const headings = select( 'core/block-editor' ).getBlocks( props.clientId )
					.filter( function( block ) { return block.name === 'core/heading'; } )
					.map( function( block ) { return String( block.attributes?.content || '' ).replace( /<[^>]+>/g, '' ); } );

				if ( headings.some( function( heading ) { return heading.includes( 'SO SIEHT UNSER BETREUUNGSTAG AUS' ); } ) ) {
					return 'eliashof-spb-day';
				}
				if ( headings.some( function( heading ) { return heading.includes( 'BETREUUNG ANMELDEN' ); } ) ) {
					return 'eliashof-spb-signup';
				}
				return '';
			}, [ props.clientId, props.name ] );
			const themeBg = props.attributes?.eliashofThemeBg || '';
			const previewColor = getThemeBackgroundColor( themeBg );
			const textWidth = props.name === 'core/paragraph' ? props.attributes?.eliashofTextWidth : 0;
			const textPosition = props.name === 'core/paragraph' ? props.attributes?.eliashofTextPosition : '';
			const wrapperProps = {
				...( props.wrapperProps || {} ),
				className: [
					props.wrapperProps?.className,
					spbSectionClass,
					themeBg ? 'has-eliashof-theme-bg' : '',
					textWidth ? 'has-eliashof-text-layout is-text-position-' + textPosition : '',
				].filter( Boolean ).join( ' ' ),
				style: {
					...( props.wrapperProps?.style || {} ),
					...( previewColor ? { '--eliashof-theme-bg': previewColor } : {} ),
					...( textWidth ? { '--eliashof-text-width': textWidth + 'px' } : {} ),
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

	function addTextLayoutSaveProps( extraProps, blockType, attributes ) {
		if ( blockType.name !== 'core/paragraph' || ! blockType?.attributes?.eliashofTextWidth ) {
			return extraProps;
		}

		const width = attributes?.eliashofTextWidth;
		const position = attributes?.eliashofTextPosition;
		if ( ! width && ! position ) {
			return extraProps;
		}

		return {
			...extraProps,
			className: [
				extraProps.className,
				'has-eliashof-text-layout',
				position ? 'is-text-position-' + position : '',
			].filter( Boolean ).join( ' ' ),
			style: {
				...( extraProps.style || {} ),
				...( width ? { '--eliashof-text-width': width + 'px' } : {} ),
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

	addFilter(
		'blocks.getSaveContent.extraProps',
		'eliashof/text-layout-save-props',
		addTextLayoutSaveProps
	);
} )( window.wp );
