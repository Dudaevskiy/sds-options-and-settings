<?php

/**
 *
 * @_2_РАЗМЕРЫ_ИЗОБРАЖЕНИЙ
 *
 */

function sdstudio_get_images_sizes(){
    global $_wp_additional_image_sizes;

    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {

        if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

            $sizes[ $_size ] = array(
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    }

    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    //echo '<pre>';
    //print_r ($sizes);
    //echo '</pre>';
    $sdstudio_data_return;
    foreach ($sizes as $key => $value){
        // if ($value[crop] == 1){ $custom_crop = 'Да';} else { $custom_crop =  'Нет';}
        if (!empty($value['crop']) == 1){ $custom_crop = 'Да';} else { $custom_crop =  'Нет';}
//        echo '<h3>'.$key.'</h3><br>';
        $sdstudio_data_return .= '<h3>'.$key.'</h3>';
        $sdstudio_data_return .= '<ul><li>width - '.$value['width'].'</li>';
        $sdstudio_data_return .= '<li>height - '.$value['height'].'</li>';
        $sdstudio_data_return .= '<li>crop - '.$custom_crop.'</li></ul> <br>';
    }

    if (is_admin()){
        return $sdstudio_data_return;
    }


}