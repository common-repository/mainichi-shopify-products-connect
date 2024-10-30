<?php
/* Template Name: SVG */

if (!defined('ABSPATH')) exit;

/* 左矢印 */
function arrow_left($output,$class) {
	if(!empty($class)){$class = ' '.$class;}else{$class = '';}
	ob_start();
?><svg version="1.1" class="arrowIcon arrowLeft<?php echo $class; ?>" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="308.116px"
	   height="507.717px" viewBox="266.888 43.781 308.116 507.717" enable-background="new 266.888 43.781 308.116 507.717" xml:space="preserve"><path fill="#333333" d="M275.059,277.91L501.013,51.955c10.898-10.898,28.566-10.898,39.463,0l26.354,26.354
	c10.879,10.879,10.899,28.512,0.047,39.416L387.804,297.641l179.073,179.916c10.854,10.902,10.832,28.535-0.047,39.414
	l-26.354,26.354c-10.896,10.897-28.563,10.897-39.461,0L275.06,317.371C264.164,306.475,264.164,288.807,275.059,277.91z"/></svg><?php
	$html = ob_get_clean();

	if($output == 'echo'){
		echo $html;
	}else{
		return $html;
	}
}

/* 右矢印 */
function arrow_right($output,$class) {
	if(!empty($class)){$class = ' '.$class;}else{$class = '';}
	ob_start();
?><svg version="1.1" class="arrowIcon arrowRight<?php echo $class; ?>" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="308.116px"
	   height="507.717px" viewBox="266.888 43.781 308.116 507.717" enable-background="new 266.888 43.781 308.116 507.717" xml:space="preserve"><path fill="#333333" d="M566.833,317.369L340.879,543.324c-10.898,10.898-28.566,10.898-39.463,0l-26.354-26.354
	c-10.879-10.879-10.899-28.512-0.047-39.416l179.073-179.916L275.014,117.723c-10.854-10.902-10.832-28.535,0.047-39.414
	l26.354-26.354c10.896-10.897,28.563-10.897,39.461,0l225.955,225.954C577.728,288.805,577.728,306.473,566.833,317.369z"/></svg><?php
	$html = ob_get_clean();

	if($output == 'echo'){
		echo $html;
	}else{
		return $html;
	}
}

/* 下矢印 */
function arrow_down($output,$class) {
	if(!empty($class)){$class = ' '.$class;}else{$class = '';}
	ob_start();
?><svg version="1.1" class="arrowIcon arrowDown<?php echo $class; ?>" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="507.717px"
	   height="308.117px" viewBox="167.088 143.582 507.717 308.117" enable-background="new 167.088 143.582 507.717 308.117" xml:space="preserve"><path fill="#333333" d="M401.217,443.526L175.261,217.572c-10.898-10.898-10.898-28.566,0-39.463l26.354-26.354
	c10.879-10.879,28.512-10.9,39.416-0.047l179.916,179.073l179.916-179.073c10.902-10.854,28.535-10.832,39.414,0.047l26.354,26.354
	c10.897,10.896,10.897,28.564,0,39.461L440.677,443.525C429.781,454.422,412.113,454.422,401.217,443.526z"/></svg><?php
	$html = ob_get_clean();

	if($output == 'echo'){
		echo $html;
	}else{
		return $html;
	}
}

/* 上矢印 */
function arrow_up($output,$class) {
	if(!empty($class)){$class = ' '.$class;}else{$class = '';}
	ob_start();
?><svg version="1.1" class="arrowIcon arrowUp<?php echo $class; ?>" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="507.717px"
	   height="308.117px" viewBox="167.088 143.582 507.717 308.117" enable-background="new 167.088 143.582 507.717 308.117" xml:space="preserve"><path fill="#333333" d="M440.676,151.753l225.955,225.954c10.898,10.898,10.898,28.566,0,39.463l-26.354,26.354
	c-10.879,10.879-28.512,10.899-39.416,0.047L420.945,264.498L241.029,443.571c-10.902,10.854-28.535,10.832-39.414-0.047
	L175.26,417.17c-10.897-10.896-10.897-28.563,0-39.461l225.954-225.955C412.111,140.857,429.779,140.857,440.676,151.753z"/></svg><?php
	$html = ob_get_clean();

	if($output == 'echo'){
		echo $html;
	}else{
		return $html;
	}
}
?>