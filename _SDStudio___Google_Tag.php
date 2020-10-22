<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_header_code_google_tag_manager_sds_options_and_settings;
$enable_header_code_google_tag_manager_sds_options_and_settings = $redux['enable_header_code_google_tag_manager_sds-options-and-settings'];
global $CODE_enable_google_tag_manager_code_sds_options_and_settings;
$CODE_enable_google_tag_manager_code_sds_options_and_settings = $redux['CODE_enable_google_tag_manager_code_sds-options-and-settings'];

if ($enable_header_code_google_tag_manager_sds_options_and_settings == 1 && !empty($CODE_enable_google_tag_manager_code_sds_options_and_settings)) {
//<!-- Global site tag (gtag.js) - Google Analytics -->
//<script async src="https://www.googletagmanager.com/gtag/js?id=G-2FCK6ZDWTG"></script>

    function SDStudio_Add_GoogleTagManager_GlobalTag_If_User_Scroll() {
        global $CODE_enable_google_tag_manager_code_sds_options_and_settings;
        
        $GoogleTag_GlobalTag_CODE = '';
        $GoogleTag_GlobalTag_CODE .= '                    console.log(\'✅ Google Tag Manager Global Tag подключен\');'."\n";
        $GoogleTag_GlobalTag_CODE .= 'var jq = document.createElement(\'script\');'."\n";
        $GoogleTag_GlobalTag_CODE .= 'jq.src = "https://www.googletagmanager.com/gtag/js?id='.$CODE_enable_google_tag_manager_code_sds_options_and_settings.'";'."\n";
        $GoogleTag_GlobalTag_CODE .= 'document.getElementsByTagName(\'head\')[0].appendChild(jq);'."\n";
        $GoogleTag_GlobalTag_CODE .= ''."\n";
        $GoogleTag_GlobalTag_CODE .= 'setTimeout(function(){'."\n";
        $GoogleTag_GlobalTag_CODE .= 'window.dataLayer = window.dataLayer || [];'."\n";
        $GoogleTag_GlobalTag_CODE .= 'function gtag(){dataLayer.push(arguments);}'."\n";
        $GoogleTag_GlobalTag_CODE .= 'gtag(\'js\', new Date());'."\n";
        $GoogleTag_GlobalTag_CODE .= ''."\n";
        $GoogleTag_GlobalTag_CODE .= 'gtag(\'config\', \''.$CODE_enable_google_tag_manager_code_sds_options_and_settings.'\');'."\n";
        $GoogleTag_GlobalTag_CODE .= '}, 400);'."\n";
        return $GoogleTag_GlobalTag_CODE;
    }

}
