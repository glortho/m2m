<?php
if(!function_exists('architectGetTranslation'))
{
	function architectGetTranslation($type)
	{
		$array = array('chars' => array(), 'charsOriginal' => array());
		$array[$type] = array_merge($array[$type], _architectLanguageFrench($type));
		$array[$type] = array_merge($array[$type], _architectLanguageGerman($type));
		$array[$type] = array_merge($array[$type], _architectLanguageCyrillic($type));
		$array[$type] = array_merge($array[$type], _architectLanguageCzech($type));
		$array[$type] = array_merge($array[$type], _architectLanguageGreek($type));
		$array[$type] = array_merge($array[$type], _architectLanguageItalian($type));
		$array[$type] = array_merge($array[$type], _architectLanguageSpanish($type));
		$array[$type] = array_merge($array[$type], _architectLanguagePolish($type));
		$array[$type] = array_merge($array[$type], _architectLanguageRomanian($type));
		$array[$type] = array_merge($array[$type], _architectLanguageTurkish($type));
		$array[$type] = array_merge($array[$type], _architectLanguageOther($type));
		$array[$type] = array_merge($array[$type], _architectLanguageMaths($type));
		
		return $array[$type];
	}
}

if(!function_exists('_architectLanguageFrench'))
{
{
	function _architectLanguageFrench($type)
	{
		$array = array(
			'chars' => array(
				'&Agrave;' => '&#192;', '&agrave;' => '&#224;', '&Acirc;' => '&#194;', '&acirc;' => '&#226;', '&AElig;' => '&#198;', '&aelig;' => '&#230;',
				'&Ccedil;' => '&#199;', '&ccedil;' => '&#231;', '&Egrave;' => '&#200;', '&egrave;' => '&#232;', '&Eacute;' => '&#201;', '&eacute;' => '&#233;',
			 	'&Ecirc;' => '&#202;', '&ecirc;' => '&#234;', '&Euml;' => '&#203;', '&euml;' => '&#235;', '&Icirc;' => '&#206;', '&icirc;' => '&#238;',
				'&Iuml;' => '&#207;', '&iuml;' => '&#239;', '&Ocirc;' => '&#212;', '&ocirc;' => '&#244;', '&OElig;' => '&#140;', '&oelig;' => '&#156;',
				'&Ugrave;' => '&#217;', '&ugrave;' => '&#249;', '&Ucirc;' => '&#219;', '&ucirc;' => '&#251;', '&Uuml;' => '&#220;', '&uuml;' => '&#252;',
				'&euro;' => '&#8364;'
			),
			'charsOriginal' => array(
				'À' => '&#192;','à' => '&#224;','Â' => '&#194;','â' => '&#226;','Æ' => '&#198;',
				'æ' => '&#230;','Ç' => '&#199;','ç' => '&#231;','È' => '&#200;','è' => '&#232;',
				'É' => '&#201;','é' => '&#233;','Ê' => '&#202;','ê' => '&#234;','Ë' => '&#203;',
				'ë' => '&#235;','Î' => '&#206;','î' => '&#238;','Ï' => '&#207;','ï' => '&#239;',
				'Ô' => '&#212;','ô' => '&#244;','Œ' => '&#140;','œ' => '&#156;','Ù' => '&#217;',
				'ù' => '&#249;','Û' => '&#219;','û' => '&#251;','Ü' => '&#220;','ü' => '&#252;',
				'€' => '&#8364;','₣' => '&#8355;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageGerman'))
{
{
	function _architectLanguageGerman($type)
	{
		$array = array(
			'chars' => array(
				'&Auml;' => '&#196;', '&auml;' => '&#228;', '&Ouml;' => '&#214;', '&ouml;' => '&#246;', '&szlig;' => '&#223;'
			),
			'charsOriginal' => array(
				'Ä' => '&#196;','ä' => '&#228;','Ö' => '&#214;','ö' => '&#246;','ß' => '&#223;',
				'°' => '&#176;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageCyrillic'))
{
{
	function _architectLanguageCyrillic($type)
	{
		$array = array(
			'chars' => array(
			),
			'charsOriginal' => array(
				'А' => '&#1040;','а' => '&#1072;','Б' => '&#1041;','б' => '&#1073;','В' => '&#1042;','в' => '&#1074;',
				'Г' => '&#1043;','г' => '&#1075;','Д' => '&#1044;','д' => '&#1076;','Е' => '&#1045;','е' => '&#1077;',
				'Ж' => '&#1046;','ж' => '&#1078;','З' => '&#1047;','з' => '&#1079;','И' => '&#1048;','и' => '&#1080;',
				'Й' => '&#1049;','й' => '&#1081;','К' => '&#1050;','к' => '&#1082;','Л' => '&#1051;','л' => '&#1083;',
				'М' => '&#1052;','м' => '&#1084;','Н' => '&#1053;','н' => '&#1085;','О' => '&#1054;','о' => '&#1086;',
				'П' => '&#1055;','п' => '&#1087;','Р' => '&#1056;','р' => '&#1088;','С' => '&#1057;','с' => '&#1089;',
				'Т' => '&#1058;','т' => '&#1090;','У' => '&#1059;','у' => '&#1091;','Ф' => '&#1060;','ф' => '&#1092;',
				'Х' => '&#1061;','х' => '&#1093;','Ц' => '&#1062;','ц' => '&#1094;','Ч' => '&#1063;','ч' => '&#1095;',
				'Ш' => '&#1064;','ш' => '&#1096;','Щ' => '&#1065;','щ' => '&#1097;','Ъ' => '&#1066;','ъ' => '&#1098;',
				'Ы' => '&#1067;','ы' => '&#1099;','Ь' => '&#1068;','ь' => '&#1100;','Э' => '&#1069;','э' => '&#1101;',
				'Ю' => '&#1070;','ю' => '&#1102;','Я' => '&#1071;','я' => '&#1103;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageCzech'))
{
{
	function _architectLanguageCzech($type)
	{
		$array = array(
			'chars' => array(
				'&Aacute' => '&#193;', '&aacute' => '&#225;', '&Iacute;' => '&#205;', '&iacute' => '&#237;', '&Oacute;' => '&#211;',
				'&oacute;' => '&#243;', '&Uacute;' => '&#218;', '&uacute;' => '&#250;', '&Yacute;' => '&#221;', '&yacute;' => '&#253;'
			),
			'charsOriginal' => array(
				'Á' => '&#193;', 'á' => '&#225;', 'Ą' => '&#260;', 'ą' => '&#261;', 'Ę' => '&#280;', 'ę' => '&#281;',
				'Ě' => '&#282;', 'ě' => '&#283;', 'Í' => '&#205;', 'í' => '&#237;', 'Ó' => '&#211;', 'ó' => '&#243;',
				'Ú' => '&#218;', 'ú' => '&#250;', 'Ů' => '&#366;', 'ů' => '&#367;', 'Ý' => '&#221;', 'ý' => '&#253;',
				'Č' => '&#268;', 'č' => '&#269;', 'ď' => '&#271;', 'ť' => '&#357;', 'Ĺ' => '&#313;', 'ĺ' => '&#314;',
				'Ň' => '&#327;', 'ň' => '&#328;', 'Ŕ' => '&#340;', 'ŕ' => '&#341;', 'Ř' => '&#344;', 'ř' => '&#345;',
				'Š' => '&#352;', 'š' => '&#353;', 'Ž' => '&#381;', 'ž' => '&#382;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageGreek'))
{
{
	function _architectLanguageGreek($type)
	{
		$array = array(
			'chars' => array(
				'&Alpha;' => '&#913;', '&alpha;' => '&#945;', '&Beta;' => '&#914;', '&beta;' => '&#946;', '&Gamma;' => '&#915;', '&gamma;' => '&#947;',
				'&Delta;' => '&#916;', '&delta;' => '&#948;', '&Epsilon;' => '&#917;', '&epsilon;' => '&#949;', '&Zeta;' => '&#918;', '&zeta;' => '&#950;',
				'&Eta;' => '&#919;', '&eta;' => '&#951;', '&Theta;' => '&#920;', '&theta;' => '&#952;', '&Iota;' => '&#921;', '&iota;' => '&#953;',
				'&Kappa;' => '&#922;', '&kappa;' => '&#954;', '&Lambda;' => '&#923;', '&lambda;' => '&#955;', '&Mu;' => '&#924;', '&mu;' => '&#956;',
				'&Nu;' => '&#925;', '&nu;' => '&#957;', '&Xi;' => '&#926;', '&xi;' => '&#958;', '&Omicron;' => '&#927;', '&omicron;' => '&#959;',
				'&Pi;' => '&#928;', '&pi;' => '&#960;', '&Rho;' => '&#929;', '&rho;' => '&#961;', '&Sigma;' => '&#931;', '&sigma;' => '&#963;',
				'&Tau;' => '&#932;', '&tau;' => '&#964;', '&Upsilon;' => '&#933;', '&upsilon;' => '&#965;', '&Phi;' => '&#934;', '&phi;' => '&#966;',
				'&Chi;' => '&#935;', '&chi;' => '&#967;', '&Psi;' => '&#936;', '&psi;' => '&#968;', '&Omega;' => '&#937;', '&omega;' => '&#969;'
			),
			'charsOriginal' => array(
				'Α' => '&#913;', 'α' => '&#945;', 'Β' => '&#914;', 'β' => '&#946;', 'Γ' => '&#915;', 'γ' => '&#947;',
				'Δ' => '&#916;', 'δ' => '&#948;', 'Ε' => '&#917;', 'ε' => '&#949;', 'Ζ' => '&#918;', 'ζ' => '&#950;',
				'Η' => '&#919;', 'η' => '&#951;', 'Θ' => '&#920;', 'θ' => '&#952;', 'Ι' => '&#921;', 'ι' => '&#953;',
				'Κ' => '&#922;', 'κ' => '&#954;', 'Λ' => '&#923;', 'λ' => '&#955;', 'Μ' => '&#924;', 'μ' => '&#956;',
				'Ν' => '&#925;', 'ν' => '&#957;', 'Ξ' => '&#926;', 'ξ' => '&#958;', 'Ο' => '&#927;', 'ο' => '&#959;',
				'Π' => '&#928;', 'π' => '&#960;', 'Ρ' => '&#929;', 'ρ' => '&#961;', 'Σ' => '&#931;', 'σ' => '&#963;',
				'Τ' => '&#932;', 'τ' => '&#964;', 'Υ' => '&#933;', 'υ' => '&#965;', 'Φ' => '&#934;', 'φ' => '&#966;',
				'Χ' => '&#935;', 'χ' => '&#967;', 'Ψ' => '&#936;', 'ψ' => '&#968;', 'Ω' => '&#937;', 'ω' => '&#969;', 'ς' => '&#962;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageItalian'))
{
{
	function _architectLanguageItalian($type)
	{
		$array = array(
			'chars' => array(
				'&Igrave;' => '&#204;', '&igrave;' => '&#236;', '&Ograve;' => '&#210;', '&ograve;' => '&#242;'
			),
			'charsOriginal' => array(
				'Ì' => '&#204;', 'ì' => '&#236;', 'Ò' => '&#210;', 'ò' => '&#242;'
			)
		);
		return $array[$type];
	}
}
}
if(!function_exists('_architectLanguageSpanish'))
{
	function _architectLanguageSpanish($type)
	{
		$array = array(
			'chars' => array(
				'&Ntilde;' => '&#209;', '&ntilde;' => '&#241;'
			),
			'charsOriginal' => array(
				'Ñ' => '&#209;', 'ñ' => '&#241;', '₧' => '&#8359;'
			)
		);
		return $array[$type];
	}
}
if(!function_exists('_architectLanguagePolish'))
{
	function _architectLanguagePolish($type)
	{
		$array = array(
			'chars' => array(),
			'charsOriginal' => array(
				'Ć' => '&#262;', 'ć' => '&#263;', 'Ł' => '&#321;', 'ł' => '&#322;', 'Ń' => '&#323;', 'ń' => '&#324;',
				'Ś' => '&#346;', 'ś' => '&#347;', 'Ź' => '&#377;', 'ź' => '&#378;', 'Ż' => '&#379;', 'ż' => '&#380;'
			)
		);
		return $array[$type];
	}
}
if(!function_exists('_architectLanguageRomanian'))
{
	function _architectLanguageRomanian($type)
	{
		$array = array(
			'chars' => array(),
			'charsOriginal' => array(
				'Ă' => '&#258;', 'ă' => '&#259;', 'Ș' => '&#x218;', 'ș' => '&#x219;', 'Ş' => '&#350;', 'ş' => '&#351;',
				'Ţ' => '&#354;', 'ţ' => '&#355;'
			)
		);
		return $array[$type];
	}
}
if(!function_exists('_architectLanguageTurkish'))
{
	function _architectLanguageTurkish($type)
	{
		$array = array(
			'chars' => array(
			
			),
			'charsOriginal' => array(
				'İ' => '&#304;', 'ı' => '&#305;', 'Ğ' => '&#286;', 'ğ' => '&#287;', '₤' => '&#8356;'
			)
		);
		return $array[$type];
	}
}
if(!function_exists('_architectLanguageOther'))
{
	function _architectLanguageOther($type)
	{
		$array = array(
			'chars' => array(
				'&yuml;' => '&#699;',
				'&tilde;' => '&#126;', '&sbquo;' => '&#130;', '&dbquo;' => '&#132;', '&dagger;' => '&#134;', '&Dagger;' => '&#135;', '&lsaquo;' => '&#139;',
				'&lsquo;' => '&#145;', '&rsquo;' => '&#146;', '&ldquo;' => '&#147;', '&rdquo;' => '&#148;', '&ndash;' => '&#150;', '&mdash;' => '&#151;',
				'&trade;' => '&#153;', '&rsaquo;' => '&#155;', '&iexcl;' => '&#161;', '&brvbar;' => '&#166;', '&copy;' => '&#169;', '&ordf;' => '&#170;',
				'&not;' => '&#172;', '&shy;' => '&#173;', '&reg' => '&#174;', '&deg;' => '&#176;', '&sup2;' => '&#178;', '&sup3;' => '&#179;',
				'&micro;' => '&#181;', '&para;' => '&#182;', '&middot;' => '&#183;', '&sup1;' => '&#185;', '&ordm;' => '&#186;', '&iquest;' => '&#191;',
				'&sect;' => '&#167;', '&oline;' => '&#8254;',
				'&cent;' => '&#162;', '&pound;' => '&#163;', '&curren;' => '&#164;', '&yen;' => '&#165;', '&uml;' => '&#168;', '&macr;' => '&#175;',
				'&acute;' => '&#180;', '&cedil;' => '&#184;',
				'&spades;' => '&#9824;', '&clubs;' => '&#9827;', '&diams;' => '&#9830;', '&hearts;' => '&#9829;',
				'&larr;' => '&#8592;', '&rarr;' => '&#8594;', '&uarr;' => '&#8593;', '&darr;' => '&#8595;'
			),
			'charsOriginal' => array(
				'Ē' => '&#274;', 'ē' => '&#275;', 'Ī' => '&#298;', 'ī' => '&#299;', 'Ō' => '&#322;', 'ō' => '&#333;',
				'Ū' => '&#362;', 'ū' => '&#363;',
				'¡' => '&#161;', '¢' => '&#162;', '£' => '&#163;', '¤' => '&#164;', '¥' => '&#165;', '¦' => '&#166;',
				'§' => '&#167;', '¨' => '&#168;', '©' => '&#169;', 'ª' => '&#170;', '«' => '&#171;', '¬' => '&#172;', 
				'®' => '&#174;', '¯' => '&#175;', '²' => '&#178;', '³' => '&#179;',
				'´' => '&#180;', 'µ' => '&#181;', '¶' => '&#182;', '·' => '#183;', '¸' => '&#184;', '¹' => '&#185;',
				'º' => '&#186;', '»' => '&#187;', '¿' => '&#191;',
				'♯' => '&#9839;'
			)
		);
		return $array[$type];
	}
}
if(!function_exists('_architectLanguageMaths'))
{
	// http://webdesign.about.com/od/localization/l/blhtmlcodes-math.htm
	function _architectLanguageMaths($type)
	{
		$array = array(
			'chars' => array(
				'&plusmn;' => '&#177;', '&divide;' => '#247;', '&frac14;' => '&#188;', '&frac12;' => '&#189;',
				'&frac34;' => '&#190;', '&times;' => '&#215;'
			),
			'charsOriginal' => array(
				'−' => '&#8722;', '±' => '&#177;', '×' => '&#215;', '÷' => '&#247;', '‰' => '&#137;',
				'≠' => '&#8800;', '≈' => '&#8776;','≤' => '&#8804;', '≥' => '&#8805;', '∞' => '&#8734;',
				'⅛' => '&#8539;', '¼' => '&#188;', '⅜' => '&#8540;', '½' => '&#189;', '⅝' => '&#8541;',
				'¾' => '&#190;', '⅞' => '&#8542;', '∫' => '&#8747;', '∂' => '&#8706;', '∆' => '&#8710;',
				'∏' => '&#8719;', '∑' => '&#8721;', '√' => '&#8730;', '∙' => '&#8729;', 'ƒ' => '&#131;',
				'⁄' => '&#8260;'
			)
		);
		return $array[$type];
	}
}
?>