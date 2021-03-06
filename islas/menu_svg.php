<?php function get_menu_svg($names){ ?>
  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  	 viewBox="0 0 1785 620" style="enable-background:new 0 0 1785 620;" xml:space="preserve">
  <style type="text/css">
  	.flecha{fill:#A0B5C9;}
  	.circulo{fill:#C56E6A;}
  	.cruz{fill:#B60121;}
    .txt-color{fill:#FFFFFF;}
  	/* .txt-color{fill:#000000;} */
  	.txt-tipo{font-family:'Lato-Black';text-anchor:middle;}
  	.txt-tipo-cuerpo{font-size:25px;}

  </style>
  <g id="Layer_menu">
  	<g id="menu">
  		<g id="botonera">
  			<g id="pacifico-sur">
  				<g id="pacifico-sur-union">
  					<g id="circulo-pacifico-sur">
  						<path class="flecha" d="M6,470.4l6.1-6.1c2.8-49.3,43.4-87.9,92.8-88.3l-5.9-5.9l6-6.1C48.9,364.3,2.9,408.4,0.1,464.5L6,470.4z"/>
  						<path class="flecha" d="M104.6,370.1l6.1,6.1c49.3,2.8,87.9,43.4,88.3,92.8l6-6l6,6c-0.4-56.1-44.5-102.1-100.4-104.8
  							L104.6,370.1z"/>
  						<path class="flecha" d="M205,468.6l-6.1,6.1c-2.8,49.3-43.5,87.9-92.8,88.3l6,6l-6,6c56.1-0.4,102.1-44.5,104.8-100.5L205,468.6z
  							"/>
  						<path class="flecha" d="M106.4,569l-6.1-6.1C51,560,12.4,519.4,12,470.1l-6,6L0,470c0.3,56.1,44.4,102.1,100.5,104.9L106.4,569z"
  							/>
  					</g>
  					<g id="circulo-cruz-pacifico-sur">
  						<path class="circulo" d="M105.5,399c15.7,0,28.5-12.7,28.5-28.5S121.3,342,105.5,342S77,354.7,77,370.5c0,0,0,0,0,0
  							C77,386.2,89.8,399,105.5,399L105.5,399"/>
  						<polygon class="cruz" points="102.6,359.2 102.6,368 94.3,368 94.3,373 102.6,373 102.6,381.8 108.3,381.8 108.3,373
  							116.7,373 116.7,368 108.3,368 108.3,359.2 						"/>
  					</g>
  				</g>
          <!-- <text transform="matrix(1 0 0 1 46.2858 464.56)" class="st3 txt-color txt-tipo txt-tipo-cuerpo"> -->
          <text transform="translate(106, 464)" class="st3 txt-color txt-tipo txt-tipo-cuerpo">
            <tspan x="0" y="00" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['pacifico-sur'])[0])?></tspan>
            <tspan x="0" y="30" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['pacifico-sur'])[1])?></tspan>
          </text>
  			</g>
  			<g id="oceano-indico">
  				<g id="ocenao-indico-union">
  					<g id="circulo-oceano-indico">
  						<path class="flecha" d="M1102.5,470.4l6.1-6.1c2.8-49.3,43.4-87.9,92.8-88.3l-5.9-5.9l6.1-6.1c-56.1,0.3-102.2,44.4-104.9,100.5
  							L1102.5,470.4z"/>
  						<path class="flecha" d="M1201.1,370.1l6.1,6.1c49.3,2.8,87.9,43.4,88.3,92.8l6-6l6,6c-0.3-56.1-44.4-102.1-100.4-104.9
  							L1201.1,370.1z"/>
  						<path class="flecha" d="M1301.4,468.6l-6.1,6.1c-2.8,49.3-43.4,87.9-92.8,88.3l6,6l-6,6c56.1-0.3,102.1-44.4,104.9-100.4
  							L1301.4,468.6z"/>
  						<path class="flecha" d="M1202.9,569l-6.1-6.1c-49.3-2.8-87.9-43.4-88.2-92.8l-6,6l-6-6c0.4,56.1,44.5,102.1,100.5,104.8
  							L1202.9,569z"/>
  					</g>
  					<g id="circulo-cruz-oceano-indico">
  						<path class="circulo" d="M1202,399c15.7,0,28.5-12.8,28.5-28.5S1217.7,342,1202,342s-28.5,12.8-28.5,28.5S1186.3,399,1202,399
  							L1202,399"/>
  						<polygon class="cruz" points="1199.1,359.2 1199.1,368 1190.8,368 1190.8,373 1199.1,373 1199.1,381.8 1204.8,381.8
  							1204.8,373 1213.2,373 1213.2,368 1204.8,368 1204.8,359.2 						"/>
  					</g>
  				</g>
          <text transform="translate(1205, 464)" class="st3">
					<!-- <text transform="matrix(1 0 0 1 1149.1725 464.56)" class="st3"> -->
            <tspan x="0" y="00" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['oceano-indico'])[0])?></tspan>
            <tspan x="0" y="30" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['oceano-indico'])[1])?></tspan>
          </text>
  			</g>
  			<g id="atlantico-norte">
  				<g id="atlantico-norte-union">
  					<path id="circulo-atlantico-norte" class="flecha" d="M398.6,131c2.9-61.5,53.2-110.7,114.8-111l-6.6,6.7l6.5,6.6
  						c-54.2,0.3-98.6,43.4-101.6,97.5l-6.7,6.7L398.6,131z M513,26.7l6.7,6.7c53.6,3,96.3,47.8,96.7,102.5l6.5-6.6l6.6,6.7
  						c-0.3-62.1-49-112.9-110-115.8L513,26.7z M622.9,135.6l-6.7,6.7c-3,54.1-47.4,97.1-101.6,97.5l6.5,6.6l-6.6,6.6
  						c61.6-0.3,111.9-49.4,114.8-110.9L622.9,135.6z M515,246.4l-6.7-6.8c-53.6-3-96.3-47.7-96.6-102.4l-6.5,6.6l-6.6-6.7
  						c0.3,62.1,49,112.9,110,115.8L515,246.4z"/>
  					<g id="circulo-cruz-atlantico-norte">
  						<path class="circulo" d="M514,57c15.7,0,28.5-12.8,28.5-28.5S529.7,0,514,0s-28.5,12.8-28.5,28.5S498.3,57,514,57"/>
  						<polygon class="cruz" points="511.1,17.2 511.1,26 502.8,26 502.8,30.9 511.1,30.9 511.1,39.8 516.8,39.8 516.8,30.9
  							525.2,30.9 525.2,26 516.8,26 516.8,17.2 						"/>
  					</g>
  				</g>
          <!-- <text id="atlantico-norte_1_" transform="matrix(1 0 0 1 442.9302 131.57)" class="st3"> -->
          <text id="atlantico-norte_1_" transform="translate(515 131)" class="st3">
            <tspan x="0" y="00" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['atlantico-norte'])[0])?></tspan>
            <tspan x="0" y="30" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['atlantico-norte'])[1])?></tspan>
          </text>
  			</g>
  			<g id="pacifico-norte">
  				<g id="pacifico-norte-union">
  					<path id="circulo-pacifico-norte" class="flecha" d="M1574.1,131.5c2.7-56,48.8-100.2,104.9-100.5l-6,6.1l5.9,6
  						c-49.4,0.4-90,39-92.8,88.3l-6.1,6.1L1574.1,131.5z M1678.6,37.1l6.1,6.1c49.3,2.8,88,43.5,88.3,92.8l6-6l6,6
  						c-0.3-56.1-44.4-102.1-100.4-104.9L1678.6,37.1z M1779,135.6l-6.1,6.1c-2.8,49.3-43.4,87.9-92.8,88.2l6,6l-6,6
  						c56.1-0.3,102.1-44.4,104.8-100.4L1779,135.6z M1680.4,236l-6.1-6.1c-49.3-2.8-87.9-43.4-88.3-92.8l-6,6l-6-6
  						c0.3,56.1,44.5,102.1,100.5,104.8L1680.4,236z"/>
  					<g id="circulo-cruz-pacifico-norte">
  						<path class="circulo" d="M1679.5,66c15.7,0,28.5-12.8,28.5-28.5S1695.3,9,1679.5,9S1651,21.8,1651,37.5S1663.8,66,1679.5,66"/>
  						<polygon class="cruz" points="1676.6,26.2 1676.6,35 1668.3,35 1668.3,40 1676.6,40 1676.6,48.8 1682.3,48.8 1682.3,40
  							1690.7,40 1690.7,35 1682.3,35 1682.3,26.2"/>
  					</g>
  				</g>
          <!-- <text transform="matrix(1 0 0 1 1621.0457 131.57)" class="st3"> -->
          <text transform="translate(1681 131)" class="st3">
            <tspan x="0" y="00" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['pacifico-norte'])[0])?></tspan>
            <tspan x="0" y="30" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['pacifico-norte'])[1])?></tspan>
          </text>
  			</g>
  			<g id="atlantico-sur">
  				<g id="atlantico-sur-union">
  					<path id="circulo-atlantico-norte-2" class="flecha" d="M552.6,498c2.9-61.5,53.2-110.7,114.9-111l-6.6,6.7l6.5,6.6
  						c-54.2,0.4-98.6,43.5-101.6,97.5l-6.7,6.7L552.6,498z M667,393.7l6.7,6.7c53.6,3,96.4,47.8,96.7,102.5l6.5-6.6l6.6,6.7
  						c-0.3-62.1-49-112.9-110-115.8L667,393.7z M776.9,502.5l-6.7,6.7c-3,54-47.3,97.1-101.6,97.5l6.5,6.6l-6.6,6.7
  						c61.6-0.3,111.9-49.4,114.8-110.9L776.9,502.5z M669,613.3l-6.7-6.8c-53.6-3-96.3-47.7-96.6-102.4l-6.5,6.6l-6.6-6.7
  						c0.3,62.1,49,112.9,110,115.8L669,613.3z"/>
  					<g id="circulo-cruz-atlantico-sur">
  						<path class="circulo" d="M668,424c15.7,0,28.5-12.8,28.5-28.5S683.7,367,668,367s-28.5,12.8-28.5,28.5S652.3,424,668,424L668,424"
  							/>
  						<polygon class="cruz" points="665.1,384.2 665.1,393 656.8,393 656.8,397.9 665.1,397.9 665.1,406.8 670.8,406.8 670.8,397.9
  							679.2,397.9 679.2,393 670.8,393 670.8,384.2"/>
  					</g>
  				</g>
          <!-- <text transform="matrix(1 0 0 1 597.4503 498.56)" class="st3"> -->
          <text transform="translate(670 498)" class="st3">
            <tspan x="0" y="00" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['atlantico-sur'])[0])?></tspan>
            <tspan x="0" y="30" class="txt-color txt-tipo txt-tipo-cuerpo"><?=mb_strtoupper(explode(' ',$names['atlantico-sur'])[1])?></tspan>
          </text>
  			</g>
  		</g>
  	</g>
  </g>
  </svg>
<?php } ?>
