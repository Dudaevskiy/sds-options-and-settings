<?php
/**
 * Parses the string into variables without the max_input_vars limitation.
 *
 * https://github.com/reduxframework/redux-framework/issues/2631#issue-108373168
 *
 * @since   1.0
 * @access  public
 * @param   string $string
 * @return  array $result
 */
if ( !function_exists( 'redux_parse_str' ) ) {
    function redux_parse_str( $string ) {

        if ( '' == $string ) {
            return false;
        }

        $result = array();
        $pairs = explode( '&', urldecode( $string ) );

        foreach ( $pairs as $key => $pair ) {

            // use the original parse_str() on each element
            parse_str( $pair, $params );

            $k=key( $params );

            if( ! isset( $result[$k] ) ) {
                $result+=$params;
            } else {
                $result[$k] = redux_array_merge_recursive_distinct( $result[$k], $params[$k] );
            }
        }

        return $result;
    }
}

/**
 * Merge arrays without converting values with duplicate keys to arrays as array_merge_recursive does.
 *
 * As seen here http://php.net/manual/en/function.array-merge-recursive.php#92195
 *
 * @since   1.0
 * @access  public
 * @param   array $array1
 * @param   array $array2
 * @return  array $merged
 */
if ( !function_exists( 'redux_array_merge_recursive_distinct' ) ) {
    function redux_array_merge_recursive_distinct( array $array1, array $array2 ) {
        $merged = $array1;
        foreach ( $array2 as $key => $value ) {
            if ( is_array( $value ) && isset( $merged[$key] ) && is_array( $merged[$key] ) ) {
                $merged[$key] = redux_array_merge_recursive_distinct ( $merged[$key], $value );
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}