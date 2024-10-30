<?php
/*
Template Name: ShopifyフォントスタイルCSS
*/

if(!defined('ABSPATH')) exit;

function connect_products_with_shopify_font_style_css($fontStyle)
{
	ob_start();

	if(!empty($fontStyle)){

		if(strstr($fontStyle,'Droid Sans') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Droid Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/droidsans/v12/SlGVmQWMvZQIdix7AFxXkHNSbQ.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Montserrat') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Montserrat';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/montserrat/v15/JTUSjIg1_i6t8kCHKm459WRhyzbi.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Montserrat';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/montserrat/v15/JTUSjIg1_i6t8kCHKm459W1hyzbi.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Montserrat';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/montserrat/v15/JTUSjIg1_i6t8kCHKm459WZhyzbi.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Montserrat';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/montserrat/v15/JTUSjIg1_i6t8kCHKm459Wdhyzbi.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Montserrat';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/montserrat/v15/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Open Sans') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFWJ0bbck.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFUZ0bbck.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFWZ0bbck.woff2) format('woff2');
		unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFVp0bbck.woff2) format('woff2');
		unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFWp0bbck.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFW50bbck.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Open Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/opensans/v20/mem8YaGs126MiZpBA-UFVZ0b.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Karla') == true){ ?>
		/* latin-ext */
		@font-face {
		font-family: 'Karla';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/karla/v15/qkBIXvYC6trAT55ZBi1ueQVIjQTD-JqaHUlKd7c.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Karla';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/karla/v15/qkBIXvYC6trAT55ZBi1ueQVIjQTD-JqaE0lK.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'PT Sans') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'PT Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptsans/v12/jizaRExUiTo99u79D0-ExdGM.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'PT Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptsans/v12/jizaRExUiTo99u79D0aExdGM.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* latin-ext */
		@font-face {
		font-family: 'PT Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptsans/v12/jizaRExUiTo99u79D0yExdGM.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'PT Sans';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptsans/v12/jizaRExUiTo99u79D0KExQ.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Quantico') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Quantico';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/quantico/v10/rax-HiSdp9cPL3KIF7xrJD0.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Roboto') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu72xKOzY.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu5mxKOzY.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu7mxKOzY.woff2) format('woff2');
		unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu4WxKOzY.woff2) format('woff2');
		unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu7WxKOzY.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Roboto';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Raleway') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Raleway';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/raleway/v22/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvaorCFPrEHJA.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Raleway';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/raleway/v22/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvaorCMPrEHJA.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Raleway';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/raleway/v22/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvaorCHPrEHJA.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Raleway';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/raleway/v22/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvaorCGPrEHJA.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Raleway';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/raleway/v22/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvaorCIPrE.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Source Sans Pro') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNa7lqDY.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qPK7lqDY.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNK7lqDY.woff2) format('woff2');
		unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qO67lqDY.woff2) format('woff2');
		unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qN67lqDY.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNq7lqDY.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Source Sans Pro';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/sourcesanspro/v14/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Josefin Slab') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Josefin Slab';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/josefinslab/v13/lW-swjwOK3Ps5GSJlNNkMalNpiZe_ldbOR4W71msR349Kg.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Strait') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Strait';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/strait/v8/DtViJxy6WaEr1LZDfzJs.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Oxygen') == true){ ?>
		/* latin-ext */
		@font-face {
		font-family: 'Oxygen';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/oxygen/v10/2sDfZG1Wl4LcnbuKgE0mV0Q.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Oxygen';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/oxygen/v10/2sDfZG1Wl4LcnbuKjk0m.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Arvo') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Arvo';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/arvo/v14/tDbD2oWUg0MKqScQ7Q.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Crimson Text') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Crimson Text';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/crimsontext/v11/wlp2gwHKFkZgtmSR3NB0oRJfbwhT.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Droid Serif') == true){ ?>
		/* latin */
		@font-face {
		font-family: 'Droid Serif';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/droidserif/v13/tDbI2oqRg1oM3QBjjcaDkOr9rAU.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Lora') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Lora';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/lora/v17/0QI6MX1D_JOuGQbT0gvTJPa787weuxJMkq1umA.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Lora';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/lora/v17/0QI6MX1D_JOuGQbT0gvTJPa787weuxJFkq1umA.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Lora';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/lora/v17/0QI6MX1D_JOuGQbT0gvTJPa787weuxJOkq1umA.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Lora';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/lora/v17/0QI6MX1D_JOuGQbT0gvTJPa787weuxJPkq1umA.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Lora';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/lora/v17/0QI6MX1D_JOuGQbT0gvTJPa787weuxJBkq0.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'PT Serif') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'PT Serif';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptserif/v12/EJRVQgYoZZY2vCFuvAFbzr-tdg.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'PT Serif';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptserif/v12/EJRVQgYoZZY2vCFuvAFSzr-tdg.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* latin-ext */
		@font-face {
		font-family: 'PT Serif';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptserif/v12/EJRVQgYoZZY2vCFuvAFYzr-tdg.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'PT Serif';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/ptserif/v12/EJRVQgYoZZY2vCFuvAFWzr8.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php }if(strstr($fontStyle,'Vollkorn') == true){ ?>
		/* cyrillic-ext */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeE2mcIbA.woff2) format('woff2');
		unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeGmmcIbA.woff2) format('woff2');
		unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeHWmcIbA.woff2) format('woff2');
		unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeEWmcIbA.woff2) format('woff2');
		unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeEGmcIbA.woff2) format('woff2');
		unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		font-family: 'Vollkorn';
		font-style: normal;
		font-weight: 400;
		src: url(https://fonts.gstatic.com/s/vollkorn/v13/0ybgGDoxxrvAnPhYGzMlQLzuMasz6Df2MHGeHmmc.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		<?php
		} //endif

	}

	$fontFace = ob_get_clean();

	return $fontFace;
}
?>